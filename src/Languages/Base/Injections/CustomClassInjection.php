<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\Token;

#[RequiresSubstring('{:')]
final readonly class CustomClassInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $pattern = '/(?<start>{\:(?<class>[\w-]+)\:)(?<match>[\s\S]*?)(?<end>:})/';

        $tokens = [];

        $firstOpener = strpos($content, '{:');
        $lastCloser = $firstOpener === false ? false : strrpos($content, ':}', $firstOpener);

        // No match can end after the last closer, so unclosed openers past it are never rescanned to the end.
        preg_match_all($pattern, $lastCloser === false ? '' : substr($content, 0, $lastCloser + 2), $matches, PREG_OFFSET_CAPTURE);

        $additionalOffset = 0;
        $hasMarkers = true;

        foreach (array_keys($matches[0]) as $key) {
            $startToken = $matches['start'][$key][0];
            $endToken = $matches['end'][$key][0];
            $className = $matches['class'][$key][0];

            $additionalOffset += strlen($startToken);

            $tokens[] = new Token(
                offset: $matches['match'][$key][1] - $additionalOffset,
                value: $matches['match'][$key][0],
                type: new DynamicTokenType($className),
            );

            $additionalOffset += strlen($endToken);

            if ($hasMarkers) {
                $content = str_replace([$startToken, $endToken], '', $content);

                // Every start token begins with "{:", so once neither "{:" nor ":}" is left the remaining replacements are no-ops.
                $hasMarkers = str_contains($content, '{:') || str_contains($content, ':}');
            }
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }
}
