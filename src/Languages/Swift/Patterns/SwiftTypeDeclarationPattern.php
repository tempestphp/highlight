<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'struct ContentView: View', output: 'ContentView')]
#[PatternTest(input: 'extension Array where', output: 'Array')]
final readonly class SwiftTypeDeclarationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:class|struct|enum|protocol|extension|actor|typealias)\s+(?<match>[A-Z]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
