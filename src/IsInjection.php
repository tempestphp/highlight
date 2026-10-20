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

                $replacement = str_replace(
                    search: $content,
                    replace: $this->parseContent($content, $highlighter),
                    subject: $fullMatch,
                );

                if ($replacement !== $fullMatch) {
                    $replacements[] = [$offset, strlen($fullMatch), strlen($replacement)];
                }

                return $replacement;
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
