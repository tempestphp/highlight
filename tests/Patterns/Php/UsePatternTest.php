<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\UsePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class UsePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new UsePattern(),
            content: 'use Foo\Bar\Baz;',
            expected: 'Foo\Bar\Baz',
        );
    }
}
