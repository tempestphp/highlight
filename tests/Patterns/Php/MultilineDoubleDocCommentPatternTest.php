<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\MultilineDoubleDocCommentPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class MultilineDoubleDocCommentPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new MultilineDoubleDocCommentPattern(),
            content: '
use Tempest\Highlight\Token;

/**
 * @return a 
 */
final class PhpLanguage implements Language

/**
 * @return b 
 */
            ',
            expected: [
                '/**
 * @return a 
 */',
                '/**
 * @return b 
 */',

            ],
        );
    }
}
