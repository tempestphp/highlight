<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\ImplementsPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

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
