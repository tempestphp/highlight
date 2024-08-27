<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public Bar $bar', output: 'Bar')]
#[PatternTest(input: 'protected Bar $bar', output: 'Bar')]
#[PatternTest(input: 'private Bar $bar', output: 'Bar')]
#[PatternTest(input: 'public Foo|Bar $bar', output: 'Foo|Bar')]
#[PatternTest(input: 'public Foo|Bar&Baz $bar', output: 'Foo|Bar&Baz')]
#[PatternTest(input: 'public (Bar&Baz)|null $bar', output: '(Bar&Baz)|null')]
#[PatternTest(input: 'public ?Bar $bar', output: '?Bar')]
#[PatternTest(input: 'public ?Bar|\Foo $bar', output: '?Bar|\Foo')]
#[PatternTest(input: 'public function bar(mixed $input);', output: null)]
#[PatternTest(input: 'private static ?Highlighter $web = null;', output: '?Highlighter')]
final readonly class PropertyTypesPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(public|private|protected)(\s*static\s*)?(\s(?<match>[^\s]*)) (\$[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
