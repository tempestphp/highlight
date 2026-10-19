<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Toml;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Toml\TomlLanguage;

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
}
