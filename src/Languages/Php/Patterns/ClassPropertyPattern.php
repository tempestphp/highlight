<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class ClassPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(public|private|protected)\s(' . PhpLanguage::TYPE_REGEX .')\s(?<match>\\$[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
