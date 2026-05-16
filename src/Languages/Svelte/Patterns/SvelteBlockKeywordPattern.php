<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class SvelteBlockKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\{(?<match>[#@:\/]\w+)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
