<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Jsx;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Jsx\JsxLanguage;
use Tempest\Highlight\Tests\Bench\HighlighterBench;

final class JsxLanguageTest extends TestCase
{
    public function test_jsx_is_registered(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('jsx', $highlighter->getSupportedLanguageNames());
        $this->assertSame(
            '<span class="hl-keyword">class</span> <span class="hl-type">Point</span> {}',
            $highlighter->parse('class Point {}', 'jsx'),
        );
        $this->assertSame('jsx', $highlighter->getCurrentLanguage()?->getName());
    }

    public function test_jsx_registration_preserves_javascript_aliases(): void
    {
        $highlighter = new Highlighter();

        $highlighter->parse('class Point {}', 'javascript');
        $this->assertSame('js', $highlighter->getCurrentLanguage()?->getName());

        $highlighter->parse('class Point {}', 'node');
        $this->assertSame('js', $highlighter->getCurrentLanguage()?->getName());
    }

    public function test_jsx_preserves_and_escapes_the_complete_source(): void
    {
        $source = "const view = <script>\r\n"
            . "    <div title=\"<&copy;> ❷img src=x onerror=alert(1)❸\">❶❹❿</div>\r"
            . "</script>;\r\n";

        $highlighted = (new Highlighter())->parse($source, 'jsx');
        $renderedSource = html_entity_decode(strip_tags($highlighted), ENT_QUOTES | ENT_HTML5);

        $this->assertSame($source, $renderedSource);
        $this->assertStringNotContainsString('<script>', $highlighted);
        $this->assertStringNotContainsString('<img', $highlighted);
        $this->assertStringContainsString('&lt;<span class="hl-type">script</span>&gt;', $highlighted);
        $this->assertStringContainsString('&amp;copy;', $highlighted);
    }

    public function test_jsx_has_non_empty_benchmark_and_visual_fixtures(): void
    {
        $this->assertSame('jsx.txt', HighlighterBench::LANGUAGES['jsx'] ?? null);

        foreach ([__DIR__ . '/../../Bench/Fixtures/jsx.txt', __DIR__ . '/../../targets/jsx.md'] as $fixture) {
            $this->assertFileExists($fixture);
            $this->assertNotSame('', trim((string) file_get_contents($fixture)));
        }
    }

    #[DataProvider('provide_jsx_avoids_backtracking_errors_for_unterminated_input_cases')]
    public function test_jsx_avoids_backtracking_errors_for_unterminated_input(string $source): void
    {
        foreach ((new JsxLanguage())->getPatterns() as $pattern) {
            preg_match('//', '');

            $pattern->match($source);

            $this->assertSame(PREG_NO_ERROR, preg_last_error(), $pattern::class . ': ' . preg_last_error_msg());
        }
    }

    public static function provide_jsx_avoids_backtracking_errors_for_unterminated_input_cases(): iterable
    {
        return [
            'tag' => ['<Widget ' . str_repeat('a', 1_000)],
            'quoted attribute' => ['<Widget title="' . str_repeat('a', 1_000)],
            'embedded expression' => ['<Widget>{' . str_repeat('a', 1_000)],
        ];
    }

    #[DataProvider('provide_jsx_syntax_cases')]
    public function test_jsx_syntax(string $source, string $expected): void
    {
        $this->assertSame($expected, new Highlighter()->parse($source, 'jsx'));
    }

    public static function provide_jsx_syntax_cases(): iterable
    {
        return [
            'intrinsic tag, attribute, text, and entity' => [
                '<div id="root">Hello &amp; welcome</div>',
                '&lt;<span class="hl-type">div</span> <span class="hl-property">id</span>=<span class="hl-value">&quot;root&quot;</span>&gt;Hello <span class="hl-value">&amp;amp;</span> welcome&lt;/<span class="hl-type">div</span>&gt;',
            ],
            'fragment and component tag forms' => [
                '<> <Button /> <UI.Icon /> <svg:path /> </>',
                '<span class="hl-keyword">&lt;&gt;</span> &lt;<span class="hl-type">Button</span> /&gt; &lt;<span class="hl-type">UI.Icon</span> /&gt; &lt;<span class="hl-type">svg:path</span> /&gt; <span class="hl-keyword">&lt;/&gt;</span>',
            ],
            'spread, expression, and comment' => [
                "<Widget title='Hi' {...props} disabled>{items.map(render)}{/* note */}</Widget>",
                '&lt;<span class="hl-type">Widget</span> <span class="hl-property">title</span>=<span class="hl-value">\'Hi\'</span> <span class="hl-attribute">{...<span class="hl-property">props</span>}</span> <span class="hl-property">disabled</span>&gt;{items.<span class="hl-property">map</span>(render)}{<span class="hl-comment">/* note */</span>}&lt;/<span class="hl-type">Widget</span>&gt;',
            ],
            'javascript with member component' => [
                'const view = active ? <Panel.Item /> : null;',
                '<span class="hl-keyword">const</span> view = active ? &lt;<span class="hl-type">Panel.Item</span> /&gt; : <span class="hl-keyword">null</span>;',
            ],
        ];
    }
}
