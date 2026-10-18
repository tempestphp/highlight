<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Rust;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Rust\RustLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class RustLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_alias(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('rust', $highlighter->getSupportedLanguageNames());
        $this->assertContains('rs', $highlighter->getSupportedLanguageNames());

        foreach (['rust', 'rs'] as $name) {
            $highlighter->parse('', $name);

            $this->assertInstanceOf(RustLanguage::class, $highlighter->getCurrentLanguage());
        }
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'rust');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'nested block comment' => ['/* outer /* inner */ outer */', '<span class="hl-comment">/* outer /* inner */ outer */</span>'];
        yield 'attribute' => ['#[inline]', '<span class="hl-attribute">#'];
        yield 'string' => ['"hello"', '<span class="hl-value">&quot;hello&quot;</span>'];
        yield 'raw string' => ['r#"hello"#', '<span class="hl-value">r#&quot;hello&quot;#</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'lifetime' => ["'a", '<span class="hl-type">\'a</span>'];
        yield 'number' => ['42_u8', '<span class="hl-number">42_u8</span>'];
        yield 'keyword' => ['async', '<span class="hl-keyword">async</span>'];
        yield 'type' => ['String', '<span class="hl-type">String</span>'];
        yield 'macro' => ['println!', '<span class="hl-property">println!</span>'];
        yield 'function' => ['run()', '<span class="hl-property">run</span>'];
        yield 'operator' => ['->', '<span class="hl-operator">-&gt;</span>'];
        yield 'punctuation' => [';', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = <<<'RUST'
fn render<'a, T>(value: &'a T) -> &'a str {
    println!("<&>");
    "<script>alert('x')</script>"
}
RUST;

        $highlighted = (new Highlighter())->parse($source, 'rust');
        $renderedSource = html_entity_decode(strip_tags($highlighted), ENT_QUOTES | ENT_HTML5);

        $this->assertSame($source, $renderedSource);
        $this->assertStringNotContainsString('<script>', $highlighted);
        $this->assertStringContainsString('&lt;script&gt;', $highlighted);
    }

    #[Test]
    public function it_has_a_non_empty_benchmark_fixture(): void
    {
        $this->assertSame('rust.txt', HighlighterBench::LANGUAGES['rust'] ?? null);

        $fixture = __DIR__ . '/../../Bench/Fixtures/rust.txt';

        $this->assertFileExists($fixture);
        $this->assertNotSame('', trim((string) file_get_contents($fixture)));
    }
}
