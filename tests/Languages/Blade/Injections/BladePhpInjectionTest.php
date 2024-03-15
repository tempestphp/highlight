<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Blade\Injections\BladePhpInjection;

class BladePhpInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('
        @php
        count($foo)
        @endphp
        ');

        $highlighter = new Highlighter();
        $injection = new BladePhpInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $output,
        );
    }
}
