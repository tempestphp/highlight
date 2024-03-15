<?php

namespace Tempest\Highlight\Tests\Languages\Css\Injections;

use PHPUnit\Framework\Attributes\Test;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Css\Injections\CssAttributeInjection;
use PHPUnit\Framework\TestCase;

class CssAttributeInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('
<x-slot style="color: green">
        ');

        $highlighter = new Highlighter();
        $injection = new CssAttributeInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">color</span>',
            $output,
        );
    }
}
