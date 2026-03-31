<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class BashBuiltinPattern implements Pattern
{
    use IsPattern;

    public function __construct(private array $builtins = [
        'echo', 'printf', 'cd', 'pwd', 'test', 'eval', 'exec',
        'set', 'read', 'exit',
    ])
    {
    }

    public function getPattern(): string
    {
        $builtins = implode('|', $this->builtins);

        return "\b(?<match>(?:{$builtins}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
