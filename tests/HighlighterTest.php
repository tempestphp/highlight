<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Languages\Sql\SqlLanguage;
use Tempest\Highlight\Languages\Text\TextLanguage;
use Tempest\Highlight\Themes\InlineTheme;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class HighlighterTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $slug, string $language): void
    {
        $highlight = new Highlighter();

        $content = file_get_contents(__DIR__ . "/stubs/{$slug}.txt");
        [$input, $output] = explode('===', $content);

        $this->assertSame(
            trim($output),
            trim($highlight->parse($input, $language)),
        );
    }

    public function test_escaped_with_unknown_language(): void
    {
        $highlight = new Highlighter();

        $output = $highlight->parse('<style>', 'unknown');
        $this->assertSame('&lt;style&gt;', $output);
    }

    public function test_reserved_markers_are_removed_from_original_input(): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            '<span class="hl-property">{</span><span class="hl-keyword">&quot;a&quot;</span>: <span class="hl-value">&quot;img src=x onerror=alert(1)&quot;</span><span class="hl-property">}</span>',
            $highlighter->parse('{"a": "❷img src=x onerror=alert(1)❸"}', 'json'),
        );
    }

    public function test_inline_theme(): void
    {
        $highlighter = (new Highlighter(new InlineTheme(__DIR__ . '/../src/Themes/Css/min-light.css')));

        $output = $highlighter->parse('echo 1', 'php');

        $this->assertSame('<span style="color: #D32F2F;">echo</span> 1', $output);
    }

    public function test_get_supported_languages(): void
    {
        $highlighter = new Highlighter();

        $this->assertTrue(in_array('php', $highlighter->getSupportedLanguageNames()));
    }

    public function test_added_languages_are_available_in_nested_highlighter_after_initial_parse(): void
    {
        $highlighter = new Highlighter();

        $highlighter->parse('echo 1', 'php');

        $highlighter
            ->addLanguage(new class () implements Language {
                public function getName(): string
                {
                    return 'inner';
                }

                public function getAliases(): array
                {
                    return [];
                }

                public function getInjections(): array
                {
                    return [];
                }

                public function getPatterns(): array
                {
                    return ['(?<match>foo)' => TokenTypeEnum::KEYWORD];
                }
            })
            ->addLanguage(new class () implements Language {
                public function getName(): string
                {
                    return 'outer';
                }

                public function getAliases(): array
                {
                    return [];
                }

                public function getInjections(): array
                {
                    return [new class () implements Injection {
                        use IsInjection;

                        public function getPattern(): string
                        {
                            return '(?<match>foo)';
                        }

                        public function parseContent(string $content, Highlighter $highlighter): string
                        {
                            return $highlighter->parse($content, 'inner');
                        }
                    }];
                }

                public function getPatterns(): array
                {
                    return [];
                }
            });

        $this->assertSame(
            '<span class="hl-keyword">foo</span>',
            $highlighter->parse('foo', 'outer'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            ['01', 'php'], // general
            ['02', 'html'], // deep injections
            ['03', 'php'], // windows line endings
        ];
    }

    public function test_fallback_language(): void
    {
        $highlighter = new Highlighter(fallbackLanguage: new PhpLanguage());

        $highlighted = $highlighter->parse('echo "hi";', null);

        $this->assertSame(
            '<span class="hl-keyword">echo</span> <span class="hl-value">&quot;hi&quot;</span>;',
            $highlighted,
        );

        $highlighted = $highlighter->parse('echo "hi";', 'unknown');

        $this->assertSame(
            '<span class="hl-keyword">echo</span> <span class="hl-value">&quot;hi&quot;</span>;',
            $highlighted,
        );
    }

    #[Test]
    public function text_language_does_not_use_the_configured_fallback_language(): void
    {
        $highlighter = new Highlighter(fallbackLanguage: new PhpLanguage());

        $this->assertSame('mcp:list', $highlighter->parse('mcp:list', 'txt'));
        $this->assertSame('resources/list', $highlighter->parse('resources/list', 'text'));
        $this->assertSame('Sec-Fetch-Site', $highlighter->parse('Sec-Fetch-Site', 'txt'));
    }

    #[Test]
    #[DataProvider('provide_large_multiline_blocks_are_highlighted_cases')]
    public function large_multiline_blocks_are_highlighted(string $language, string $before, string $after, string $expected): void
    {
        // Large enough to exhaust the PCRE JIT stack with a `(.|\n)*?` pattern
        $content = $before . str_repeat("lorem ipsum dolor\n", 6000) . $after;

        $this->assertStringContainsString($expected, new Highlighter()->parse($content, $language));
    }

    public static function provide_large_multiline_blocks_are_highlighted_cases(): iterable
    {
        yield 'php comment' => ['php', "<?php\n/*", "*/\n", '<span class="hl-comment">/*'];
        yield 'php doc comment' => ['php', "<?php\n/**", "*/\n", '<span class="hl-comment">/**'];
        yield 'javascript comment' => ['javascript', '/*', '*/', '<span class="hl-comment">/*'];
        yield 'css comment' => ['css', '/*', '*/', '<span class="hl-comment">/*'];
        yield 'sql comment' => ['sql', '/*', '*/', '<span class="hl-comment">/*'];
        yield 'xml comment' => ['xml', '<!--', '-->', '<span class="hl-comment">&lt;!--'];
        yield 'twig comment' => ['twig', '{#', '#}', '<span class="hl-comment">{#'];
        yield 'blade comment' => ['blade', '{{--', '--}}', '<span class="hl-comment">{{--'];
        yield 'python string' => ['python', 'x = """', '"""', '<span class="hl-value">&quot;&quot;&quot;'];
        yield 'html script' => ['html', '<script>', 'const x = 1;</script>', '<span class="hl-keyword">const</span>'];
        yield 'addition' => ['php', '{+', '+}', '<span class="hl-addition">'];
    }

    #[Test]
    public function freed_language_cache_is_not_reused_by_a_new_language(): void
    {
        $base = new Highlighter();
        $base->parse('SELECT * FROM users', new SqlLanguage());

        $highlighter = $base->withGutter();
        unset($base);

        // Drops the last reference to the SqlLanguage, so PHP can hand its
        // object id to the next object, here the PhpLanguage below
        $highlighter->setCurrentLanguage(new TextLanguage());
        $highlighted = $highlighter->parse('<?php echo $foo;', new PhpLanguage());

        $this->assertSame(
            '<span class="hl-gutter">1</span><span class="hl-keyword">&lt;?php</span> <span class="hl-keyword">echo</span> <span class="hl-variable">$foo</span>;',
            $highlighted,
        );
    }
}
