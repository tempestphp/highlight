<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class ReturnTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\)\:\s(?<match>' . PhpLanguage::TYPE_REGEX .')';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
