<?php

namespace Tempest\Highlight;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class After
{
    public function __construct() {}
}