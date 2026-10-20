<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[RequiresSubstring('@template', '<')]
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

        if ($genericTypes === []) {
            return new ParsedInjection($content);
        }

        $theme = $highlighter->getTheme();
        $before = Escape::tokens($theme->before(TokenTypeEnum::GENERIC));
        $after = Escape::tokens($theme->after(TokenTypeEnum::GENERIC));

        // One constant pattern instead of one per type name: user-derived patterns would churn PHP's regex cache
        $content = preg_replace_callback(
            '/\w+/',
            fn (array $match): string => isset($genericTypes[$match[0]])
                ? $before . $match[0] . $after
                : $match[0],
            $content,
        );

        return new ParsedInjection($content);
    }
}
