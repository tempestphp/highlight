<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Kotlin;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Kotlin\KotlinLanguage;

final class KotlinLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name_and_aliases(): void
    {
        $highlighter = new Highlighter();

        foreach (['kotlin', 'kt', 'kts'] as $name) {
            $this->assertContains($name, $highlighter->getSupportedLanguageNames());

            $highlighter->parse('', $name);

            $this->assertInstanceOf(KotlinLanguage::class, $highlighter->getCurrentLanguage());
        }
    }
}
