<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PyTripleSingleQuoteStringPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '/(?<match>\'\'\'(.|\n)*?\'\'\')/m';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
