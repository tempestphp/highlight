<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FROM country AS alias', output: 'alias')]
#[PatternTest(input: 'from country as alias', output: 'alias')]
final readonly class SqlAsTablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\bAS (?<match>[\w]+)/i';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
