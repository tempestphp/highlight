<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\IgnoreTokenType;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest('{+ pull_request_target: +}', '{+')]
final readonly class AdditionStartTokenPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>{\+)/';
    }

    public function getTokenType(): TokenType
    {
        return new IgnoreTokenType();
    }
}
