<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'npm init @eslint/config', output: '@eslint/config')]
#[PatternTest(input: 'npm install @babel/core', output: '@babel/core')]
final readonly class TerminalScopedPackagePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>@[\w-]+\/[\w.-]+)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}