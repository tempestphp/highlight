<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class KeywordPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new KeywordPattern('match'),
            content: 'match ()',
            expected: 'match',
        );

        $this->assertMatches(
            pattern: new KeywordPattern('return'),
            content: 'return ()',
            expected: 'return',
        );

        $this->assertMatches(
            pattern: new KeywordPattern('class'),
            content: 'class ()',
            expected: 'class',
        );
    }
}
