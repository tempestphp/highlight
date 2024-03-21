<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'class Foo {}', output: 'Foo')]
#[PatternTest(input: 'interface Foo {}', output: 'Foo')]
#[PatternTest(input: 'trait Foo {}', output: 'Foo')]
#[PatternTest(input: 'enum Foo {}', output: 'Foo')]
final class ClassNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(class|interface|trait|enum) (?<match>[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
