<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'namespace Example.App;', output: 'Example.App')]
#[PatternTest(input: 'using System.Text;', output: 'System.Text')]
final readonly class CSharpNamespacePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:namespace|using)\h+(?:static\h+|global\h+)?(?:[A-Za-z_]\w*\h*=\h*)?(?<match>(?:global::)?[A-Za-z_]\w*(?:\.[A-Za-z_]\w*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
