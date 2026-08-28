<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\Languages\Diff\DiffTokenType;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\Token;

class DiffDeletionInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        preg_match_all('/^(?<match>-(?!--(?:\s|$)).*)$/m', $content, $matches, PREG_OFFSET_CAPTURE);

        $tokens = [];

        foreach ($matches['match'] as $match) {
            $tokens[] = new Token(
                offset: $match[1],
                value: $match[0],
                type: DiffTokenType::DELETION,
            );
        }

        return new ParsedInjection($content, $tokens);
    }
}
