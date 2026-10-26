<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[Obsolete]', output: 'Obsolete')]
#[PatternTest(input: '[assembly: Guid("x")]', output: 'Guid')]
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
