<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\SinglelineDocCommentPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class SinglelineDocCommentPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new SinglelineDocCommentPattern(),
            content: '$bar // foo',
            expected: '// foo',
        );
    }
}
