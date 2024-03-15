<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Css;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Css\Patterns\CssSelectorPattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

class CssSelectorPatternTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new CssSelectorPattern(),
            content: 'code, .asd, #id,
.hl-blur, @font-face,
kbd, samp,
pre {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
',
            expected: 'code, .asd, #id,
.hl-blur, @font-face,
kbd, samp,
pre ',
        );
    }
}
