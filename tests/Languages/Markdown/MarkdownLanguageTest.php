<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Markdown;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class MarkdownLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'markdown'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'md'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            'headings' => [
                <<<'TXT'
# Heading 1
## Heading 2
### Heading 3
TXT,
                <<<'TXT'
<span class="hl-keyword"># Heading 1</span>
<span class="hl-keyword">## Heading 2</span>
<span class="hl-keyword">### Heading 3</span>
TXT,
            ],

            'bold' => [
                'This is **bold** and __also bold__ text',
                'This is <span class="hl-generic">**bold**</span> and <span class="hl-generic">__also bold__</span> text',
            ],

            'italic' => [
                'This is *italic* and _also italic_ text',
                'This is <span class="hl-attribute">*italic*</span> and <span class="hl-attribute">_also italic_</span> text',
            ],

            'inline_code' => [
                'Use `code` here and `more code` there',
                'Use <span class="hl-value">`code`</span> here and <span class="hl-value">`more code`</span> there',
            ],

            'links' => [
                'Visit [example](https://example.com) for more',
                'Visit <span class="hl-type">[example](https://example.com)</span> for more',
            ],

            'images' => [
                '![Alt text](image.png)',
                '<span class="hl-type">![Alt text](image.png)</span>',
            ],

            'blockquote' => [
                '> This is a quote',
                '<span class="hl-property">&gt;</span> This is a quote',
            ],

            'unordered_list' => [
                <<<'TXT'
- Item 1
* Item 2
  - Nested
TXT,
                <<<'TXT'
<span class="hl-property">-</span> Item 1
<span class="hl-property">*</span> Item 2
  <span class="hl-property">-</span> Nested
TXT,
            ],

            'ordered_list' => [
                <<<'TXT'
1. First
2. Second
TXT,
                <<<'TXT'
<span class="hl-property">1.</span> First
<span class="hl-property">2.</span> Second
TXT,
            ],

            'horizontal_rule' => [
                '---',
                '<span class="hl-comment">---</span>',
            ],

            'code_fence' => [
                <<<'TXT'
```php
echo "hello";
```
TXT,
                <<<'TXT'
<span class="hl-comment">```php</span>
echo &quot;hello&quot;;
<span class="hl-comment">```</span>
TXT,
            ],

            'combined' => [
                <<<'TXT'
# My Document

This has **bold** and *italic* and `code`.

- A [link](https://example.com)
- An ![image](photo.jpg)

> A quote

---
TXT,
                <<<'TXT'
<span class="hl-keyword"># My Document</span>

This has <span class="hl-generic">**bold**</span> and <span class="hl-attribute">*italic*</span> and <span class="hl-value">`code`</span>.

<span class="hl-property">-</span> A <span class="hl-type">[link](https://example.com)</span>
<span class="hl-property">-</span> An <span class="hl-type">![image](photo.jpg)</span>

<span class="hl-property">&gt;</span> A quote

<span class="hl-comment">---</span>
TXT,
            ],
        ];
    }
}
