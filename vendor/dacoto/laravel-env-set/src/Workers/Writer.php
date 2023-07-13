<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Workers;

use dacoto\EnvSet\Contracts\Formatter as EnvSetFormatterContract;
use dacoto\EnvSet\Exceptions\UnableWriteToFileException;

class Writer implements \dacoto\EnvSet\Contracts\Writer
{
    protected string $buffer;
    protected EnvSetFormatterContract $formatter;

    public function __construct(EnvSetFormatterContract $formatter)
    {
        $this->formatter = $formatter;
    }

    public function setBuffer(string $content): self
    {
        if (! empty($content)) {
            $content = rtrim((string) $content) . PHP_EOL;
        }
        $this->buffer = $content;

        return $this;
    }

    public function appendEmptyLine(): self
    {
        return $this->appendLine();
    }

    protected function appendLine(string $text = null): self
    {
        $this->buffer .= $text . PHP_EOL;

        return $this;
    }

    public function appendCommentLine(string $comment): self
    {
        return $this->appendLine('# ' . $comment);
    }

    public function appendSetter(string $key, string $value = null, string $comment = null, bool $export = false): self
    {
        $line = $this->formatter->formatSetterLine($key, (string) $value, $comment, $export);

        return $this->appendLine($line);
    }

    public function updateSetter(string $key, string $value = null, string $comment = null, bool $export = false): self
    {
        $pattern = "/^(export\h)?\h*{$key}=.*/m";
        $line = $this->formatter->formatSetterLine($key, (string) $value, $comment, $export);
        $this->buffer = (string) preg_replace_callback($pattern, static function () use ($line) {
            return $line;
        }, $this->buffer);

        return $this;
    }

    public function deleteSetter(string $key): object
    {
        $pattern = "/^(export\h)?\h*{$key}=.*\n/m";
        $this->buffer = (string) preg_replace($pattern, '', $this->buffer);

        return $this;
    }

    /**
     * @throws UnableWriteToFileException
     */
    public function save(string $filePath): self
    {
        $this->ensureFileIsWritable($filePath);
        file_put_contents($filePath, $this->buffer);

        return $this;
    }

    /**
     * @throws UnableWriteToFileException
     */
    protected function ensureFileIsWritable(string $filePath): void
    {
        if ((is_file($filePath) && ! is_writable($filePath)) || (! is_file($filePath) && ! is_writable(dirname($filePath)))) {
            throw new UnableWriteToFileException(sprintf('Unable to write to the file at %s.', $filePath));
        }
    }
}
