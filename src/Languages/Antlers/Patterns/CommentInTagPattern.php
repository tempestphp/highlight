<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('# test # content', null)]
#[PatternTest('# test #', '# test #')]
final readonly class CommentInTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return '/^(?<match>#.*?#)$/s';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
