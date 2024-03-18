<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Html\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\TagAttributePattern;
use Tempest\Highlight\Tests\TestsPatterns;

class TagAttributePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new TagAttributePattern(),
            content: '<x-hello attr="">',
            expected: 'attr',
        );

        $this->assertMatches(
            pattern: new TagAttributePattern(),
            content: '<a href="">',
            expected: 'href',
        );
    }
}
