<?php

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use Tempest\Highlight\Highlighter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Blade\Injections\BladeKeywordInjection;

class BladeKeywordInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('@if(count($foo))');

        $highlighter = new Highlighter();
        $injection = new BladeKeywordInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $output,
        );
    }
}
