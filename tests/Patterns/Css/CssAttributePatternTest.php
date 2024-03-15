<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Css;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Css\Patterns\CssAttributePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class CssAttributePatternTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new CssAttributePattern(),
            content: '
.hl-comment {
    color: #888888;
    font-style: italic;
    font-family: "Radon", serif;
}
',
            expected: ['color', 'font-style', 'font-family'],
        );
    }
}
