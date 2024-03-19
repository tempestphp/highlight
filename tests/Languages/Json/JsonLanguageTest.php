<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Json;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class JsonLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'json'),
        );
    }

    public static function data(): array
    {
        return [
            [
                '{
    "key": "value",
    "array": ["bar"]
}',
                '<span class="hl-property">{</span>
    <span class="hl-keyword">&quot;key&quot;</span>: <span class="hl-value">&quot;value&quot;</span>,
    <span class="hl-keyword">&quot;array&quot;</span>: <span class="hl-property">[</span><span class="hl-value">&quot;bar&quot;</span><span class="hl-property">]</span>
<span class="hl-property">}</span>',
            ],
        ];
    }
}
