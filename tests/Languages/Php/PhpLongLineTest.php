<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class PhpLongLineTest extends TestCase
{
    #[DataProvider('provide_long_literal_keeps_later_tokens_cases')]
    public function test_long_literal_keeps_later_tokens(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertStringContainsString($expected, $highlighter->parse($content, 'php'));
    }

    public static function provide_long_literal_keeps_later_tokens_cases(): iterable
    {
        $long = str_repeat('a', 7000);

        yield 'double quote' => [
            "<?php \$a = \"{$long}\";\n\$b = \"x\";",
            '<span class="hl-value">&quot;x&quot;</span>',
        ];

        yield 'single quote' => [
            "<?php \$a = '{$long}';\n\$b = 'x';",
            "<span class=\"hl-value\">'x'</span>",
        ];

        yield 'escaped double quotes' => [
            '<?php $a = "' . str_repeat('\\"', 7000) . "\";\n\$b = \"x\";",
            '<span class="hl-value">&quot;x&quot;</span>',
        ];

        yield 'line comment' => [
            "<?php // {$long}{$long}\n// x",
            '<span class="hl-comment">// x</span>',
        ];
    }

    public function test_variable_named_like_keyword_in_parameters(): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            '<span class="hl-keyword">&lt;?php</span> <span class="hl-keyword">function</span> <span class="hl-property">swap</span>(<span class="hl-injection">$old, $new, $true</span>) {}',
            $highlighter->parse('<?php function swap($old, $new, $true) {}', 'php'),
        );
    }
}
