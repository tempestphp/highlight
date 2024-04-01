<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

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

    public static function data(): array
    {
        return [
            ['01', 'php'], // general
            ['02', 'html'], // deep injections
        ];
    }

    public function test_has_language(): void
    {
        $highlight = new Highlighter();

        self::assertTrue($highlight->hasLanguage('php'));
        self::assertTrue($highlight->hasLanguage('PHP'));
        self::assertTrue($highlight->hasLanguage('Php'));

        self::assertFalse($highlight->hasLanguage('DoesNotExist'));
        self::assertFalse($highlight->hasLanguage('DOESNOTEXIST'));
    }
}
