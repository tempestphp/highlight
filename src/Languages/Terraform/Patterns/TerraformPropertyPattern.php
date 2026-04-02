<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '  ami = "abc-123"', output: 'ami')]
#[PatternTest(input: '  instance_type = "t2.micro"', output: 'instance_type')]
final readonly class TerraformPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^\s*(?<match>[a-zA-Z_][a-zA-Z0-9_]*)\s*=/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
