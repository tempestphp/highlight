<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Toml;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Toml\TomlLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class TomlLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('toml', $highlighter->getSupportedLanguageNames());

        $highlighter->parse('', 'toml');

        $this->assertInstanceOf(TomlLanguage::class, $highlighter->getCurrentLanguage());
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "title = \"<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿\"\r\n"
            . "script = \"<script>alert('x')</script>\"\r"
            . "enabled = true\r\n";

        $highlighted = (new Highlighter())->parse($source, 'toml');
        $renderedSource = html_entity_decode(strip_tags($highlighted), ENT_QUOTES | ENT_HTML5);

        $this->assertSame($source, $renderedSource);
        $this->assertStringNotContainsString('<script>', $highlighted);
        $this->assertStringNotContainsString('<img', $highlighted);
        $this->assertStringContainsString('&lt;script&gt;', $highlighted);
        $this->assertStringContainsString('&amp;copy;', $highlighted);
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'toml');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'comment' => ['# Server settings', '<span class="hl-comment"># Server settings</span>'];
        yield 'bare key' => ['title = "TOML"', '<span class="hl-property">title</span>'];
        yield 'quoted key' => ['"site title" = "TOML"', '<span class="hl-property">&quot;site title&quot;</span>'];
        yield 'dotted key' => ['fruit.physical.color = "orange"', '<span class="hl-property">fruit.physical.color</span>'];
        yield 'standard table' => ['[database]', '<span class="hl-type">database</span>'];
        yield 'array of tables' => ['[[products]]', '<span class="hl-type">products</span>'];
        yield 'basic string' => ['name = "TOML\nExample"', '<span class="hl-value">&quot;TOML\nExample&quot;</span>'];
        yield 'literal string' => ["path = 'C:\\Users'", '<span class="hl-value">\'C:\\Users\'</span>'];
        yield 'multiline basic string' => ["text = \"\"\"first\nsecond\"\"\"", '<span class="hl-value">&quot;&quot;&quot;first'];
        yield 'multiline literal string' => ["text = '''first\nsecond'''", '<span class="hl-value">\'\'\'first'];
        yield 'decimal integer' => ['answer = 42', '<span class="hl-number">42</span>'];
        yield 'hexadecimal integer' => ['color = 0xDEAD_BEEF', '<span class="hl-number">0xDEAD_BEEF</span>'];
        yield 'octal integer' => ['mask = 0o755', '<span class="hl-number">0o755</span>'];
        yield 'binary integer' => ['bits = 0b1101', '<span class="hl-number">0b1101</span>'];
        yield 'float' => ['ratio = 6.626e-34', '<span class="hl-number">6.626e-34</span>'];
        yield 'special float' => ['limit = +inf', '<span class="hl-number">+inf</span>'];
        yield 'boolean' => ['enabled = true', '<span class="hl-literal">true</span>'];
        yield 'offset date time' => ['created = 1979-05-27T07:32:00Z', '<span class="hl-value">1979-05-27T07:32:00Z</span>'];
        yield 'local date time' => ['created = 1979-05-27T07:32:00', '<span class="hl-value">1979-05-27T07:32:00</span>'];
        yield 'local date' => ['birthday = 1979-05-27', '<span class="hl-value">1979-05-27</span>'];
        yield 'local time' => ['alarm = 07:32:00', '<span class="hl-value">07:32:00</span>'];
        yield 'array delimiters' => ['ports = [8000, 8001]', '<span class="hl-operator">[</span>'];
        yield 'inline table delimiters' => ['point = { x = 1, y = 2 }', '<span class="hl-operator">{</span>'];
        yield 'key-value separator' => ['title = "TOML"', '<span class="hl-operator">=</span>'];
        yield 'collection separator' => ['ports = [8000, 8001]', '<span class="hl-operator">,</span>'];
    }

    #[Test]
    public function it_has_non_empty_benchmark_and_visual_fixtures(): void
    {
        $this->assertSame('toml.txt', HighlighterBench::LANGUAGES['toml'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/toml.txt', __DIR__ . '/../../targets/toml.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }

    #[Test]
    #[DataProvider('provide_unterminated_input_cases')]
    public function it_avoids_pcre_errors_for_unterminated_input(string $source): void
    {
        foreach ((new TomlLanguage())->getPatterns() as $pattern) {
            preg_match('//', '');

            $pattern->match($source);

            $this->assertSame(PREG_NO_ERROR, preg_last_error(), $pattern::class . ': ' . preg_last_error_msg());
        }
    }

    public static function provide_unterminated_input_cases(): iterable
    {
        yield 'basic string' => ['value = "' . str_repeat('a', 1_000)];
        yield 'multiline basic string' => ['value = """' . str_repeat('a', 1_000)];
        yield 'array' => ['value = [' . str_repeat('1,', 500)];
        yield 'inline table' => ['value = { key = "' . str_repeat('a', 1_000)];
    }
}
