<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\ExtendsPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class ExtendsPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new ExtendsPattern(),
            content: 'class Foo extends Bar',
            expected: 'Bar',
        );
    }
}
