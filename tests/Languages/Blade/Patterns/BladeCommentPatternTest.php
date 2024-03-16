<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade\Patterns;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Blade\Patterns\BladeCommentPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class BladeCommentPatternTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new BladeCommentPattern(),
            content: '{{-- test --}} content',
            expected: '{{-- test --}}',
        );
    }
}
