<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@deprecated', output: '@deprecated')]
final class GraphqlDirectivePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>@\w+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
