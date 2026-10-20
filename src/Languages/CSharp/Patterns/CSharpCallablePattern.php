<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpCallablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<![\w@])(?!(?:catch|checked|do|for|foreach|if|lock|sizeof|switch|typeof|unchecked|using|while)\b)(?<match>@?[A-Za-z_]\w*)(?=\h*(?:<[^<>]*>\h*)?\()';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
