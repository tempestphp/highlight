<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'func foo()->Bar:', output: 'Bar')]
#[PatternTest(input: 'func foo() -> Bar :', output: 'Bar')]
final readonly class ReturnTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\)\s*\-\>\s*(?<match>.+?)[\s*:\n]';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
