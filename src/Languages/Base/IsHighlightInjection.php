<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\Token;

trait IsHighlightInjection
{
    abstract private function getToken(): string;

    abstract private function getClassname(): string;

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $token = '\\' . $this->getToken();

        $pattern = '/\{' . $token . '(?<match>(.|\n)*?)' . $token . '}(?!})/';

        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        $tokens = [];

        if ($matches[0] === []) {
            return new ParsedInjection($content);
        }

        foreach ($matches[0] as $key => $match) {
            // Get rid of the highlight tokens themselves
            $content = str_replace(
                search: $match[0],
                replace: $matches['match'][$key][0],
                subject: $content,
            );

            $tokens[] = new Token(
                offset: $match[1],
                value: $matches['match'][$key][0],
                type: new DynamicTokenType($this->getClassname()),
            );
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }
}
