<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<Button {...props} />', output: '{...props}')]
#[PatternTest(input: '<Button {...defaults.button} />', output: '{...defaults.button}')]
final readonly class JsxSpreadAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\{\s*\.\.\.[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*)*\s*\})';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
