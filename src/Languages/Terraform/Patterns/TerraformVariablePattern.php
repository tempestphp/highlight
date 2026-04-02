<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'ami = var.ami_id', output: 'var.ami_id')]
#[PatternTest(input: 'name = local.name', output: 'local.name')]
#[PatternTest(input: 'id = module.vpc.id', output: 'module.vpc.id')]
final readonly class TerraformVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $prefixes = 'var|local|module|data|each|self';

        return "(?<match>(?:{$prefixes})(?:\\.[a-zA-Z_][a-zA-Z0-9_]*)+)";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
