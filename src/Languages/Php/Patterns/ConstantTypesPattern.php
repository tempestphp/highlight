<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'const string BAR_FOO = \'baz\'', output: 'string')]
#[PatternTest(input: 'const BAR = \'baz\'', output: null)]
#[PatternTest(input: 'const (Foo&Bar)|null BAR = \'baz\'', output: '(Foo&Bar)|null')]
final readonly class ConstantTypesPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'const\s(?<match>.+?)\s[\w]+\s=';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
