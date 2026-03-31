<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Scss;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class ScssLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'scss'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            // SCSS variable
            [
                '$primary: #333;',
                '<span class="hl-variable">$primary</span>: #333;',
            ],
            // Single-line comment
            [
                '// this is a comment',
                '<span class="hl-comment">// this is a comment</span>',
            ],
            // Mixin definition
            [
                '@mixin rounded {',
                '<span class="hl-keyword">@mixin rounded </span>{',
            ],
            // @include
            [
                '@include rounded;',
                '<span class="hl-keyword">@include</span> rounded;',
            ],
            // Parent selector (& is HTML-encoded)
            [
                '&:hover {',
                '<span class="hl-keyword">&amp;:hover </span>{',
            ],
            // Placeholder selector
            [
                '%placeholder {',
                '<span class="hl-keyword">%placeholder </span>{',
            ],
            // @each keyword with variables
            [
                '@each $color in $colors {',
                '<span class="hl-keyword">@each</span> <span class="hl-variable">$color</span> in <span class="hl-variable">$colors</span> {',
            ],
            // CSS features still work
            [
                '@media only screen and (max-width: 500px) {}',
                '<span class="hl-keyword">@media only screen and (max-width: 500px) </span>{}',
            ],
            // CSS property
            [
                'color: $primary;',
                '<span class="hl-property">color</span>: <span class="hl-variable">$primary</span>;',
            ],
            // SCSS function
            [
                'background: darken($color, 10%);',
                '<span class="hl-property">background</span>: <span class="hl-keyword">darken</span>(<span class="hl-variable">$color</span>, 10%);',
            ],
        ];
    }
}
