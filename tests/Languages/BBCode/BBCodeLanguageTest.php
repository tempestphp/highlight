<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\BBCode;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class BBCodeLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'bbcode'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
[b]Hello World[/b]
[i]italic text[/i]
[u]underlined[/u]
[s]strikethrough[/s]
TXT,
            <<<'TXT'
[<span class="hl-keyword">b</span>]Hello World[/<span class="hl-keyword">b</span>]
[<span class="hl-keyword">i</span>]italic text[/<span class="hl-keyword">i</span>]
[<span class="hl-keyword">u</span>]underlined[/<span class="hl-keyword">u</span>]
[<span class="hl-keyword">s</span>]strikethrough[/<span class="hl-keyword">s</span>]
TXT],

            [<<<'TXT'
[url=http://example.com]Click here[/url]
[color=#ff0000]Red text[/color]
[size=18]Big text[/size]
[quote=John]Hello there[/quote]
TXT,
            <<<'TXT'
[<span class="hl-keyword">url</span>=<span class="hl-attribute">http://example.com</span>]Click here[/<span class="hl-keyword">url</span>]
[<span class="hl-keyword">color</span>=<span class="hl-attribute">#ff0000</span>]Red text[/<span class="hl-keyword">color</span>]
[<span class="hl-keyword">size</span>=<span class="hl-attribute">18</span>]Big text[/<span class="hl-keyword">size</span>]
[<span class="hl-keyword">quote</span>=<span class="hl-attribute">John</span>]Hello there[/<span class="hl-keyword">quote</span>]
TXT],

            [<<<'TXT'
[list]
[*]First item
[*]Second item
[*]Third item
[/list]
TXT,
            <<<'TXT'
[<span class="hl-keyword">list</span>]
[<span class="hl-keyword">*</span>]First item
[<span class="hl-keyword">*</span>]Second item
[<span class="hl-keyword">*</span>]Third item
[/<span class="hl-keyword">list</span>]
TXT],

            [<<<'TXT'
[img]http://example.com/image.png[/img]
[code]echo "hello";[/code]
TXT,
            <<<'TXT'
[<span class="hl-keyword">img</span>]http://example.com/image.png[/<span class="hl-keyword">img</span>]
[<span class="hl-keyword">code</span>]echo &quot;hello&quot;;[/<span class="hl-keyword">code</span>]
TXT],
        ];
    }
}
