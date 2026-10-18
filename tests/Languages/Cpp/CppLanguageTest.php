<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Cpp;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\Cpp\CppLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class CppLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_alias(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('cpp', $highlighter->getSupportedLanguageNames());
        $this->assertContains('c++', $highlighter->getSupportedLanguageNames());

        foreach (['cpp', 'c++'] as $name) {
            $highlighter->parse('', $name);

            $this->assertInstanceOf(CppLanguage::class, $highlighter->getCurrentLanguage());
        }
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'cpp');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'block comment' => ['/* note */', '<span class="hl-comment">/* note */</span>'];
        yield 'preprocessor directive' => ['#include <vector>', '<span class="hl-keyword">include</span>'];
        yield 'include path' => ['#include <vector>', '<span class="hl-value">&lt;vector&gt;</span>'];
        yield 'string' => ['"hello"', '<span class="hl-value">&quot;hello&quot;</span>'];
        yield 'raw string' => ['R"tag(hello)tag"', '<span class="hl-value">R&quot;tag(hello)tag&quot;</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'number' => ["1'000ULL", '<span class="hl-number">1\'000ULL</span>'];
        yield 'keyword' => ['constexpr', '<span class="hl-keyword">constexpr</span>'];
        yield 'built-in type' => ['bool', '<span class="hl-type">bool</span>'];
        yield 'declared type' => ['class Widget {};', '<span class="hl-type">Widget</span>'];
        yield 'literal' => ['nullptr', '<span class="hl-literal">nullptr</span>'];
        yield 'namespace' => ['namespace demo {}', '<span class="hl-type">demo</span>'];
        yield 'template' => ['template<typename T>', '<span class="hl-keyword">template</span>'];
        yield 'template type parameter' => ['template<typename T>', '<span class="hl-type">T</span>'];
        yield 'function' => ['render();', '<span class="hl-property">render</span>'];
        yield 'operator' => ['std::move(value)', '<span class="hl-operator">::</span>'];
        yield 'punctuation' => ['return {};', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "#include <string>\r\n"
            . "auto markup = R\"(<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿)\";\r"
            . "auto script = \"<script>alert('x')</script>\";\r\n";

        $highlighted = (new Highlighter())->parse($source, 'cpp');
        $renderedSource = html_entity_decode(strip_tags($highlighted), ENT_QUOTES | ENT_HTML5);

        $this->assertSame($source, $renderedSource);
        $this->assertStringNotContainsString('<script>', $highlighted);
        $this->assertStringNotContainsString('<img', $highlighted);
        $this->assertStringContainsString('&lt;script&gt;', $highlighted);
        $this->assertStringContainsString('&amp;copy;', $highlighted);
    }

    #[Test]
    public function it_avoids_backtracking_errors_for_unterminated_block_comments(): void
    {
        (new CLikeCommentPattern())->match('/*' . str_repeat('a', 1_000));

        $this->assertSame(PREG_NO_ERROR, preg_last_error(), preg_last_error_msg());
    }

    #[Test]
    public function it_has_non_empty_benchmark_and_visual_fixtures(): void
    {
        $this->assertSame('cpp.txt', HighlighterBench::LANGUAGES['cpp'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/cpp.txt', __DIR__ . '/../../targets/cpp.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }
}
