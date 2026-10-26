<?php

declare(strict_types=1);

namespace Tempest\Highlight;

trait IsInjection
{
    abstract public function getPattern(): string;

    abstract public function parseContent(string $content, Highlighter $highlighter): string;

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $pattern = $this->getPattern();

        if (($pattern[0] ?? '') !== '/') {
            $pattern = "/{$pattern}/";
        }

        $replacements = [];

        $result = preg_replace_callback(
            pattern: $pattern,
            callback: function (array $matches) use ($highlighter, &$replacements): string {
                [$fullMatch, $offset] = $matches[0];

                $content = $matches['match'][0] ?? '';

                if ($content === '' || $content === '0') {
                    return $fullMatch;
                }

                $parsedContent = $this->parseContent($content, $highlighter);

                if ($parsedContent === $content) {
                    return $fullMatch;
                }

                // Only the parsed content is rewritten, the rest of the match stays the same.
                // Every occurrence that str_replace() will replace is reported on its own.
                $position = 0;

                while (($position = strpos($fullMatch, $content, $position)) !== false) {
                    $replacements[] = [$offset + $position, strlen($content), strlen($parsedContent)];
                    $position += strlen($content);
                }

                return str_replace(
                    search: $content,
                    replace: $parsedContent,
                    subject: $fullMatch,
                );
            },
            subject: $content,
            flags: PREG_OFFSET_CAPTURE,
        );

        if ($result === null) {
            return new ParsedInjection($content);
        }

        return new ParsedInjection(
            content: $result,
            replacements: $replacements,
        );
    }
}
