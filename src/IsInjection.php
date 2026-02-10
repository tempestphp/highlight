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

        $result = preg_replace_callback(
            pattern: $pattern,
            callback: function (array $matches) use ($highlighter): string {
                $content = $matches['match'] ?? '';

                if ($content === '' || $content === '0') {
                    return $matches[0];
                }

                return str_replace(
                    search: $content,
                    replace: $this->parseContent($content, $highlighter),
                    subject: $matches[0],
                );
            },
            subject: $content,
        );

        return new ParsedInjection($result ?? $content);
    }
}
