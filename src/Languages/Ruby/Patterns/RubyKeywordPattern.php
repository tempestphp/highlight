<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RubyKeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private array $keywords = [
        '__ENCODING__', '__LINE__', '__FILE__', '__dir__', '__method__',
        'BEGIN', 'END', 'alias', 'and', 'begin', 'break', 'case', 'class',
        'def', 'defined?', 'do', 'else', 'elsif', 'end', 'ensure', 'for',
        'if', 'in', 'module', 'next', 'not', 'or', 'redo', 'rescue',
        'retry', 'return', 'self', 'super', 'then', 'undef', 'unless',
        'until', 'when', 'while', 'yield',
    ])
    {
    }

    public function getPattern(): string
    {
        $keywords = implode('|', array_map(
            static fn (string $keyword): string => preg_quote($keyword, '/'),
            $this->keywords,
        ));

        return "\b(?<match>(?:{$keywords}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
