<?php

namespace Tempest\Highlight\Languages\Pxp\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PxpGenericTypeInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        preg_match_all('/\<(?<match>[\w,\s]+)\>/', $content, $matches);

        $tokens = [];

        foreach ($matches['match'] as $match) {
            $genericTypes = explode(',', $match);

            foreach ($genericTypes as $genericTypeMatch) {
                $genericTypeMatch = trim($genericTypeMatch);

                preg_match_all(
                    pattern: '/\b(?<genericClass>' . $genericTypeMatch . ')\b/',
                    subject: $content,
                    matches: $genericClassMatches,
                    flags: PREG_OFFSET_CAPTURE
                );
                
                foreach ($genericClassMatches['genericClass'] as $genericClassMatch) {
                    $tokens[] = new Token(
                        offset: $genericClassMatch[1],
                        value: $genericClassMatch[0],
                        type: TokenTypeEnum::GENERIC,
                    );
                }
            }
        }

        return new ParsedInjection($content, $tokens);
    }
}