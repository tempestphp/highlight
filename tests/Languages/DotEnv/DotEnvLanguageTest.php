<?php

namespace Languages\DotEnv;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class DotEnvLanguageTest extends TestCase
{

    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'dotenv'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'env'),
        );
    }

    public static function data(): array
    {
        return [
            [
                <<<ENV
                # Enable or disable discovery cache. Can be `true`, `partial` or `false`.
                DISCOVERY_CACHE=false
                
                # Overwrite default log paths (null = default)
                DEBUG_LOG_PATH=null
                SERVER_LOG_PATH=null
                ENV,
                '<span class="hl-comment"># Enable or disable discovery cache. Can be `true`, `partial` or `false`.</span>
<span class="hl-keyword">DISCOVERY_CACHE</span>=false

<span class="hl-comment"># Overwrite default log paths (null = default)</span>
<span class="hl-keyword">DEBUG_LOG_PATH</span>=null
<span class="hl-keyword">SERVER_LOG_PATH</span>=null',
            ]
        ];
    }
}