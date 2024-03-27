<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'private $foo', output: '$foo')]
#[PatternTest(input: 'protected $foo', output: '$foo')]
#[PatternTest(input: 'public $foo', output: '$foo')]
final readonly class UntypedClassPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(public|private|protected)\s(?<match>\\$[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
