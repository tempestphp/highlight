<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Toml;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Toml\TomlLanguage;

final class TomlLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('toml', $highlighter->getSupportedLanguageNames());

        $highlighter->parse('', 'toml');

        $this->assertInstanceOf(TomlLanguage::class, $highlighter->getCurrentLanguage());
    }
}
