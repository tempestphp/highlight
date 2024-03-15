<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Html\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\HtmlCommentPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class HtmlCommentPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new HtmlCommentPattern(),
            content: htmlentities('
            test
            <!-- 
            foo
            -->
            test
            >'),
            expected: htmlentities('<!-- 
            foo
            -->'),
        );
    }
}
