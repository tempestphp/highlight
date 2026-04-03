<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'enabled = true', output: 'true')]
#[PatternTest(input: 'value = null', output: 'null')]
final readonly class TerraformBooleanPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>true|false|null)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
