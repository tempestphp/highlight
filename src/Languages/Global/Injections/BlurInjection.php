<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Global\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;

final readonly class BlurInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): string
    {
        $pattern = '/\{\~(?<match>(.|\n)*?)\~\}/';

        preg_match($pattern, $content, $matches);

        if ($matches === []) {
            return $content;
        }

        $content = preg_replace_callback(
            $pattern,
            function (array $matches) use ($highlighter) {
                $parsed = $highlighter->parse($matches['match'], $highlighter->getCurrentLanguage());

                return '<span class="hl-blur">' . $parsed . '</span>';
            },
            $content
        );

        return $highlighter->parse($content, $highlighter->getCurrentLanguage());
    }
}
