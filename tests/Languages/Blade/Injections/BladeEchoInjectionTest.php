<?php

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Blade\Injections\BladeEchoInjection;
use PHPUnit\Framework\TestCase;

class BladeEchoInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('{{ count($foo) }}');

        $highlighter = new Highlighter();
        $injection = new BladeEchoInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $output,
        );
    }

    #[Test]
    public function test_injection_raw_echo(): void
    {
        $content = htmlentities('{!! count($foo) !!}');

        $highlighter = new Highlighter();
        $injection = new BladeEchoInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $output,
        );
    }
}
