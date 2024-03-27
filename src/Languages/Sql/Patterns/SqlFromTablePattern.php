<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FROM country', output: 'country')]
#[PatternTest(input: 'from country', output: 'country')]
final readonly class SqlFromTablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\bFROM (?<match>[\w]+)/i';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
