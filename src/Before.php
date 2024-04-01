<?php

namespace Tempest\Highlight;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Before
{
    public function __construct() {}
}