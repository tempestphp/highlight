<?php

namespace Tempest\Highlight\Languages\Global\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;

final readonly class EmphasizeInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): string
    {
        $pattern = '/\{\_(?<match>(.|\n)*?)\_\}/';

        preg_match($pattern, $content, $matches);

        if ($matches === []) {
            return $content;
        }

        $content = preg_replace_callback(
            $pattern,
            function (array $matches) use ($highlighter) {
                $parsed = $highlighter->parse($matches['match'], $highlighter->getCurrentLanguage());

                return '<span class="hl-em">' . $parsed . '</span>';
            },
            $content
        );

        return $highlighter->parse($content, $highlighter->getCurrentLanguage());
    }

}