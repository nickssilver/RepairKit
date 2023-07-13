<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Contracts;

interface Formatter
{
    /**
     * Formatting the key of setter to writing.
     */
    public function formatKey(string $key): string;

    /**
     * Formatting the value of setter to writing.
     */
    public function formatValue(string $value, bool $forceQuotes = false): string;

    /**
     * Formatting the comment to writing.
     */
    public function formatComment(string $comment): string;

    /**
     * Build an setter line from the individual components for writing.
     *
     * @param  string|null  $comment  optional
     * @param  bool  $export  optional
     */
    public function formatSetterLine(string $key, string $value = null, string $comment = null, bool $export = false): string;

    /**
     * Normalising the key of setter to reading.
     */
    public function normaliseKey(string $key): string;

    /**
     * Normalising the value of setter to reading.
     */
    public function normaliseValue(string $value, string $quote = ''): string;

    /**
     * Normalising the comment to reading.
     */
    public function normaliseComment(string $comment): string;

    /**
     * Parse a line into an array of type, export, key, value and comment.
     */
    public function parseLine(string $line): array;
}
