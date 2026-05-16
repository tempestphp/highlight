<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class SvelteDirectiveArgumentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\s(?:bind|use|transition|in|out|animate|on|class|style):(?<match>[\w-]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
