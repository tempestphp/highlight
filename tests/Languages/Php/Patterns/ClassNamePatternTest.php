<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\ClassNamePattern;
use Tempest\Highlight\Tests\TestsPatterns;

class ClassNamePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ClassNamePattern(),
            content: 'class Foo implements Bar',
            expected: 'Foo',
        );

        $this->assertMatches(
            pattern: new ClassNamePattern(),
            content: 'interface Foo implements Bar',
            expected: 'Foo',
        );
    }
}
