<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'INNER JOIN country', output: 'country')]
#[PatternTest(input: 'inner join country', output: 'country')]
final readonly class SqlJoinTablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\bJOIN (?<match>[\w]+)/i';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
