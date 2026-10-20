<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class GutterInjectionStateTest extends TestCase
{
    public function test_reused_gutter_does_not_show_marks_from_a_previous_parse(): void
    {
        $highlighter = (new Highlighter())->withGutter();

        $withMarks = $highlighter->parse("a\n{+b+}\nc\n{-d-}\ne", 'txt');
        $withoutMarks = $highlighter->parse("a\nb\nc\nd\ne", 'txt');

        $this->assertSame(<<<'TXT'
<span class="hl-gutter">  1</span>a
<span class="hl-gutter hl-gutter-addition">2 +</span><span class="hl-addition">b</span>
<span class="hl-gutter">  3</span>c
<span class="hl-gutter hl-gutter-deletion">4 -</span><span class="hl-deletion">d</span>
<span class="hl-gutter">  5</span>e
TXT, $withMarks);

        $this->assertSame(<<<'TXT'
<span class="hl-gutter">1</span>a
<span class="hl-gutter">2</span>b
<span class="hl-gutter">3</span>c
<span class="hl-gutter">4</span>d
<span class="hl-gutter">5</span>e
TXT, $withoutMarks);
    }

    public function test_gutter_with_invalid_utf8(): void
    {
        $input = "<?php echo 'caf\xE9';\necho 1;";

        [$first, $second] = explode("\n", (new Highlighter())->parse($input, 'php'));

        $this->assertSame(
            '<span class="hl-gutter">1</span>' . $first . "\n" . '<span class="hl-gutter">2</span>' . $second,
            (new Highlighter())->withGutter()->parse($input, 'php'),
        );
    }
}
