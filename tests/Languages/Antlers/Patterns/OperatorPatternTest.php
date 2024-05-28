<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Antlers\Patterns\OperatorPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class OperatorPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_operator()
    {
        $this->assertMatches(
            pattern: new OperatorPattern('!='),
            content: '{{ variable != other_variable }}',
            expected: '!=',
        );

        $this->assertMatches(
            pattern: new OperatorPattern('=>'),
            content: '=>',
            expected: null,
        );

        $this->assertMatches(
            pattern: new OperatorPattern('=>'),
            content: '{{ variable }} => {{ variable }} ',
            expected: null,
        );
    }
}
