<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\CommonMark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\CommonMark\HighlightExtension;

class HighlightExtensionTest extends TestCase
{
    public function test_highlight_extension(): void
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new HighlightExtension())
            ->addExtension(new FrontMatterExtension());

        $markdown = new MarkdownConverter($environment);

        $parsed = $markdown->convert("```php
        class Foo {}
        ```");

        $this->assertStringContainsString('hl-keyword', $parsed->getContent());
        $this->assertStringContainsString('data-lang="php"', $parsed->getContent());
    }
}
