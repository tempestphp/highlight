<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Html;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\OpenTagPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class OpenTagPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<x-hello attr="">'),
            expected: 'x-hello',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<a href="">'),
            expected: 'a',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<br/>'),
            expected: 'br',
        );
    }
}
