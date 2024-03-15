<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Css\Injections\CssInjection;

class CssInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('
<x-slot name="styles">
    <style>
        body {
            background-color: red;
        }
    </style>
</x-slot>
        ');

        $highlighter = new Highlighter();
        $injection = new CssInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">background-color</span>',
            $output,
        );
    }
}
