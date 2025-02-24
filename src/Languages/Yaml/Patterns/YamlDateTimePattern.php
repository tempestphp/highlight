<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'date: 2024-05-31', output: '2024-05-31')]
#[PatternTest(input: 'time: 12:34:56', output: '12:34:56')]
#[PatternTest(input: 'date_time: 2024-05-31 12:34:56', output: '2024-05-31 12:34:56')]
final readonly class YamlDateTimePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\d{4}-\d\d?-\d\d?(?:[tT]|[ \t]+)\d\d?:\d{2}:\d{2}(?:\.\d*)?(?:[ \t]*(?:Z|[-+]\d\d?(?::\d{2})?))?|\d{4}-\d{2}-\d{2}|\d\d?:\d{2}(?::\d{2}(?:\.\d*)?)?)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
