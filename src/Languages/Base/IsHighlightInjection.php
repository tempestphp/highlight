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

        $pattern = '/(?<start>{' . $token . ')(?<match>[\s\S]*?)(?<end>' . $token . '})(?!})/';

        $subject = $content;
        $closer = $this->getToken() . '}';

        // An escaped single non-alphanumeric byte is a literal, so no match can end after the last valid closer
        // and unclosed openers past it are never rescanned to the end. The extra byte feeds the (?!}) lookahead.
        if (strlen($closer) === 2 && ! str_contains('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $closer[0])) {
            $firstOpener = strpos($content, '{' . $this->getToken());
            $lastCloser = $firstOpener === false ? false : strrpos($content, $closer, $firstOpener);

            while ($lastCloser !== false && ($content[$lastCloser + 2] ?? '') === '}') {
                $lastCloser = $lastCloser > 0 ? strrpos($content, $closer, $lastCloser - 1 - strlen($content)) : false;
            }

            $subject = $lastCloser === false ? '' : substr($content, 0, $lastCloser + 3);
        }

        preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);

        $tokens = [];

        foreach (array_keys($matches[0]) as $key) {
            $tokens[] = new Token(
                offset: (int)$matches['start'][$key][1],
                value: $matches['start'][$key][0],
                type: TokenTypeEnum::HIDDEN,
            );

            $tokens[] = new Token(
                offset: (int)$matches['match'][$key][1],
                value: $matches['match'][$key][0],
                type: new DynamicTokenType($this->getClassname()),
            );

            $tokens[] = new Token(
                offset: (int)$matches['end'][$key][1],
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
