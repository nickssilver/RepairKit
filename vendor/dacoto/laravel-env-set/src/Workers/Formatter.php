<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Workers;

use dacoto\EnvSet\Exceptions\InvalidValueException;

class Formatter implements \dacoto\EnvSet\Contracts\Formatter
{
    /**
     * Build a setter line from the individual components for writing.
     *
     * @param string|null $comment optional
     * @param bool $export optional
     */
    public function formatSetterLine(string $key, string $value = null, string $comment = null, bool $export = false): string
    {
        $forceQuotes = ($comment !== '' && trim((string) $value) === '');
        $value = (string) $this->formatValue((string) $value, $forceQuotes);
        $key = $this->formatKey($key);
        $comment = $this->formatComment((string) $comment);
        $export = $export ? 'export ' : '';

        return "{$export}{$key}={$value}{$comment}";
    }

    /**
     * Formatting the value of setter to writing.
     */
    public function formatValue(string $value, bool $forceQuotes = false): string
    {
        if (empty($value)) {
            $value = '';
        }

        if (! $forceQuotes && ! preg_match('/[#\s"\'\\\\]|\\\\n/', (string) $value)) {
            return (string) $value;
        }

        $value = (string) str_replace(['\\', '"'], ['\\\\', '\"'], (string) $value);

        return "\"{$value}\"";
    }

    /**
     * Formatting the key of setter to writing.
     */
    public function formatKey(string $key): string
    {
        return trim((string) str_replace(['export ', '\'', '"', ' '], '', $key));
    }

    /**
     * Formatting the comment to writing.
     */
    public function formatComment(string $comment): string
    {
        $comment = trim((string) $comment, '# ');

        return ($comment !== '') ? " # {$comment}" : '';
    }

    /**
     * @throws InvalidValueException
     */
    public function parseLine(string $line): array
    {
        $output = [
            'type' => null,
            'export' => null,
            'key' => null,
            'value' => null,
            'comment' => null,
        ];

        if ($this->isEmpty($line)) {
            $output['type'] = 'empty';
        } elseif ($this->isComment($line)) {
            $output['type'] = 'comment';
            $output['comment'] = $this->normaliseComment($line);
        } elseif ($this->looksLikeSetter($line)) {
            [$key, $data] = array_map('trim', explode('=', $line, 2));
            $export = $this->isExportKey($key);
            $key = $this->normaliseKey($key);
            $data = trim((string) $data);

            if (! $data && $data !== '0') {
                $value = '';
                $comment = '';
            } elseif ($this->beginsWithAQuote($data)) { // data starts with a quote
                $quote = $data[0];
                $regexPattern = sprintf(
                    '/^
                    %1$s          # match a quote at the start of the data
                    (             # capturing sub-pattern used
                     (?:          # we do not need to capture this
                      [^%1$s\\\\] # any character other than a quote or backslash
                      |\\\\\\\\   # or two backslashes together
                      |\\\\%1$s   # or an escaped quote e.g \"
                     )*           # as many characters that match the previous rules
                    )             # end of the capturing sub-pattern
                    %1$s          # and the closing quote
                    (.*)$         # and discard any string after the closing quote
                    /mx',
                    $quote
                );

                $value = (string) preg_replace($regexPattern, '$1', $data);
                $extant = preg_replace($regexPattern, '$2', $data);

                $value = $this->normaliseValue((string) $value, $quote);
                $comment = $this->isComment((string) $extant) ? $this->normaliseComment((string) $extant) : '';
            } else {
                $parts = explode(' #', $data, 2);
                $value = (string) $this->normaliseValue($parts[0]);
                $comment = (isset($parts[1])) ? $this->normaliseComment($parts[1]) : '';

                // Unquoted values cannot contain whitespace
                if (preg_match('/\s+/', (string) $value) > 0) {
                    throw new InvalidValueException('Dotenv values containing spaces must be surrounded by quotes.');
                }
            }

            $output['type'] = 'setter';
            $output['export'] = $export;
            $output['key'] = $key;
            $output['value'] = (string) $value;
            $output['comment'] = $comment;
        } else {
            $output['type'] = 'unknown';
        }

        return $output;
    }

    /**
     * Determine if the line in the file is empty line.
     */
    protected function isEmpty(string $line): bool
    {
        return trim((string) $line) === '';
    }

    /**
     * Determine if the line in the file is a comment, e.g. begins with a #.
     */
    protected function isComment(string $line): bool
    {
        return str_starts_with(ltrim((string) $line), '#');
    }

    /**
     * Normalising the comment to reading.
     */
    public function normaliseComment(string $comment): string
    {
        return trim((string) $comment, '# ');
    }

    /**
     * Determine if the given line looks like it's setting a key.
     */
    protected function looksLikeSetter(string $line): bool
    {
        return str_contains($line, '=') && ! str_starts_with($line, '=');
    }

    /**
     * Determine if the given key begins with 'export '.
     */
    protected function isExportKey(string $key): bool
    {
        $pattern = '/^export\h.*$/';

        if (preg_match($pattern, trim((string) $key))) {
            return true;
        }

        return false;
    }

    /**
     * Normalising the key of setter to reading.
     */
    public function normaliseKey(string $key): string
    {
        return $this->formatKey($key);
    }

    /**
     * Determine if the given string begins with a quote.
     */
    protected function beginsWithAQuote(string $data): bool
    {
        return strpbrk($data[0], '"\'') !== false;
    }

    /**
     * Normalising the value of setter to reading.
     */
    public function normaliseValue(string $value, string $quote = ''): string
    {
        if ($quote === '') {
            return trim((string) $value);
        }

        return (string) str_replace(["\\$quote", '\\\\'], [$quote, '\\'], $value);
    }
}
