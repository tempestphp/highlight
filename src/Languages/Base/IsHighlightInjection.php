<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;

trait IsHighlightInjection
{
    abstract private function getToken(): string;

    abstract private function getClassname(): string;

    public function parse(string $content, Highlighter $highlighter): string
    {
        $token = '\\' . $this->getToken();

        $pattern = '/\{' . $token . '(?<match>(.|\n)*?)' . $token . '}(?!})/';

        preg_match_all($pattern, $content, $matches);

        if ($matches[0] === []) {
            return $content;
        }

        foreach ($matches[0] as $key => $match) {
            $contentForMatch = $matches['match'][$key];
            $classForMatch = $this->getClassname();

            $parsed = $highlighter->parse($contentForMatch, $highlighter->getCurrentLanguage());

            $theme = $highlighter->getTheme();

            $content = str_replace(
                search: $match,
                replace:
                    Escape::tokens($theme->before($classForMatch))
                    . $parsed
                    . Escape::tokens($theme->after($classForMatch)),
                subject: $content,
            );
        }

        return $highlighter->parse($content, $highlighter->getCurrentLanguage());
    }
}
