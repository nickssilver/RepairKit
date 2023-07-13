<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Contracts;

interface Writer
{
    /**
     * Load current content into buffer.
     */
    public function setBuffer(string $content): self;

    /**
     * Append empty line to buffer.
     */
    public function appendEmptyLine(): self;

    /**
     * Append comment line to buffer.
     */
    public function appendCommentLine(string $comment): self;

    /**
     * Append one setter to buffer.
     */
    public function appendSetter(string $key, string $value = null, string $comment = null, bool $export = false): self;

    /**
     * Update one setter in buffer.
     */
    public function updateSetter(string $key, string $value = null, string $comment = null, bool $export = false): self;

    /**
     * Delete one setter in buffer.
     */
    public function deleteSetter(string $key): object;

    /**
     * Save buffer to special file path.
     */
    public function save(string $filePath): self;
}
