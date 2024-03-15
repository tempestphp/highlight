<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Css;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Css\Patterns\CssFunctionPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class CssFunctionPatternTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new CssFunctionPattern(),
            content: '
src: url("fonts/MonaspaceArgon-Bold.woff") format("woff");
',
            expected: ['url', 'format'],
        );
    }
}
