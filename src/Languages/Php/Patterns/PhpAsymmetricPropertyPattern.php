<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public public(set) Foo $foo', output: 'set')]
#[PatternTest(input: 'public private(set) Foo $foo', output: 'set')]
#[PatternTest(input: 'public protected(set) Foo $foo', output: 'set')]
final readonly class PhpAsymmetricPropertyPattern implements Pattern
{
    use IsPattern;

    public function match(string $content): array
    {
        $pattern = $this->getPattern();

        if (! str_starts_with($pattern, '/')) {
            $pattern = "/$pattern/";
        }

        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        return $matches;
    }

    public function getPattern(): string
    {
        return '/(public|private|protected)\((?<match>set)\)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}
