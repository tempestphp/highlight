<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Attribute;

/**
 * Marks a pattern or injection that can only have an effect when the content
 * contains at least one of the given substrings, so the highlighter may skip it.
 * Without substrings it imposes no requirement.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class RequiresSubstring
{
    /** @var string[] */
    public array $substrings;

    public function __construct(string ...$substrings)
    {
        $this->substrings = $substrings;
    }
}
