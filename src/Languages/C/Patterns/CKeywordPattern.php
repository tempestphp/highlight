<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\C\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>_Alignas|_Alignof|_Atomic|_Generic|_Noreturn|_Static_assert|_Thread_local|alignas|alignof|auto|break|case|const|continue|default|do|else|enum|extern|for|goto|if|inline|register|restrict|return|sizeof|static|static_assert|struct|switch|thread_local|typedef|typeof|typeof_unqual|union|volatile|while)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
