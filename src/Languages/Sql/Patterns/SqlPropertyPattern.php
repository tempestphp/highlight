<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'SELECT foo, bar, c.baz', output:['foo', 'bar'])]
final readonly class SqlPropertyPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '(SELECT|,)\s(?<match>(\w)+)';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
