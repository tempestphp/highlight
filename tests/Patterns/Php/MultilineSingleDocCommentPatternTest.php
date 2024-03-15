<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\MultilineSingleDocCommentPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class MultilineSingleDocCommentPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new MultilineSingleDocCommentPattern(),
            content: '
use Tempest\Highlight\Token;

/* world
 * hello
 */
final class PhpLanguage implements Language
            ',
            expected: '/* world
 * hello
 */',
        );
    }
}
