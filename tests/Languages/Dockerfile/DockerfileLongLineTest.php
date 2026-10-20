<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Dockerfile;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class DockerfileLongLineTest extends TestCase
{
    #[DataProvider('provide_long_literal_keeps_later_tokens_cases')]
    public function test_long_literal_keeps_later_tokens(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertStringContainsString($expected, $highlighter->parse($content, 'dockerfile'));
    }

    public static function provide_long_literal_keeps_later_tokens_cases(): iterable
    {
        $long = str_repeat('a', 7000);

        yield 'double quote' => [
            "RUN [\"{$long}\"]\nRUN [\"x\"]",
            '<span class="hl-value">&quot;x&quot;</span>',
        ];

        yield 'single quote' => [
            "RUN ['{$long}']\nRUN ['x']",
            "<span class=\"hl-value\">'x'</span>",
        ];
    }
}
