<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\NamedArgumentPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class NamedArgumentPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new NamedArgumentPattern(),
            content: '#[Foo(prop: hi)]',
            expected: 'prop',
        );

        $this->assertMatches(
            pattern: new NamedArgumentPattern(),
            content: 'foo(bar: $a, baz: $b)',
            expected: ['bar', 'baz'],
        );

        $this->assertMatches(
            pattern: new NamedArgumentPattern(),
            content: 'foo(
                bar: $a, 
                baz: $b
            )',
            expected: ['bar', 'baz'],
        );
    }
}
