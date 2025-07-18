<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('createOrModify(namespace\push', 'namespace')]
final class InlineNamespacePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>namespace)\\\\/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}
