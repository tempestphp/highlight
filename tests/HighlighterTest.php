<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\InlineTheme;

class HighlighterTest extends TestCase
{
    #[Test]
    #[DataProvider('data')]
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
        $highlighter = (new Highlighter(new InlineTheme(__DIR__ . '/../src/Themes/min-light.css')));

        $output = $highlighter->parse('echo 1', 'php');

        $this->assertSame('<span style="color: #D32F2F;">echo</span> 1', $output);
    }

    public static function data(): array
    {
        return [
            ['01', 'php'], // general
            ['02', 'html'], // deep injections
        ];
    }
}
