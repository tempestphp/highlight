<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens\Fixtures;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tokens\TokenTypeEnum;

/** Deliberately declares a substring its regex does not need, so skipping it is visible in the output. */
#[RequiresSubstring('bar')]
class RequiresBarPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>foo)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
