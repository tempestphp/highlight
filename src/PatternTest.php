<?php

namespace Tempest\Highlight;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
final readonly class PatternTest
{
    public function __construct(
        public string $input,
        public string|array $output,
    ) {}
}