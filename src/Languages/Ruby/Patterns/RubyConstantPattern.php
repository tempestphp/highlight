<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'class User < ApplicationRecord', output: ['User', 'ApplicationRecord'])]
#[PatternTest(input: 'Admin::User.find(1)', output: ['Admin', 'User'])]
#[PatternTest(input: 'user.name', output: null)]
final readonly class RubyConstantPattern implements Pattern
{
    use IsPattern {
        match as matchContent;
    }

    public function match(string $content): array
    {
        return $this->matchContent(new RubyLexer()->code($content));
    }

    public function getPattern(): string
    {
        return '\b(?<match>[A-Z]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
