<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'instanceof Closure', output: 'Closure')]
#[PatternTest(input: 'instanceof (Closure&Foo)|null', output: '(Closure&Foo)|null')]
final readonly class InstanceOfPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'instanceof\s(?<match>' . PhpLanguage::TYPE_REGEX . ')';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
