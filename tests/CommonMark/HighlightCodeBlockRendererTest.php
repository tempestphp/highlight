<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\CommonMark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\CommonMark\HighlightCodeBlockRenderer;

class HighlightCodeBlockRendererTest extends TestCase
{
    public function test_commonmark(): void
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(FencedCode::class, new HighlightCodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $parsed = $markdown->convert("```php
        class Foo {}
        ```");

        $this->assertStringContainsString('hl-keyword', $parsed->getContent());
    }
}
