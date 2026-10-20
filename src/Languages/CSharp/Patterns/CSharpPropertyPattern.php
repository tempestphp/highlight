<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'user.Name', output: 'Name')]
#[PatternTest(input: 'Name { get; }', output: 'Name')]
final readonly class CSharpPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?:(?:\?\.|\.)\K|(?<![\w@])(?=@?[A-Za-z_]\w*\h*(?:\{|=>)))(?<match>@?[A-Za-z_]\w*)(?!\h*\()/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
