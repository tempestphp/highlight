<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Graphql;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class GraphqlLongLineTest extends TestCase
{
    public function test_long_string_keeps_later_strings(): void
    {
        $highlighter = new Highlighter();

        $this->assertStringContainsString(
            '&quot;<span class="hl-value">x</span>&quot;',
            $highlighter->parse('f(a: "' . str_repeat('a', 7000) . "\")\nf(b: \"x\")", 'graphql'),
        );
    }

    public function test_long_word_keeps_later_fields(): void
    {
        $highlighter = new Highlighter();

        $this->assertStringContainsString(
            '<span class="hl-property">field</span>',
            $highlighter->parse(str_repeat('a', 600000) . "\nfield: String", 'graphql'),
        );
    }
}
