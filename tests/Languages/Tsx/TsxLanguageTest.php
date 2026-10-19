<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Tsx;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class TsxLanguageTest extends TestCase
{
    public function test_tsx_is_registered(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('tsx', $highlighter->getSupportedLanguageNames());
        $this->assertSame(
            '<span class="hl-keyword">type</span> Alias = <span class="hl-type">string</span>;',
            $highlighter->parse('type Alias = string;', 'tsx'),
        );
        $this->assertSame('tsx', $highlighter->getCurrentLanguage()?->getName());
    }

    public function test_tsx_registration_preserves_typescript_alias(): void
    {
        $highlighter = new Highlighter();

        $highlighter->parse('type Alias = string;', 'typescript');

        $this->assertSame('ts', $highlighter->getCurrentLanguage()?->getName());
    }
}
