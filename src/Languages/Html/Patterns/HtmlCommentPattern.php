<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class HtmlCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\&lt;!--(.|\n)*--&gt;)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::COMMENT;
    }
}
