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

class CodeBlockRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! $node instanceof FencedCode) {
            throw new InvalidArgumentException('Block must be instance of ' . FencedCode::class);
        }

        $highlight = new Highlighter();
        $code = $node->getLiteral();
        $language = $node->getInfoWords()[0] ?? 'txt';

        return new HtmlElement(
            'pre',
            [],
            $highlight->parse($code, $language)
        );
    }
}
