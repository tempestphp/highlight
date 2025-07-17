<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TextLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
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

    public static function provide_highlight_cases(): iterable
    {
        return [
            ['test', 'test'],
        ];
    }
}
