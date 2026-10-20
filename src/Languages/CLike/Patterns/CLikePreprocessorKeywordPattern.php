<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CLike\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CLikePreprocessorKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\t ]*#\s*(?<match>include_next|include|define|undef|ifdef|ifndef|if|elif|else|endif|line|error|warning|pragma)\b/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
