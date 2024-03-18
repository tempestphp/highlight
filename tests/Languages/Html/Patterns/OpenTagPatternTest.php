<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Html\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\OpenTagPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class OpenTagPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: '<x-hello attr="">',
            expected: 'x-hello',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: '<a href="">',
            expected: 'a',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: '<br/>',
            expected: 'br',
        );
    }
}
