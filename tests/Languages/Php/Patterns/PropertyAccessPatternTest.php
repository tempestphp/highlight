<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\PropertyAccessPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class PropertyAccessPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new PropertyAccessPattern(),
            content: htmlentities('$this->foo'),
            expected: 'foo',
        );

        $this->assertMatches(
            pattern: new PropertyAccessPattern(),
            content: htmlentities('$this->foo()'),
            expected: 'foo',
        );

        $this->assertMatches(
            pattern: new PropertyAccessPattern(),
            content: htmlentities('$obj->foo'),
            expected: 'foo',
        );
    }
}
