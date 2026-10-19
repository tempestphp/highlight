<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Jsx;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class JsxLanguageTest extends TestCase
{
    public function test_jsx_is_registered(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('jsx', $highlighter->getSupportedLanguageNames());
        $this->assertSame(
            '<span class="hl-keyword">class</span> <span class="hl-type">Point</span> {}',
            $highlighter->parse('class Point {}', 'jsx'),
        );
        $this->assertSame('jsx', $highlighter->getCurrentLanguage()?->getName());
    }

    public function test_jsx_registration_preserves_javascript_aliases(): void
    {
        $highlighter = new Highlighter();

        $highlighter->parse('class Point {}', 'javascript');
        $this->assertSame('js', $highlighter->getCurrentLanguage()?->getName());

        $highlighter->parse('class Point {}', 'node');
        $this->assertSame('js', $highlighter->getCurrentLanguage()?->getName());
    }
}
