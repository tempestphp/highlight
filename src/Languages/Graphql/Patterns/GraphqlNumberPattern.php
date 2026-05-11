<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'isActive: 12.345', output: '12.345')]
final class GraphqlNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\b\d+(\.\d+)?)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
