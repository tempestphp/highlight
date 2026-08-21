<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff;

use Tempest\Highlight\Tokens\TokenType;

enum DiffTokenType: string implements TokenType
{
    case METADATA = 'diff-metadata';
    case FILE_HEADER = 'diff-file-header';
    case HUNK_HEADER = 'diff-hunk-header';
    case ADDITION = 'diff-addition';
    case DELETION = 'diff-deletion';
    case CONTEXT = 'diff-context';
    case SPECIAL = 'diff-special';

    public function getValue(): string
    {
        return $this->value;
    }

    public function canContain(TokenType $other): bool
    {
        return $this !== $other;
    }
}
