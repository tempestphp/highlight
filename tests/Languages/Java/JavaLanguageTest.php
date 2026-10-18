<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Java;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Java\JavaLanguage;

final class JavaLanguageTest extends TestCase
{
    #[Test]
    public function it_registers_the_language_name(): void
    {
        $highlighter = new Highlighter();

        $this->assertContains('java', $highlighter->getSupportedLanguageNames());

        $highlighter->parse('', 'java');

        $this->assertInstanceOf(JavaLanguage::class, $highlighter->getCurrentLanguage());
    }
}
