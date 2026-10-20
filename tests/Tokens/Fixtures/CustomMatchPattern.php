<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens\Fixtures;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class CustomMatchPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>foo)';
    }

    public function match(string $content): array
    {
        return ['match' => [['b', 4]]];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
