<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\IgnoreTokenType;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest('{+ pull_request_target: +}', '{+')]
#[PatternTest('❷span class=❹ignore❹❸{+❷/span❸', null)]
final readonly class AdditionStartTokenPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        // A delimiter that is already ignored comes from code highlighted by a nested highlighter
        return '/(?<!❹ignore❹❸)(?<match>{\+)/';
    }

    public function getTokenType(): TokenType
    {
        return new IgnoreTokenType();
    }
}
