<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'resource "aws_instance" "web" {', output: 'resource')]
#[PatternTest(input: 'variable "instance_type" {', output: 'variable')]
final readonly class TerraformBlockTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $blockTypes = implode('|', [
            'resource', 'data', 'variable', 'output', 'locals',
            'module', 'provider', 'terraform', 'moved', 'import', 'check',
        ]);

        return "/^(?<match>{$blockTypes})\b/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
