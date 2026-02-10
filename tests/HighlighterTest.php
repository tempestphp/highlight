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
}
