<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Kotlin;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\Kotlin\KotlinLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class KotlinLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_aliases(): void
    {
        $highlighter = new Highlighter();

        foreach (['kotlin', 'kt', 'kts'] as $name) {
            $this->assertContains($name, $highlighter->getSupportedLanguageNames());

            $highlighter->parse('', $name);

            $this->assertInstanceOf(KotlinLanguage::class, $highlighter->getCurrentLanguage());
        }
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'kotlin');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'package keyword' => ['package com.example', '<span class="hl-keyword">package</span>'];
        yield 'package name' => ['package com.example', '<span class="hl-type">com<span class="hl-operator">.</span>example</span>'];
        yield 'import' => ['import kotlin.collections.List', '<span class="hl-keyword">import</span>'];
        yield 'annotation' => ['@file:JvmName', '<span class="hl-attribute">@file<span class="hl-operator">:</span>JvmName</span>'];
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'KDoc' => ['/** note */', '<span class="hl-comment">/** note */</span>'];
        yield 'string' => ['"hello $name"', '<span class="hl-value">&quot;hello $name&quot;</span>'];
        yield 'multiline interpolated string' => ['"""hello ${name}"""', '<span class="hl-value">&quot;&quot;&quot;hello ${name}&quot;&quot;&quot;</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'number' => ['0xCAFE_F00DuL', '<span class="hl-number">0xCAFE_F00DuL</span>'];
        yield 'keyword' => ['return', '<span class="hl-keyword">return</span>'];
        yield 'modifier' => ['data', '<span class="hl-keyword">data</span>'];
        yield 'built-in type' => ['String', '<span class="hl-type">String</span>'];
        yield 'class' => ['class Widget', '<span class="hl-type">Widget</span>'];
        yield 'interface' => ['interface Service', '<span class="hl-type">Service</span>'];
        yield 'object' => ['object Registry', '<span class="hl-type">Registry</span>'];
        yield 'type alias' => ['typealias Identifier = String', '<span class="hl-type">Identifier</span>'];
        yield 'literal' => ['return null', '<span class="hl-literal">null</span>'];
        yield 'function' => ['fun render()', '<span class="hl-property">render</span>'];
        yield 'call' => ['render()', '<span class="hl-property">render</span>'];
        yield 'callable reference' => ['::render', '<span class="hl-property">render</span>'];
        yield 'property' => ['val name = "Ada"', '<span class="hl-variable">name</span>'];
        yield 'lambda' => ['value -> value + 1', '<span class="hl-operator">-&gt;</span>'];
        yield 'operator' => ['value ?: fallback', '<span class="hl-operator">?:</span>'];
        yield 'punctuation' => ['return value;', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "class Markup {\r\n"
            . "    val value = \"<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿\"\r"
            . "    val script = \"<script>alert('x')</script>\"\r\n"
            . "}\r\n";

        $highlighted = (new Highlighter())->parse($source, 'kotlin');
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
        $this->assertSame('kotlin.txt', HighlighterBench::LANGUAGES['kotlin'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/kotlin.txt', __DIR__ . '/../../targets/kotlin.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }

    #[Test]
    public function it_avoids_backtracking_errors_for_unterminated_block_comments(): void
    {
        $commentPattern = array_find(
            (new KotlinLanguage())->getPatterns(),
            static fn (object $pattern): bool => $pattern instanceof CLikeCommentPattern,
        );

        $this->assertInstanceOf(CLikeCommentPattern::class, $commentPattern);

        $commentPattern->match('/*' . str_repeat('a', 1_000));

        $this->assertSame(PREG_NO_ERROR, preg_last_error(), preg_last_error_msg());
    }
}
