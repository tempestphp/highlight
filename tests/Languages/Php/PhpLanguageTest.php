<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class PhpLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'php'),
        );
    }

    public static function data(): array
    {
        return [
            ["'php()'", "'<span class=\"hl-value\">php()</span>'"],
            ["public const string|\Stringable MESSAGE = 'hi';", '<span class="hl-keyword">public</span> <span class="hl-keyword">const</span> <span class="hl-type">string|\Stringable</span> <span class="hl-property">MESSAGE</span> = \'<span class="hl-value">hi</span>\';'],
            ["public string|\Stringable \$message;", '<span class="hl-keyword">public</span> <span class="hl-type">string|\<span class="hl-type">Stringable</span></span> <span class="hl-property">$message</span>;'],
            ['for($x = 0; $x < 150; $x++) {', '<span class="hl-keyword">for</span>($x = 0; $x &lt; 150; $x++) {'],
            ["'namespace ';", "'<span class=\"hl-value\">namespace </span>';"],
        ];
    }
}
