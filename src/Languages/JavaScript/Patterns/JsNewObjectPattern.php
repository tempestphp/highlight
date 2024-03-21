<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'new Rectangle(', output: 'Rectangle')]
#[PatternTest(input: 'new qq.AjaxRequester(', output: 'AjaxRequester')]
final class JsNewObjectPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'new (\w+\.)*(?<match>[\w]+)(\s)*\(';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
