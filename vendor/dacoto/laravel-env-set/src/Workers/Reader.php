<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Workers;

use dacoto\EnvSet\Contracts\Formatter as EnvSetFormatterContract;
use dacoto\EnvSet\Exceptions\UnableReadFileException;

class Reader implements \dacoto\EnvSet\Contracts\Reader
{
    protected string $filePath;
    protected EnvSetFormatterContract $formatter;

    public function __construct(EnvSetFormatterContract $formatter)
    {
        $this->formatter = $formatter;
    }

    public function load(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @throws UnableReadFileException
     */
    public function content(): string
    {
        $this->ensureFileIsReadable();

        return (string) file_get_contents($this->filePath);
    }

    /**
     * @throws UnableReadFileException
     */
    protected function ensureFileIsReadable(): void
    {
        if (! is_readable($this->filePath) || ! is_file($this->filePath)) {
            throw new UnableReadFileException(sprintf('Unable to read the file at %s.', $this->filePath));
        }
    }

    /**
     * @throws UnableReadFileException
     */
    public function lines(): array
    {
        $content = [];
        $lines = $this->readLinesFromFile();

        foreach ($lines as $row => $line) {
            $data = [
                'line' => $row + 1,
                'raw_data' => $line,
                'parsed_data' => $this->formatter->parseLine($line),
            ];

            $content[] = $data;
        }

        return $content;
    }

    /**
     * @throws UnableReadFileException
     */
    protected function readLinesFromFile(): array
    {
        $this->ensureFileIsReadable();

        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES);
        ini_set('auto_detect_line_endings', $autodetect);

        return is_array($lines) ? $lines : [];
    }

    /**
     * @throws UnableReadFileException
     */
    public function keys(): array
    {
        $content = [];
        $lines = $this->readLinesFromFile();

        foreach ($lines as $row => $line) {
            $data = $this->formatter->parseLine($line);

            if ($data['type'] === 'setter') {
                $content[$data['key']] = [
                    'line' => $row + 1,
                    'export' => $data['export'],
                    'value' => $data['value'],
                    'comment' => $data['comment'],
                ];
            }
        }

        return $content;
    }
}
