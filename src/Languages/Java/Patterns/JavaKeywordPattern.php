<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class JavaKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>abstract|assert|break|case|catch|class|const|continue|default|do|else|enum|exports|extends|final|finally|for|goto|if|implements|import|instanceof|interface|module|native|new|non-sealed|open|opens|package|permits|private|protected|provides|public|record|requires|return|sealed|static|strictfp|super|switch|synchronized|this|throw|throws|to|transient|transitive|try|uses|volatile|when|while|with|yield)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
