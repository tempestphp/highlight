<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface WithPre
{
    public function preBefore(): string;

    public function preAfter(): string;
}
