<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Tsx;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Tests\Languages\Jsx\JsxLanguageTest;

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

    #[DataProviderExternal(JsxLanguageTest::class, 'provide_jsx_syntax_cases')]
    public function test_tsx_supports_jsx_syntax(string $source, string $expected): void
    {
        $this->assertSame($expected, new Highlighter()->parse($source, 'tsx'));
    }

    public function test_tsx_distinguishes_a_generic_arrow_from_jsx(): void
    {
        $source = 'const identity = <T extends { id: string },>(value: T): T => value;';

        $this->assertSame(
            '<span class="hl-keyword">const</span> identity = <span class="hl-generic">&lt;T <span class="hl-keyword">extends</span> { <span class="hl-property">id</span>: string },&gt;</span>(<span class="hl-property">value</span>: <span class="hl-type">T</span>): <span class="hl-type">T</span> =&gt; value;',
            new Highlighter()->parse($source, 'tsx'),
        );
    }
}
