<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\FunctionCallPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class FunctionCallPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new FunctionCallPattern(),
            content: 'foo()',
            expected: 'foo',
        );
    }
}
