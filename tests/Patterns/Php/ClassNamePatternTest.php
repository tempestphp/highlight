<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\ClassNamePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

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
