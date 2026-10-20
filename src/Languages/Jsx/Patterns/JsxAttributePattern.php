<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<Button title="Save">', output: 'title')]
#[PatternTest(input: '<Button disabled>', output: 'disabled')]
#[PatternTest(input: 'const title = "Save";', output: null)]
final readonly class JsxAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<=\s)(?<match>[A-Za-z_][\w:.-]*)(?=\s*(?:=\s*["\'{]|\/?>))(?=[^<>]*+\/?>)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
