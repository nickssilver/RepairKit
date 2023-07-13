<?php

declare(strict_types=1);

namespace dacoto\EnvSet;

use dacoto\EnvSet\Exceptions\KeyNotFoundException;
use dacoto\EnvSet\Workers\Formatter;
use dacoto\EnvSet\Workers\Reader;
use dacoto\EnvSet\Workers\Writer;
use Illuminate\Contracts\Container\Container;

final class EnvSetEditor
{
    private Container $app;
    private Formatter $formatter;
    private Reader $reader;
    private Writer $writer;
    private string|null $filePath;

    /**
     * EnvSetEditor constructor.
     * @throws Exceptions\UnableReadFileException
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->formatter = new Formatter();
        $this->reader = new Reader($this->formatter);
        $this->writer = new Writer($this->formatter);
        $this->load();
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function load(string $filePath = null): self
    {
        $this->resetContent();

        if (! is_null($filePath)) {
            $this->filePath = $filePath;
        } elseif (method_exists($this->app, 'environmentPath') && method_exists($this->app, 'environmentFile')) {
            $this->filePath = $this->app->environmentPath() . '/' . $this->app->environmentFile();
        } else {
            $this->filePath = __DIR__ . '/../../../../../../.env';
        }

        $this->reader->load($this->filePath);

        if (file_exists($this->filePath)) {
            $this->writer->setBuffer($this->getContent());

            return $this;
        }

        return $this;
    }

    protected function resetContent(): void
    {
        $this->filePath = null;
        $this->reader->load((string) null);
        $this->writer->setBuffer((string) null);
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function getContent(): string
    {
        return $this->reader->content();
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function getLines(): array
    {
        return $this->reader->lines();
    }

    /**
     * @throws KeyNotFoundException
     * @throws Exceptions\UnableReadFileException
     */
    public function getValue(string $key): mixed
    {
        $allKeys = $this->getKeys([$key]);

        if (array_key_exists($key, $allKeys)) {
            return $allKeys[$key]['value'];
        }

        throw new KeyNotFoundException('Requested key not found in your file.');
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function getKeys(array $keys = []): array
    {
        $allKeys = $this->reader->keys();

        return array_filter($allKeys, static function ($key) use ($keys) {
            if (! empty($keys)) {
                return in_array($key, $keys, true);
            }

            return true;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function addEmpty(): self
    {
        $this->writer->appendEmptyLine();

        return $this;
    }

    public function addComment(string $comment): self
    {
        $this->writer->appendCommentLine($comment);

        return $this;
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function setKey(string $key, string $value = null, string $comment = null, bool $export = false): self
    {
        $value = (string) $value;
        $data = [compact('key', 'value', 'comment', 'export')];

        return $this->setKeys($data);
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function setKeys(array $data): self
    {
        foreach ($data as $i => $setter) {
            if (! is_array($setter)) {
                if (! is_string($i)) {
                    continue;
                }
                $setter = [
                    'key' => $i,
                    'value' => $setter,
                ];
            }
            if (array_key_exists('key', $setter)) {
                $key = $this->formatter->formatKey($setter['key']);
                $value = $setter['value'] ?? null;
                $comment = $setter['comment'] ?? null;
                $export = array_key_exists('export', $setter) ? $setter['export'] : false;

                if (! is_file((string) $this->filePath) || ! $this->keyExists($key)) {
                    $this->writer->appendSetter($key, (string) $value, $comment, $export);
                } else {
                    $oldInfo = $this->getKeys([$key]);
                    $comment = is_null($comment) ? $oldInfo[$key]['comment'] : $comment;

                    $this->writer->updateSetter($key, (string) $value, $comment, $export);
                }
            }
        }

        return $this;
    }

    /**
     * @throws Exceptions\UnableReadFileException
     */
    public function keyExists(string $key): bool
    {
        $allKeys = $this->getKeys();

        return array_key_exists($key, $allKeys);
    }

    public function deleteKey(string $key): self
    {
        $keys = [$key];

        return $this->deleteKeys($keys);
    }

    public function deleteKeys(array $keys = []): self
    {
        foreach ($keys as $key) {
            $this->writer->deleteSetter($key);
        }

        return $this;
    }

    /**
     * @throws Exceptions\UnableWriteToFileException
     */
    public function save(): self
    {
        $this->writer->save((string) $this->filePath);

        return $this;
    }
}
