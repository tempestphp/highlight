<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Html;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Html\CloseTagPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

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
