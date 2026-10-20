<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class JavaFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!\bclass )(?<!\binterface )(?<!\benum )(?<!\brecord )(?<!\bnew )\b(?!(?:catch|do|for|if|switch|synchronized|try|while)\b)(?<match>[A-Za-z_$][\w$]*)(?=\s*\()';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
