<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Css\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Css\Injections\CssAttributeInjection;

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
