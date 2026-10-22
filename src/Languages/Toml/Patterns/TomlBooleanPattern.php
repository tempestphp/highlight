<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'enabled = true', output: 'true')]
#[PatternTest(input: 'enabled = false', output: 'false')]
final class TomlBooleanPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![A-Za-z0-9_-])(?<match>true|false)(?![A-Za-z0-9_-])/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::LITERAL;
    }
}
