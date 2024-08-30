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
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\InlineTheme;

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
        $this->assertStringContainsString('data-lang="php"', $parsed->getContent());
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
<pre data-lang="php" class="notranslate"><span class="hl-gutter">10</span><span class="hl-keyword">class</span> <span class="hl-type">Foo</span> {}</pre>

TXT;

        $this->assertSame($expected, $markdown->convert($input)->getContent());
    }

    public function test_commonmark_with_pre(): void
    {

        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(FencedCode::class, new CodeBlockRenderer(new Highlighter(new InlineTheme(__DIR__ . '/../../src/Themes/Css/min-light.css'))));

        $markdown = new MarkdownConverter($environment);

        $input = <<<'TXT'
```php
echo;
```
TXT;

        $expected = <<<'TXT'
<pre data-lang="php" class="notranslate" style="color: #212121; background-color: #ffffff;"><span style="color: #D32F2F;">echo</span>;
</pre>

TXT;

        $this->assertSame($expected, $markdown->convert($input)->getContent());
    }

    public function test_commonmark_with_no_language(): void
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new FrontMatterExtension())
            ->addRenderer(FencedCode::class, new CodeBlockRenderer());

        $markdown = new MarkdownConverter($environment);

        $input = <<<'TXT'
```
echo;
```
TXT;

        $expected = <<<'TXT'
<pre data-lang="txt" class="notranslate">echo;
</pre>

TXT;

        $this->assertSame($expected, $markdown->convert($input)->getContent());
    }
}
