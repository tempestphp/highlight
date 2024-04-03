<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Blade\Injections\BladeKeywordInjection;

class BladeKeywordInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = '@if(count($foo))';

        $highlighter = new Highlighter();
        $injection = new BladeKeywordInjection();

        $parsedInjection = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $parsedInjection->content,
        );
    }
}
