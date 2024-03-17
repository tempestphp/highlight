<?php

namespace Tempest\Highlight\Tests\CommonMark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;
use PHPUnit\Framework\TestCase;

class InlineCodeBlockRendererTest extends TestCase
{
    /** @test */
    public function test_inline_code_renderer()
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(Code::class, new InlineCodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $parsed = $markdown->convert("`{php}class Foo {}`");

        $this->assertStringContainsString('hl-keyword', $parsed->getContent());
    }
}
