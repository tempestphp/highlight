<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# this is a comment', output: '# this is a comment')]
final readonly class BashCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(^|[^\\\\])(?<match>#.*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
