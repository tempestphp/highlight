<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\CommonMark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;

class CodeBlockRendererTest extends TestCase
{
    public function test_commonmark(): void
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(FencedCode::class, new CodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $parsed = $markdown->convert("```php
        class Foo {}
        ```");

        $this->assertStringContainsString('hl-keyword', $parsed->getContent());
    }

    public function test_commonmark_with_gutter(): void
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(FencedCode::class, new CodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $input = <<<'TXT'
```php{10}
class Foo {}
```
TXT;

        $expected = <<<'TXT'
<pre><span class="hl-gutter ">10</span> <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> {}</pre>

TXT;

        $this->assertSame($expected, $markdown->convert($input)->getContent());
    }
}
