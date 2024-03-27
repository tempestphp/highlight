<?php

declare(strict_types=1);

namespace Tempest\Highlight;

final readonly class ParsedInjection
{
    public function __construct(
        public string $content,
        public array $tokens = [],
    ) {
    }
}
