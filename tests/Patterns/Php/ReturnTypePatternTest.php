<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\ReturnTypePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class ReturnTypePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ReturnTypePattern(),
            content: 'function foo(): Bar',
            expected: 'Bar',
        );

        $this->assertMatches(
            pattern: new ReturnTypePattern(),
            content: 'function foo(): Foo|Bar',
            expected: 'Foo|Bar',
        );

        $this->assertMatches(
            pattern: new ReturnTypePattern(),
            content: 'function foo(): Foo&Bar',
            expected: 'Foo&Bar',
        );

        $this->assertMatches(
            pattern: new ReturnTypePattern(),
            content: 'function foo(): (Foo&Bar)|null',
            expected: '(Foo&Bar)|null',
        );
    }
}
