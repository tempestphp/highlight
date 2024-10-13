<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PhpHeredocInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $heredocTokenType = TokenTypeEnum::PROPERTY;
        $theme = $highlighter->getTheme();

        preg_match_all('/<<<(?<language>[\w]+)\b/', $content, $languageMatches);

        // First we'll search for all Heredoc open tags,
        // which we need in order to find the close tag, and so the whole Heredoc block
        foreach ($languageMatches['language'] as $language) {
            preg_match_all('/<<<' . $language . '(?<match>(.|\n)*?)' . $language . '(?:;|\s|\))/', $content, $matches);

            foreach ($matches['match'] as $key => $match) {
                $fullMatch = $matches[0][$key];

                $parsed = str_replace(
                    [
                            $match,             // The Heredoc contents will be parsed with the language derived from the token
                            "<<<{$language}",   // The open tag will be highlighted as a property
                            "{$language};",      // The close tag will be highlighted as a property
                        ],
                    [
                            Escape::injection($highlighter->parse($match, strtolower($language))),
                            '<<<' . Escape::tokens($theme->before($heredocTokenType) . $language . $theme->after($heredocTokenType)),
                            Escape::tokens($theme->before($heredocTokenType) . $language . $theme->after($heredocTokenType)) . ';',
                        ],
                    $fullMatch,
                );

                // Replace the while Heredoc match with the parsed content
                $content = str_replace(
                    search: $fullMatch,
                    replace: $parsed,
                    subject: $content,
                );
            }
        }

        return new ParsedInjection($content);
    }
}
