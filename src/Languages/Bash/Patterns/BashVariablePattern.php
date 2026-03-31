<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'echo $HOME', output: '$HOME')]
#[PatternTest(input: 'echo ${PATH}', output: '${PATH}')]
final readonly class BashVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\$\{[^}]+\}|\$[a-zA-Z_]\w*|\$[\d@?#!\$\-\*])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
