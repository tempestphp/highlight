<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Highlighter;

trait IsHighlightInjection
{
    abstract private function getToken(): string;

    abstract private function getClassname(): string;

    public function parse(string $content, Highlighter $highlighter): string
    {
        $token = '\\' . $this->getToken();

        $pattern = '/\{' . $token . '(?<match>(.|\n)*?)' . $token . '}/';

        preg_match($pattern, $content, $matches);

        if ($matches === []) {
            return $content;
        }

        $content = preg_replace_callback(
            $pattern,
            function (array $matches) use ($highlighter) {
                $parsed = $highlighter->parse($matches['match'], $highlighter->getCurrentLanguage());

                return '<span class="'. $this->getClassname() .'">' . $parsed . '</span>';
            },
            $content
        );

        return $highlighter->parse($content, $highlighter->getCurrentLanguage());
    }
}
