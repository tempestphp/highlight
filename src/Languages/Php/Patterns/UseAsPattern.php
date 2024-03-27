<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('use Illuminate\Contracts\Container\Container as ContainerContract', 'ContainerContract')]
final readonly class UseAsPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'use [\w\\\\]+ as (?<match>[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
