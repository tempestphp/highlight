<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpPreprocessorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?m)^\h*(?<match>#\h*(?:define|undef|if|elif|else|endif|line|error|warning|region|endregion|pragma|nullable|r|load)\b)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
