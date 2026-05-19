<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'createList<Todo[]>(initial)', output: 'createList')]
#[PatternTest(input: "getRole<'user' | 'admin'>(initial)", output: 'getRole')]
#[PatternTest(input: 'getRole<"user" | "admin">(initial)', output: 'getRole')]
final readonly class TsMethodPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\$]+)<[A-Z\'"][\w\s,\.\[\]\'"|]*>\(';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
