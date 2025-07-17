<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Diff;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class DiffLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'diff'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
+ $this->newCode();
- $this->oldCode();
TXT,
                <<<'TXT'
<span class="hl-addition">+  $this-&gt;newCode();</span>
<span class="hl-deletion">-  $this-&gt;oldCode();</span>
TXT
            ],
        ];
    }
}
