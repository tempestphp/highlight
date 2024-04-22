<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\Token;

final readonly class CustomClassInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $pattern = '/(?<start>{\:(?<class>[\w-]+)\:)(?<match>(.|\n)*?)(?<end>:})/';

        $tokens = [];

        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        $additionalOffset = 0;

        foreach ($matches[0] as $key => $match) {
            $startToken = $matches['start'][$key][0];
            $endToken = $matches['end'][$key][0];
            $className = $matches['class'][$key][0];

            $additionalOffset += strlen($startToken);

            $tokens[] = new Token(
                offset: (int) $matches['match'][$key][1] - $additionalOffset,
                value: $matches['match'][$key][0],
                type: new DynamicTokenType($className),
            );

            $additionalOffset += strlen($endToken);

            $content = str_replace([$startToken, $endToken], '', $content);
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }
}
