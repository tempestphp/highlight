<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\ParameterTypePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class ParameterTypePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ParameterTypePattern(),
            content: 'function foo(Bar $bar, Baz $baz)',
            expected: ['Bar', 'Baz'],
        );
    }
}
