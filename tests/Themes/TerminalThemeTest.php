<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Themes;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

class TerminalThemeTest extends TestCase
{
    public function test_terminal_theme()
    {
        $content = <<<TXT
public function before
TXT;

        $highlighter = new Highlighter(new LightTerminalTheme());

        $output = $highlighter->parse($content, 'php');

        $this->assertSame(
            "\e[34mpublic\e[0m \e[34mfunction\e[0m \e[32mbefore\e[0m",
            $output,
        );
    }
}
