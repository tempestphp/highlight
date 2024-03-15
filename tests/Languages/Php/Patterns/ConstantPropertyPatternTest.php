<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\ConstantPropertyPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class ConstantPropertyPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ConstantPropertyPattern(),
            content: 'Foo::BAR',
            expected: 'BAR',
        );

        $this->assertMatches(
            pattern: new ConstantPropertyPattern(),
            content: 'Foo::BAR()',
            expected: 'BAR',
        );
    }
}
