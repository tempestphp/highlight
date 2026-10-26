<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

trait IsHighlightInjection
{
    abstract private function getToken(): string;

    abstract private function getClassname(): string;

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $token = '\\' . $this->getToken();

        $pattern = '/(?<start>{' . $token . ')(?<match>(.|\n)*?)(?<end>' . $token . '})(?!})/';

        $tokens = [];
        $offset = 0;

        while (preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE, $offset) === 1) {
            if ($this->leavesItsBraces($match['match'][0])) {
                $offset = (int)$match['start'][1] + 1;

                continue;
            }

            $tokens[] = new Token(
                offset: (int)$match['start'][1],
                value: $match['start'][0],
                type: TokenTypeEnum::HIDDEN,
            );

            $tokens[] = new Token(
                offset: (int)$match['match'][1],
                value: $match['match'][0],
                type: new DynamicTokenType($this->getClassname()),
            );

            $tokens[] = new Token(
                offset: (int)$match['end'][1],
                value: $match['end'][0],
                type: TokenTypeEnum::HIDDEN,
            );

            $offset = (int)$match['end'][1] + strlen($match['end'][0]);
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }

    /**
     * In code like `const {_id} = a; const {name_} = b;`, the brace of `{_` is closed by the code itself,
     * so the matched content leaves one pair of braces and ends inside another: `id} = a; const {name`.
     * Real markers can wrap an unbalanced `{` or `}`, but never a `}` followed by a `{` that stays open.
     */
    private function leavesItsBraces(string $match): bool
    {
        $depth = 0;
        $lowestDepth = 0;

        foreach (str_split($match) as $character) {
            if ($character === '{') {
                $depth++;
            } elseif ($character === '}') {
                $depth--;
                $lowestDepth = min($lowestDepth, $depth);
            }
        }

        return $lowestDepth < 0 && $depth > $lowestDepth;
    }
}
