<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Tempest\Highlight\Highlighter;

final class CodeBlockRenderer implements NodeRendererInterface
{
    public function __construct(
        private Highlighter $highlighter = new Highlighter(),
    ) {
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! $node instanceof FencedCode) {
            throw new InvalidArgumentException('Block must be instance of ' . FencedCode::class);
        }

        $code = $node->getLiteral();
        $language = $node->getInfoWords()[0] ?? 'txt';

        return new HtmlElement(
            'pre',
            [],
            $this->highlighter->parse($code, $language)
        );
    }
}
