<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@param', output: '@param')]
final readonly class DocCommentTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\@[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
