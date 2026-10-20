<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>abstract|add|alias|and|as|ascending|async|await|base|break|by|case|catch|checked|class|const|continue|default|delegate|descending|do|else|enum|equals|event|explicit|extern|file|finally|fixed|for|foreach|from|get|global|goto|group|if|implicit|in|init|interface|internal|into|is|join|let|lock|managed|nameof|namespace|new|not|notnull|on|operator|or|orderby|out|override|params|partial|private|protected|public|readonly|record|ref|remove|required|return|scoped|sealed|select|set|sizeof|stackalloc|static|struct|switch|this|throw|try|typeof|unchecked|unmanaged|unsafe|using|value|virtual|volatile|when|where|while|with|yield)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
