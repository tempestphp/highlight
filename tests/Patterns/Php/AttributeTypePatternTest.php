<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\AttributeTypePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class AttributeTypePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new AttributeTypePattern(),
            content: '#[Foo(prop: hi)]',
            expected: 'Foo',
        );

        $this->assertMatches(
            pattern: new AttributeTypePattern(),
            content: '
#[Foo(
        uri: "/books/create",
        "/books/create",
    ),
    Bar(uri: "/books/create"),
    Baz,
]',
            expected: ['Foo', 'Bar', 'Baz'],
        );
    }
}
