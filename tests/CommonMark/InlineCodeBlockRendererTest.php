<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\CommonMark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;

class InlineCodeBlockRendererTest extends TestCase
{
    public function test_inline_code_renderer()
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(Code::class, new InlineCodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $parsed = $markdown->convert("`{php}class Foo/*<>*/ {}`");

        $this->assertSame(
            trim('<p><code><span class="hl-keyword">class</span> <span class="hl-type">Foo</span><span class="hl-comment">/*&lt;&gt;*/</span> {}</code></p>'),
            trim($parsed->getContent()),
        );
    }
}
