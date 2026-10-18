<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Java;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Java\JavaLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class JavaLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('java', $highlighter->getSupportedLanguageNames());

        $highlighter->parse('', 'java');

        $this->assertInstanceOf(JavaLanguage::class, $highlighter->getCurrentLanguage());
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'java');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'package keyword' => ['package com.example;', '<span class="hl-keyword">package</span>'];
        yield 'package name' => ['package com.example;', '<span class="hl-type">com<span class="hl-operator">.</span>example</span>'];
        yield 'import' => ['import java.util.List;', '<span class="hl-keyword">import</span>'];
        yield 'annotation' => ['@Override', '<span class="hl-attribute">@Override</span>'];
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'Javadoc' => ['/** note */', '<span class="hl-comment">/** note */</span>'];
        yield 'string' => ['"hello\\n"', '<span class="hl-value">&quot;hello\\n&quot;</span>'];
        yield 'text block' => ['"""hello\nworld"""', '<span class="hl-value">&quot;&quot;&quot;hello\nworld&quot;&quot;&quot;</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'number' => ['0xCAFE_F00DL', '<span class="hl-number">0xCAFE_F00DL</span>'];
        yield 'keyword' => ['return', '<span class="hl-keyword">return</span>'];
        yield 'modifier' => ['public', '<span class="hl-keyword">public</span>'];
        yield 'built-in type' => ['int', '<span class="hl-type">int</span>'];
        yield 'class' => ['class Widget {}', '<span class="hl-type">Widget</span>'];
        yield 'interface' => ['interface Service {}', '<span class="hl-type">Service</span>'];
        yield 'enum' => ['enum Status {}', '<span class="hl-type">Status</span>'];
        yield 'record' => ['record Point(int x, int y) {}', '<span class="hl-type">Point</span>'];
        yield 'generic type' => ['class Box<T> {}', '<span class="hl-type">T</span>'];
        yield 'literal' => ['return null;', '<span class="hl-literal">null</span>'];
        yield 'method' => ['render();', '<span class="hl-property">render</span>'];
        yield 'lambda' => ['value -> value + 1', '<span class="hl-operator">-&gt;</span>'];
        yield 'operator' => ['left instanceof Widget', '<span class="hl-keyword">instanceof</span>'];
        yield 'punctuation' => ['return value;', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "class Markup {\r\n"
            . "    String value = \"<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿\";\r"
            . "    String script = \"<script>alert('x')</script>\";\r\n"
            . "}\r\n";

        $highlighted = (new Highlighter())->parse($source, 'java');
        $renderedSource = html_entity_decode(strip_tags($highlighted), ENT_QUOTES | ENT_HTML5);

        $this->assertSame($source, $renderedSource);
        $this->assertStringNotContainsString('<script>', $highlighted);
        $this->assertStringNotContainsString('<img', $highlighted);
        $this->assertStringContainsString('&lt;script&gt;', $highlighted);
        $this->assertStringContainsString('&amp;copy;', $highlighted);
    }

    #[Test]
    public function it_has_non_empty_benchmark_and_visual_fixtures(): void
    {
        $this->assertSame('java.txt', HighlighterBench::LANGUAGES['java'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/java.txt', __DIR__ . '/../../targets/java.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }
}
