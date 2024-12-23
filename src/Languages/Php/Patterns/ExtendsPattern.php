<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'extends Foo', output: 'Foo')]
final readonly class ExtendsPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return 'extends\s(?<match>[\w]+)';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
