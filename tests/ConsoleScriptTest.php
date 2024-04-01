<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

class ConsoleScriptTest extends TestCase
{
    private function getHighlightCommand(): string
    {
        $commandPath = realpath(__DIR__ . '/../bin/tempest-highlight');

        return "php '$commandPath'";
    }

    public function test_run_as_a_shell_script(): void
    {
        $expected = "Usage: tempest-highlight: [language] '[content]'";
        exec($this->getHighlightCommand(), $actual, $resultCode);

        $this->assertEquals([$expected], $actual);
        $this->assertEquals(1, $resultCode);
        ;
    }

    public function test_can_highlight_code_in_a_terminal_via_cli_args(): void
    {
        $code = <<<'PHP'
        echo "Hello, World!!\n";
        PHP;

        $command = $this->getHighlightCommand() . ' PHP ' . escapeshellarg($code);
        $actual = exec($command, $unused, $resultCode);

        $expected = (new Highlighter(new LightTerminalTheme()))->parse($code, 'php');

        $this->assertEquals(0, $resultCode);
        $this->assertSame($expected, $actual);
    }

    public function test_supports_text_from_stdin_including_nowdoc(): void
    {
        $phpTest = function () {
            $code = <<<'PHP'
            for ($a = 6; $a > 0; --$a) {
                echo "<h$a>Hello, PHP!</h$a>\n";
            }
            PHP;

            $command = $this->getHighlightCommand();
            $shellScript = <<<BASH
            $command php <<'PHP'
            {$code}
            PHP
            BASH;

            exec($shellScript, $actual, $resultCode);
            $actual = implode("\n", $actual);

            $expected = (new Highlighter(new LightTerminalTheme()))->parse($code, 'php') . "\n";

            $this->assertEquals(0, $resultCode);
            $this->assertSame($expected, $actual);
        };

        $jsTest = function () {
            $code = <<<'JS'
            console.log('This is a multi-line coding sample.');
            console.log('It is meant to test HERDOC-on-the-console support.');
            JS;

            $command = $this->getHighlightCommand();
            $shellScript = <<<BASH
            $command js <<'JS'
            {$code}
            JS
            BASH;

            exec($shellScript, $actual, $resultCode);
            $actual = implode("\n", $actual);

            $expected = (new Highlighter(new LightTerminalTheme()))->parse($code, 'javascript') . "\n";

            $this->assertEquals(0, $resultCode);
            $this->assertSame($expected, $actual);
        };

        $phpTest();
        $jsTest();
    }

    public function test_will_fail_if_given_unsupported_language(): void
    {
        $command = $this->getHighlightCommand() . ' DOESNT_EXIST asdf';
        exec($command, $output, $resultCode);

        $expected = "Error: 'DOESNT_EXIST' is not a currently supported language.";
        $this->assertEquals(2, $resultCode);
        $this->assertEquals([$expected], $output);
    }
}
