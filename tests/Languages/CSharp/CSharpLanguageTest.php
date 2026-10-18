<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\CSharp;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\CSharp\CSharpLanguage;

final class CSharpLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_aliases(): void
    {
        $highlighter = new Highlighter();

        foreach (['csharp', 'cs', 'c#'] as $name) {
            $this->assertContains($name, $highlighter->getSupportedLanguageNames());

            $highlighter->parse('', $name);

            $this->assertInstanceOf(CSharpLanguage::class, $highlighter->getCurrentLanguage());
        }
    }
}
