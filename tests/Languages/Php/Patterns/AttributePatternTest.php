<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\AttributePattern;
use Tempest\Highlight\Tests\TestsPatterns;

class AttributePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new AttributePattern(),
            content: '#[Foo(prop: hi)]',
            expected: '#[Foo(prop: hi)]',
        );

        $this->assertMatches(
            pattern: new AttributePattern(),
            content: '#[Foo(
                prop: hi,
            )]',
            expected: '#[Foo(
                prop: hi,
            )]',
        );
    }
}
