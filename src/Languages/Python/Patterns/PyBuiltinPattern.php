<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PyBuiltinPattern implements Pattern
{
    use IsPattern;

    public function __construct(private array $builtinFunctions = [
        '__import__', 'abs', 'aiter', 'all', 'any', 'anext', 'ascii', 'bin', 'bool',
        'breakpoint', 'bytearray', 'bytes', 'callable', 'chr', 'classmethod', 'compile',
        'complex', 'delattr', 'dict', 'dir', 'divmod', 'enumerate', 'eval', 'exec',
        'filter', 'float', 'format', 'frozenset', 'getattr', 'globals', 'hasattr',
        'hash', 'help', 'hex', 'id', 'input', 'int', 'isinstance', 'issubclass', 'iter',
        'len', 'list', 'locals', 'map', 'max', 'memoryview', 'min', 'next', 'object',
        'oct', 'open', 'ord', 'pow', 'print', 'property', 'range', 'repr', 'reversed',
        'round', 'set', 'setattr', 'slice', 'sorted', 'staticmethod', 'str', 'sum',
        'super', 'tuple', 'type', 'vars', 'zip',
    ])
    {
    }

    public function getPattern(): string
    {
        $builtinFunctions = implode('|', $this->builtinFunctions);

        return "\b(?<match>(?:{$builtinFunctions}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
