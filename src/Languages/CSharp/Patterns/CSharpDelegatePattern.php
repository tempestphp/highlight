<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpDelegatePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\bdelegate\h+(?:[A-Za-z_]\w*(?:\h*<[^<>]*>)?(?:\h*\[\h*])?\??)\h+(?<match>@?[A-Za-z_]\w*)(?=\h*(?:<[^<>]*>\h*)?\()';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
