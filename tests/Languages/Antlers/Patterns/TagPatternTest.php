<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Antlers\Patterns\LiteralPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class TagPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_tag()
    {
        $this->assertMatches(
            pattern: new LiteralPattern('loop'),
            content: '{{ loop from="1" to="10" }}',
            expected: 'loop',
        );

        $this->assertMatches(
            pattern: new LiteralPattern('loop'),
            content: '{{ /loop }}',
            expected: 'loop',
        );

        $this->assertMatches(
            pattern: new LiteralPattern('collection'),
            content: '{{ collection:blog }}',
            expected: 'collection',
        );

        $this->assertMatches(
            pattern: new LiteralPattern('collection'),
            content: 'collection:blog',
            expected: null,
        );

        $this->assertMatches(
            pattern: new LiteralPattern('loop'),
            content: '{{collection:blog}} loop of the collection {{/collection:blog}}',
            expected: null,
        );
    }
}
