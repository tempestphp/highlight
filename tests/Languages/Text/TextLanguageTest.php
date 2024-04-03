<?php

namespace Tempest\Highlight\Tests\Languages\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use Tempest\Highlight\Highlighter;
use PHPUnit\Framework\TestCase;

class TextLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'txt'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'text'),
        );
    }

    public static function data(): array
    {
        return [
            ['test', 'test'],
        ];
    }
}
