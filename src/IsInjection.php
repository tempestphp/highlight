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

        if (! str_starts_with($pattern, '/')) {
            $pattern = "/{$pattern}/";
        }

        $result = preg_replace_callback(
            pattern: $pattern,
            callback: function ($matches) use ($highlighter) {
                $content = $matches['match'] ?? '';

                if (! $content) {
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
