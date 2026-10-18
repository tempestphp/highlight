<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RustKeywordPattern implements Pattern
{
    use IsPattern;

    private const array KEYWORDS = [
        'abstract', 'as', 'async', 'await', 'become', 'box', 'break', 'const',
        'continue', 'crate', 'do', 'dyn', 'else', 'enum', 'extern', 'final',
        'fn', 'for', 'gen', 'if', 'impl', 'in', 'let', 'loop', 'macro', 'match',
        'mod', 'move', 'mut', 'override', 'priv', 'pub', 'ref', 'return', 'static',
        'self', 'Self', 'struct', 'super', 'trait', 'try', 'type', 'typeof',
        'union', 'unsafe', 'unsized', 'use', 'virtual', 'where', 'while', 'yield',
    ];

    public function getPattern(): string
    {
        return '\b(?<match>' . implode('|', self::KEYWORDS) . ')\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
