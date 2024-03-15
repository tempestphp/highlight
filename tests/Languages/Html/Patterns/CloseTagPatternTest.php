<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Html\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Patterns\CloseTagPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class CloseTagPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new CloseTagPattern(),
            content: htmlentities('</x-hello>'),
            expected: 'x-hello',
        );

        $this->assertMatches(
            pattern: new CloseTagPattern(),
            content: htmlentities('</a>'),
            expected: 'a',
        );
    }
}
