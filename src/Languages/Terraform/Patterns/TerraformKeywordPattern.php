<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'for_each = var.instances', output: 'for_each')]
#[PatternTest(input: 'count = 3', output: 'count')]
final readonly class TerraformKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $keywords = implode('|', [
            'for', 'in', 'if', 'else', 'for_each', 'count',
            'depends_on', 'lifecycle', 'dynamic', 'content', 'each', 'self',
        ]);

        return "\b(?<match>(?:{$keywords}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
