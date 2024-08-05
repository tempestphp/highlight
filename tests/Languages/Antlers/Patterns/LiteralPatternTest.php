<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Antlers\Patterns\LiteralPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class LiteralPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_literal()
    {
        $this->assertMatches(
            pattern: new LiteralPattern('true'),
            content: '{{ true }}',
            expected: 'true',
        );

        $this->assertMatches(
            pattern: new LiteralPattern('false'),
            content: 'true',
            expected: null,
        );

        $this->assertMatches(
            pattern: new LiteralPattern('true'),
            content: '{{ if variable === true }}',
            expected: 'true',
        );
    }
}
