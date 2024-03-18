<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class PhpLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $input, string $output): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $highlighter->parse($input, 'php'),
            $output,
        );
    }

    public static function data(): array
    {
        return [
            ["'php()'", "'<span class=\"hl-value\">php()</span>'"],
        ];
    }
}
