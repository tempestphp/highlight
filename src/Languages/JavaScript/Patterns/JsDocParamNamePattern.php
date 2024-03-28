<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('@param {string} foo ', 'foo')]
#[PatternTest('@param {Object[]} foo', 'foo')]
#[PatternTest('@param {string} employees[].name', 'employees[].name')]
#[PatternTest('@param {string} employees[].name The name', 'employees[].name')]
final readonly class JsDocParamNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '@param\s(.*?)\s(?<match>(.*?))(\s|$)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
