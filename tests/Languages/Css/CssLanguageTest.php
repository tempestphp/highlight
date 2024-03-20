<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Css;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class CssLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'css'),
        );
    }

    public static function data(): array
    {
        return [
            [
                <<<TXT
.foo {
    --var: bar;
    color: var(--var);
}
TXT,
                <<<TXT
<span class="hl-keyword">.foo </span>{
    <span class="hl-property">--var</span>: bar;
    <span class="hl-property">color</span>: <span class="hl-keyword">var</span>(<span class="hl-property">--var</span>);
}
TXT,
            ],
        ];
    }
}
