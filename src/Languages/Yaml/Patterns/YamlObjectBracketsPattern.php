<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'branches: { link: "/blog/new-in-php-83", title: "Whats new in PHP 8.3" }', output: ['{', '}'])]
final readonly class YamlObjectBracketsPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(\{|\}))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
