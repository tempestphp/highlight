<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '#[Foo(prop: hi)]', output: '#[Foo(prop: hi)]')]
#[PatternTest(input: '#[\\AllowDynamicProperties]', output: '#[\\AllowDynamicProperties]')]
#[PatternTest(
    input:
'#[Foo(
    prop: hi,
)]',
    output:
'#[Foo(
    prop: hi,
)]'
),
]
final class AttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\#\[(.|\n)*?\])';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::ATTRIBUTE;
    }
}
