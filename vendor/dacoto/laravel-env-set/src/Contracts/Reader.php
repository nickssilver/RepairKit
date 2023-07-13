<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Contracts;

interface Reader
{
    /**
     * Load .env file.
     */
    public function load(string $filePath): self;

    /**
     * Get content of .env file.
     */
    public function content(): string;

    /**
     * Get all lines information's from content of .env file.
     */
    public function lines(): array;

    /**
     * Get all key information's in .env file.
     */
    public function keys(): array;
}
