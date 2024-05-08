<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\WebTheme;

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

        $highlighter = $this->highlighter;

        if ($startAt = ($matches['startAt']) ?? null) {
            $highlighter = $highlighter->withGutter((int)$startAt);
        }

        $language = $matches['language'] ?? 'txt';

        $parsed = $highlighter->parse($node->getLiteral(), $language);

        $theme = $highlighter->getTheme();

        if ($theme instanceof WebTheme) {
            return $theme->preBefore($highlighter) . $parsed . $theme->preAfter($highlighter);
        } else {
            return '<pre data-lang="' . $language . '" class="notranslate">' . $parsed . '</pre>';
        }
    }
}
