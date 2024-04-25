<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\ExtensionInterface;
use Tempest\Highlight\Highlighter;

final class HighlightExtension implements ExtensionInterface
{
    public function __construct(
        private ?Highlighter $highlighter = new Highlighter(),
    ) {
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addRenderer(FencedCode::class, new CodeBlockRenderer($this->highlighter), 10)
            ->addRenderer(Code::class, new InlineCodeBlockRenderer($this->highlighter), 10)
        ;
    }
}
