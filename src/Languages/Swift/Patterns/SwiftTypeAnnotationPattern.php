<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'var name: String', output: 'String')]
#[PatternTest(input: 'func count() -> Int', output: 'Int')]
#[PatternTest(input: 'var body: some View', output: 'View')]
#[PatternTest(input: 'let names: [String]', output: 'String')]
final readonly class SwiftTypeAnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?:->|:|\b(?:some|any)\b)\s*\[?(?<match>[A-Z]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
