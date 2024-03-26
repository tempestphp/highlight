<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Themes;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

class LightTerminalThemeTest extends TestCase
{
    public function test_injection_tokens_are_filtered(): void
    {
        $highlighter = new Highlighter(new LightTerminalTheme());

        $parsed = $highlighter->parse('{~}): Foo {}~}', 'php');

        $this->assertStringNotContainsString(Escape::INJECTION_TOKEN, $parsed);
    }
}
