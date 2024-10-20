<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '</a>', output: 'a')]
#[PatternTest(input: '</x-hello>', output: 'x-hello')]
#[PatternTest(input: '</x-hello::world>', output: 'x-hello::world')]
#[PatternTest(input: '</x-hello::world.lorem>', output: 'x-hello::world.lorem')]
final readonly class BladeComponentCloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<\/(?<match>[\w\-\:\.]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
