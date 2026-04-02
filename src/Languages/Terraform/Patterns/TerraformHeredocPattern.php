<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '<<EOT
hello world
EOT',
    output: '<<EOT
hello world
EOT',
)]
#[PatternTest(
    input: '<<-POLICY
  some content
  POLICY',
    output: '<<-POLICY
  some content
  POLICY',
)]
final readonly class TerraformHeredocPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match><<-?\s*([A-Z_][A-Z0-9_]*)\n.*?\n\s*\2)/s';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}