<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'let answer = 42 /* the
answer */',
    output: '/* the
answer */',
)]
#[PatternTest(
    input: '/* outer /* inner */ return nil */ let a = 1',
    output: '/* outer /* inner */ return nil */',
)]
final readonly class SwiftMultilineCommentPattern implements Pattern
{
    use IsPattern;

    /**
     * Swift block comments nest, so a comment only ends once every comment opened inside it has closed.
     */
    public function getPattern(): string
    {
        return '/(?<match>(?<comment>\/\*(?:[^\/*]|\/(?!\*)|\*(?!\/)|(?&comment))*\*\/))/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
