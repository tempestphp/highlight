<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\ClassPropertyPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class ClassPropertyPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ClassPropertyPattern(),
            content: 'public Foo $foo',
            expected: '$foo',
        );

        $this->assertMatches(
            pattern: new ClassPropertyPattern(),
            content: 'public Foo|Bar $foo',
            expected: '$foo',
        );

        $this->assertMatches(
            pattern: new ClassPropertyPattern(),
            content: 'public Foo&Bar $foo',
            expected: '$foo',
        );

        $this->assertMatches(
            pattern: new ClassPropertyPattern(),
            content: 'public (Foo&Bar)|null $foo',
            expected: '$foo',
        );
    }
}
