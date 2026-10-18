<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Go;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Go\GoLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class GoLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_alias(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('go', $highlighter->getSupportedLanguageNames());
        $this->assertContains('golang', $highlighter->getSupportedLanguageNames());

        foreach (['go', 'golang'] as $name) {
            $highlighter->parse('', $name);

            $this->assertInstanceOf(GoLanguage::class, $highlighter->getCurrentLanguage());
        }
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'go');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'block comment' => ['/* note */', '<span class="hl-comment">/* note */</span>'];
        yield 'import' => ['import "fmt"', '<span class="hl-keyword">import</span>'];
        yield 'import path' => ['import "fmt"', '<span class="hl-value">&quot;fmt&quot;</span>'];
        yield 'string' => ['"hello\\n"', '<span class="hl-value">&quot;hello\\n&quot;</span>'];
        yield 'raw string' => ['`hello`', '<span class="hl-value">`hello`</span>'];
        yield 'rune' => ["'λ'", '<span class="hl-value">\'λ\'</span>'];
        yield 'hexadecimal float' => ['0x1.fp2', '<span class="hl-number">0x1.fp2</span>'];
        yield 'imaginary number' => ['2i', '<span class="hl-number">2i</span>'];
        yield 'keyword' => ['defer', '<span class="hl-keyword">defer</span>'];
        yield 'built-in type' => ['string', '<span class="hl-type">string</span>'];
        yield 'constant' => ['nil', '<span class="hl-literal">nil</span>'];
        yield 'built-in function' => ['append(values, value)', '<span class="hl-property">append</span>'];
        yield 'declared type' => ['type Result struct{}', '<span class="hl-type">Result</span>'];
        yield 'declared function' => ['func render() {}', '<span class="hl-property">render</span>'];
        yield 'operator' => ['value <- input', '<span class="hl-operator">&lt;-</span>'];
        yield 'punctuation' => ['map[string]int{}', '<span class="hl-operator">{</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "package main\r\n"
            . "var raw = `<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿`\r"
            . "var script = \"<script>alert('x')</script>\"\r\n";

        $highlighted = (new Highlighter())->parse($source, 'go');
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
        $this->assertSame('go.txt', HighlighterBench::LANGUAGES['go'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/go.txt', __DIR__ . '/../../targets/go.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }
}
