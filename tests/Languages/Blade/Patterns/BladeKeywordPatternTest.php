<?php

namespace Tempest\Highlight\Tests\Languages\Blade\Patterns;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Blade\Patterns\BladeKeywordPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class BladeKeywordPatternTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new BladeKeywordPattern(),
            content: '
@if()
@endif()
',
            expected: ['@if', '@endif'],
        );
    }
}
