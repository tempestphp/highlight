<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Tokens\TokenTypeEnum;

interface Pattern
{
    public function match(string $content): array;

    public function getTokenType(): TokenTypeEnum;
}
