<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('use function Tempest\\Foo\\redirect;', 'Tempest\\Foo\\')]
final readonly class UseFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'use function (?<match>[\w\\\\]+\\\\)[\w]+\;';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
