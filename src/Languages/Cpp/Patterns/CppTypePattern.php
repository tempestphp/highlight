<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Cpp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CppTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(?<=\bclass\s)[A-Za-z_]\w*|(?<=\bstruct\s)[A-Za-z_]\w*|(?<=\bunion\s)[A-Za-z_]\w*|(?<=\benum\s)[A-Za-z_]\w*|(?<=\bnamespace\s)[A-Za-z_]\w*|(?<=\btypename\s)[A-Za-z_]\w*|\b[A-Za-z_]\w*\b(?=\s*::)|\b[A-Za-z_]\w*\b(?=\s*(?:[*&]+\s*)+[A-Za-z_]\w*\b|\s+[A-Za-z_]\w*\s*(?:\(|\[|\{|=|,|;|$))|\b(?:bool|char|char8_t|char16_t|char32_t|double|float|int|long|short|signed|unsigned|void|wchar_t)\b)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
