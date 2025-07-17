<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class BladeLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'blade'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            ['{{-- Blade comment --}}', '<span class="hl-comment">{{-- Blade comment --}}</span>'],
            ['{{-- if --}}', '<span class="hl-comment">{{-- if --}}</span>'],
        ];
    }
}
