<?php

declare(strict_types=1);

namespace Languages\Dockerfile;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class DockerfileLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'dockerfile'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            ['FROM python:3.13', '<span class="hl-keyword">FROM</span> <span class="hl-value">python</span>:<span class="hl-value">3.13</span>'],
            ['FROM php AS stage-one', '<span class="hl-keyword">FROM</span> <span class="hl-value">php</span> <span class="hl-keyword">AS</span> <span class="hl-value">stage-one</span>'],
            ['WORKDIR /usr/local/app', '<span class="hl-keyword">WORKDIR</span> /usr/local/app'],
            ['CMD ["node", "./src/index.js"]', '<span class="hl-keyword">CMD</span> [<span class="hl-value">&quot;node&quot;</span>, <span class="hl-value">&quot;./src/index.js&quot;</span>]'],
            ['# This is a comment', '<span class="hl-comment"># This is a comment</span>'],
        ];
    }
}
