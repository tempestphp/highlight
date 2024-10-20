<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<?php', output: '<?php')]
#[PatternTest(input: '<?=', output: '<?=')]
final readonly class PhpOpenTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\<\?[=|php]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
