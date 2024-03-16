<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class BladeCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\{\{\-\-(.|\n)*?\-\-\}\})';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::COMMENT;
    }
}
