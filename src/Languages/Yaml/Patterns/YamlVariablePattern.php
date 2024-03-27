<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'runs-on: ${{ matrix.os }}', output: ' matrix.os ')]
final readonly class YamlVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\\$\{\{(?<match>[\w\s\.]+)\}\}';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
