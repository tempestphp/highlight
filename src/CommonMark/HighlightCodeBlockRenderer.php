<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Tempest\Highlight\Highlighter;

class HighlightCodeBlockRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! $node instanceof FencedCode) {
            throw new InvalidArgumentException('Block must be instance of ' . FencedCode::class);
        }

        $renderer = new BaseFencedCodeRenderer();

        $language = $node->getInfoWords()[0] ?? 'txt';

        $highlight = new Highlighter();

        /** @var HtmlElement $codeBlock */
        $codeBlock = $renderer->render($node, $childRenderer);

        /** @var string $codeText */
        $codeText = $codeBlock->getContents(false)->getContents();

        $codeBlock->setContents($highlight->parse($codeText, $language));

        $codeBlock->setContents($codeBlock->getContents());

        return $codeBlock;
    }
}
