<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '#[Foo(prop: hi)]', output: 'Foo')]
#[PatternTest(input: '#[\Foo(prop: hi)]', output: '\Foo')]
#[PatternTest(
    input: '#[Foo(
        uri: "/books/create",
        "/books/create",
    ),
    Bar(uri: "/books/create"),
    Baz,
]',
    output: ['Foo', 'Bar', 'Baz']
)]
final readonly class AttributeTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(^[\s]*|\#\[)(?<match>[\\\\]*[A-Z][\w\\\\]+)/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
