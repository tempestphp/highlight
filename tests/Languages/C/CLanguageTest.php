<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\C;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\C\CLanguage;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class CLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('c', $highlighter->getSupportedLanguageNames());

        $highlighter->parse('', 'c');

        $this->assertInstanceOf(CLanguage::class, $highlighter->getCurrentLanguage());
    }

    #[Test]
    #[DataProvider('provide_it_highlights_representative_syntax_cases')]
    public function it_highlights_representative_syntax(string $source, string $expected): void
    {
        $highlighted = (new Highlighter())->parse($source, 'c');

        $this->assertStringContainsString($expected, $highlighted);
    }

    public static function provide_it_highlights_representative_syntax_cases(): iterable
    {
        yield 'line comment' => ['// note', '<span class="hl-comment">// note</span>'];
        yield 'block comment' => ['/* note */', '<span class="hl-comment">/* note */</span>'];
        yield 'preprocessor directive' => ['#include <stdio.h>', '<span class="hl-keyword">include</span>'];
        yield 'include path' => ['#include <stdio.h>', '<span class="hl-value">&lt;stdio.h&gt;</span>'];
        yield 'string' => ['"hello\\n"', '<span class="hl-value">&quot;hello\\n&quot;</span>'];
        yield 'character' => ["'x'", '<span class="hl-value">\'x\'</span>'];
        yield 'number' => ['42ULL', '<span class="hl-number">42ULL</span>'];
        yield 'keyword' => ['return', '<span class="hl-keyword">return</span>'];
        yield 'storage qualifier' => ['static', '<span class="hl-keyword">static</span>'];
        yield 'built-in type' => ['int', '<span class="hl-type">int</span>'];
        yield 'declared type' => ['struct Packet { int id; };', '<span class="hl-type">Packet</span>'];
        yield 'typedef alias' => ['typedef unsigned long Result;', '<span class="hl-type">Result</span>'];
        yield 'typedef use' => ['Result make_result(void);', '<span class="hl-type">Result</span>'];
        yield 'typedef cast' => ['return (Result) value;', '<span class="hl-type">Result</span>'];
        yield 'literal' => ['NULL', '<span class="hl-literal">NULL</span>'];
        yield 'function' => ['render();', '<span class="hl-property">render</span>'];
        yield 'operator' => ['node->next', '<span class="hl-operator">-&gt;</span>'];
        yield 'punctuation' => ['return 0;', '<span class="hl-operator">;</span>'];
    }

    #[Test]
    public function it_highlights_declared_types_in_the_benchmark_fixture(): void
    {
        $source = (string) file_get_contents(__DIR__ . '/../../Bench/Fixtures/c.txt');
        $highlighted = (new Highlighter())->parse($source, 'c');

        $this->assertSame(5, substr_count($highlighted, '<span class="hl-type">Result</span>'));
    }

    #[Test]
    public function it_preserves_and_escapes_the_complete_source(): void
    {
        $source = "#include <stdio.h>\r\n"
            . "const char *markup = \"<&copy;> ❷img src=x onerror=alert(1)❸ ❶❹❿\";\r"
            . "const char *script = \"<script>alert('x')</script>\";\r\n";

        $highlighted = (new Highlighter())->parse($source, 'c');
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
        $commentPattern = array_find(
            (new CLanguage())->getPatterns(),
            static fn (object $pattern): bool => $pattern instanceof CLikeCommentPattern,
        );

        $this->assertInstanceOf(CLikeCommentPattern::class, $commentPattern);

        $commentPattern->match('/*' . str_repeat('a', 1_000));

        $this->assertSame(PREG_NO_ERROR, preg_last_error(), preg_last_error_msg());
    }

    #[Test]
    public function it_has_non_empty_benchmark_and_visual_fixtures(): void
    {
        $this->assertSame('c.txt', HighlighterBench::LANGUAGES['c'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/c.txt', __DIR__ . '/../../targets/c.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }
}
