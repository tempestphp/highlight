<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\ImplementsPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class ImplementsPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ImplementsPattern(),
            content: 'class Foo implements Bar',
            expected: 'Bar',
        );
    }
}
