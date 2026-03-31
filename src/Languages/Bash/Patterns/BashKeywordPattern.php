<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class BashKeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private array $keywords = [
        'if', 'then', 'else', 'elif', 'fi', 'for', 'while', 'do', 'done',
        'case', 'esac', 'function', 'return', 'in', 'select', 'until',
        'break', 'continue', 'declare', 'local', 'export', 'readonly',
        'unset', 'shift', 'trap', 'source',
    ])
    {
    }

    public function getPattern(): string
    {
        $keywords = implode('|', $this->keywords);

        return "\b(?<match>(?:{$keywords}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}