<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\[\h*(?:(?:assembly|module|field|event|method|param|property|return|type):\h*)?(?<match>[A-Za-z_]\w*(?:\.[A-Za-z_]\w*)*(?:Attribute)?)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
