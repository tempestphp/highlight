<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\PropertyAccessPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

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
