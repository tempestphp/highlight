<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class UnclosedMarkerTest extends TestCase
{
    public function test_diff_markers_after_the_last_closer_stay_plain(): void
    {
        $this->assertSame(
            '<span class="hl-addition">a</span> <span class="hl-deletion">b</span> {+c' . "\n" . '{-d -}} {-e',
            (new Highlighter())->parse("{+a+} {-b-} {+c\n{-d -}} {-e", 'txt'),
        );
    }

    public function test_highlight_markers_after_the_last_closer_stay_plain(): void
    {
        $this->assertSame(
            '<span style="display: none">{*</span><span class="hl-strong">a</span><span style="display: none">*}</span> {*b *}} {*c <span class="x">y</span> {:z:w',
            (new Highlighter())->parse('{*a*} {*b *}} {*c {:x:y:} {:z:w', 'txt'),
        );
    }
}
