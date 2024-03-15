<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\FunctionNamePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class FunctionNamePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new FunctionNamePattern(),
            content: 'function foo()',
            expected: 'foo',
        );
    }
}
