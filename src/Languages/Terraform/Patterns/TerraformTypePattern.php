<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'type = string', output: 'string')]
#[PatternTest(input: 'type = list(string)', output: 'list')]
final readonly class TerraformTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $types = implode('|', [
            'string', 'number', 'bool', 'list', 'map',
            'set', 'object', 'tuple', 'any', 'optional',
        ]);

        return "\b(?<match>(?:{$types}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
