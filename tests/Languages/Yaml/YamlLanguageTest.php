<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Yaml;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class YamlLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'yaml'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'yml'),
        );
    }

    public static function data(): array
    {
        return [
            [<<<TXT
php-version-stats-january-2024:
    date: 2024-01-29
    string: "PHP version stats: January, 2024"
    single-string: 'PHP version stats: January, 2024'
    pipe: |
      hello
      world 
    array: [ true ] #comment
    object:
      - { title: "a", link: "prop" }
    runs-on: \${{ matrix.os }}
TXT,
            <<<TXT
<span class="hl-keyword">php-version-stats-january-2024</span><span class="hl-property">:</span>
    <span class="hl-keyword">date</span><span class="hl-property">:</span> 2024-01-29
    <span class="hl-keyword">string</span><span class="hl-property">:</span> &quot;<span class="hl-value">PHP version stats: January, 2024</span>&quot;
    <span class="hl-keyword">single-string</span><span class="hl-property">:</span> '<span class="hl-value">PHP version stats: January, 2024</span>'
    <span class="hl-keyword">pipe</span><span class="hl-property">:</span> <span class="hl-property">|</span>
      hello
      world 
    <span class="hl-keyword">array</span><span class="hl-property">:</span> <span class="hl-property">[</span> true <span class="hl-property">]</span> <span class="hl-comment">#comment</span>
    <span class="hl-keyword">object</span><span class="hl-property">:</span>
      <span class="hl-property">-</span> <span class="hl-property">{</span> <span class="hl-keyword">title</span><span class="hl-property">:</span> &quot;<span class="hl-value">a</span>&quot;, <span class="hl-keyword">link</span>: &quot;<span class="hl-value">prop</span>&quot; <span class="hl-property">}</span>
    <span class="hl-keyword">runs-on</span><span class="hl-property">:</span> $<span class="hl-value">{{</span><span class="hl-property"> matrix.os </span><span class="hl-value">}}</span>
TXT],
        ];
    }
}
