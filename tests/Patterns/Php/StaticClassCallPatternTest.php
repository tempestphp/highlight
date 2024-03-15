<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\StaticClassCallPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class StaticClassCallPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new StaticClassCallPattern(),
            content: 'Foo::bar()',
            expected: 'Foo',
        );

        $this->assertMatches(
            pattern: new StaticClassCallPattern(),
            content: 'Foo::BAR',
            expected: 'Foo',
        );
    }
}
