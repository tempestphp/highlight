<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Before
{
    public function __construct()
    {
    }
}
