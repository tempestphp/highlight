<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\StaticClassCallPattern;
use Tempest\Highlight\Tests\TestsPatterns;

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
