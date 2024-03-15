<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Html;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\TagAttributePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class TagAttributePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new TagAttributePattern(),
            content: htmlentities('<x-hello attr="">'),
            expected: 'attr',
        );

        $this->assertMatches(
            pattern: new TagAttributePattern(),
            content: htmlentities('<a href="">'),
            expected: 'href',
        );
    }
}
