<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;

final class CustomClassInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): string
    {
        $pattern = '/\{\:(?<class>[\w-]+)\:(?<match>(.|\n)*?)\:\}/';

        preg_match_all($pattern, $content, $matches);

        if ($matches[0] === []) {
            return $content;
        }

        foreach ($matches[0] as $key => $match) {
            $contentForMatch = $matches['match'][$key];
            $classForMatch = $matches['class'][$key];

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
