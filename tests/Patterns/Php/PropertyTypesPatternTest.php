<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\PropertyTypesPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class PropertyTypesPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'public Bar $bar',
            expected: 'Bar',
        );

        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'protected Bar $bar',
            expected: 'Bar',
        );

        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'private Bar $bar',
            expected: 'Bar',
        );

        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'public Foo|Bar $bar',
            expected: 'Foo|Bar',
        );

        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'public Foo|Bar&Baz $bar',
            expected: 'Foo|Bar&Baz',
        );

        $this->assertMatches(
            pattern: new PropertyTypesPattern(),
            content: 'public (Bar&Baz)|null $bar',
            expected: '(Bar&Baz)|null',
        );
    }
}
