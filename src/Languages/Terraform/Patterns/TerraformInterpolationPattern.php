<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"Hello ${var.name}"', output: '${var.name}')]
final readonly class TerraformInterpolationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\$\{[^}]+\})';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}
