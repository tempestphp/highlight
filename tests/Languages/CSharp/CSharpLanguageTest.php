<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\CSharp;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\CSharp\CSharpLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class CSharpLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_aliases(): void
    {
        $highlighter = new Highlighter();

        foreach (['csharp', 'cs', 'c#'] as $name) {
            $this->assertContains($name, $highlighter->getSupportedLanguageNames());

            $highlighter->parse('', $name);

            $this->assertInstanceOf(CSharpLanguage::class, $highlighter->getCurrentLanguage());
        }
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'csharp');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'preprocessor directive' => ['#nullable enable', '<span class="hl-keyword">#nullable</span>'];
        yield 'namespace keyword' => ['namespace Demo.Tools;', '<span class="hl-keyword">namespace</span>'];
        yield 'namespace name' => ['namespace Demo.Tools;', '<span class="hl-type">Demo<span class="hl-operator">.</span>Tools</span>'];
        yield 'using directive' => ['using System.Text;', '<span class="hl-keyword">using</span>'];
        yield 'attribute' => ['[Obsolete]', '<span class="hl-attribute">Obsolete</span>'];
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'XML documentation' => ['/// <summary>Note</summary>', '<span class="hl-comment">/// &lt;summary&gt;Note&lt;/summary&gt;</span>'];
        yield 'block comment' => ['/* note */', '<span class="hl-comment">/* note */</span>'];
        yield 'regular string' => ['"hello\\n"', '<span class="hl-value">&quot;hello\\n&quot;</span>'];
        yield 'verbatim string' => ['@"c:\\temp"', '<span class="hl-value">@&quot;c:\\temp&quot;</span>'];
        yield 'interpolated string' => ['$"Hello {name}"', '<span class="hl-value">$&quot;Hello {name}&quot;</span>'];
        yield 'raw string' => ['"""<tag>"""', '<span class="hl-value">&quot;&quot;&quot;&lt;tag&gt;&quot;&quot;&quot;</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'number' => ['0xCAFE_F00DUL', '<span class="hl-number">0xCAFE_F00DUL</span>'];
        yield 'keyword' => ['return', '<span class="hl-keyword">return</span>'];
        yield 'modifier' => ['public', '<span class="hl-keyword">public</span>'];
        yield 'built-in type' => ['string', '<span class="hl-type">string</span>'];
        yield 'class' => ['class Widget {}', '<span class="hl-type">Widget</span>'];
        yield 'interface' => ['interface IService {}', '<span class="hl-type">IService</span>'];
        yield 'struct' => ['struct Point {}', '<span class="hl-type">Point</span>'];
        yield 'record' => ['record User(int Id);', '<span class="hl-type">User</span>'];
        yield 'enum' => ['enum Status {}', '<span class="hl-type">Status</span>'];
        yield 'delegate' => ['delegate void Handler();', '<span class="hl-type">Handler</span>'];
        yield 'generic type' => ['List<string> values;', '<span class="hl-type">List</span>'];
        yield 'nullable type' => ['string? value;', '<span class="hl-type">string</span><span class="hl-operator">?</span>'];
        yield 'literal' => ['return null;', '<span class="hl-literal">null</span>'];
        yield 'method call' => ['Render();', '<span class="hl-property">Render</span>'];
        yield 'property' => ['public string Name { get; init; }', '<span class="hl-property">Name</span>'];
        yield 'lambda' => ['value => value + 1', '<span class="hl-operator">=&gt;</span>'];
        yield 'query expression' => ['from item in items select item', '<span class="hl-keyword">from</span>'];
        yield 'operator' => ['left ?? right', '<span class="hl-operator">??</span>'];
        yield 'punctuation' => ['return value;', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "class Markup {\r\n"
            . "    string Value = \"<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿\";\r"
            . "    string Script = \"<script>alert('x')</script>\";\r\n"
            . "}\r\n";

        $highlighted = (new Highlighter())->parse($source, 'csharp');
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
        $this->assertSame('csharp.txt', HighlighterBench::LANGUAGES['csharp'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/csharp.txt', __DIR__ . '/../../targets/csharp.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }
}
