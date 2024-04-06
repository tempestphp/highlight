<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\WithPre;

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

        preg_match('/^(?<language>[\w]+)(\{(?<startAt>[\d]+)\})?/', $node->getInfoWords()[0] ?? 'txt', $matches);

        if ($startAt = ($matches['startAt']) ?? null) {
            $this->highlighter->withGutter((int)$startAt);
        }

        $language = $matches['language'] ?? 'txt';

        $parsed = $this->highlighter->parse($node->getLiteral(), $language);

        $theme = $this->highlighter->getTheme();

        if ($theme instanceof WithPre) {
            return $theme->preBefore() . $parsed . $theme->preAfter();
        } else {
            return '<pre data-lang="' . $language . '">' . $parsed . '</pre>';
        }
    }
}
