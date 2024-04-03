<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PhpGenericTypeInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $genericTypes = [];

        preg_match_all('/\@template(\s)+(?<match>[\w]+)/', $content, $templateMatches);

        foreach ($templateMatches['match'] as $templateMatch) {
            $genericTypes[$templateMatch] = $templateMatch;
        }

        preg_match_all('/\<(?<match>[\w]+)\>/', $content, $genericMatches);

        foreach ($genericMatches['match'] as $genericMatch) {
            $genericTypes[$genericMatch] = $genericMatch;
        }

        $theme = $highlighter->getTheme();

        foreach ($genericTypes as $genericType) {
            $content = preg_replace(
                '/\b' . $genericType . '\b/',
                Escape::tokens($theme->before(TokenTypeEnum::GENERIC))
                . $genericType
                . Escape::tokens($theme->after(TokenTypeEnum::GENERIC)),
                $content,
            );
        }

        return new ParsedInjection($content);
    }
}
