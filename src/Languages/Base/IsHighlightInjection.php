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

        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        $tokens = [];

        foreach ($matches[0] as $key => $original) {
            $tokens[] = new Token(
                offset: (int) $matches['start'][$key][1],
                value: $matches['start'][$key][0],
                type: TokenTypeEnum::HIDDEN,
            );

            $tokens[] = new Token(
                offset: (int) $matches['match'][$key][1],
                value: $matches['match'][$key][0],
                type: new DynamicTokenType($this->getClassname()),
            );

            $tokens[] = new Token(
                offset: (int) $matches['end'][$key][1],
                value: $matches['end'][$key][0],
                type: TokenTypeEnum::HIDDEN,
            );
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }
}
