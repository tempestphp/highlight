<?php

namespace Languages\Ini;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class IniLanguageTest extends TestCase
{

    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'ini'),
        );
    }

    public static function data(): array
    {
        return [
            [
                <<<INI
                [PHP]
                
                ;zend_extension = xdebug
                xdebug.mode = profile
                xdebug.output_dir = /Users/brentroose/Desktop
                xdebug.profiler_output_name = cachegrind.out.%p
                
                ;;;;;;;;;;;;;;;;;;;
                ; About php.ini   ;
                ;;;;;;;;;;;;;;;;;;;
                INI,
                '<span class="hl-keyword">[PHP]</span>

<span class="hl-comment">;zend_extension = xdebug</span>
<span class="hl-property">xdebug.mode </span>= profile
<span class="hl-property">xdebug.output_dir </span>= /Users/brentroose/Desktop
<span class="hl-property">xdebug.profiler_output_name </span>= cachegrind.out.%p

<span class="hl-comment">;;;;;;;;;;;;;;;;;;;</span>
<span class="hl-comment">; About php.ini   ;</span>
<span class="hl-comment">;;;;;;;;;;;;;;;;;;;</span>',
            ]
        ];
    }
}