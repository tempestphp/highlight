<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownBlockquotePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownBoldPattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownCodeFencePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownHeadingPattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownHorizontalRulePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownImagePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownInlineCodePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownItalicAsteriskPattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownItalicUnderscorePattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownLinkPattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownOrderedListPattern;
use Tempest\Highlight\Languages\Markdown\Patterns\MarkdownUnorderedListPattern;

class MarkdownLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'markdown';
    }

    public function getAliases(): array
    {
        return ['md'];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new MarkdownCodeFencePattern(),
            new MarkdownInlineCodePattern(),
            new MarkdownHeadingPattern(),
            new MarkdownBoldPattern(),
            new MarkdownItalicAsteriskPattern(),
            new MarkdownItalicUnderscorePattern(),
            new MarkdownImagePattern(),
            new MarkdownLinkPattern(),
            new MarkdownBlockquotePattern(),
            new MarkdownHorizontalRulePattern(),
            new MarkdownUnorderedListPattern(),
            new MarkdownOrderedListPattern(),
        ];
    }
}
