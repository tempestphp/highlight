<?php

declare(strict_types=1);

namespace Tempest\Highlight;

/*
 * A `ParsedInjection` is the result of an injection parsing content.
 * It contains the new content, as well as a list of tokens to be parsed
 *
 * The list of tokens returned from a ParsedInjection will be added
 * to all other tokens detected by patterns, and thus follow all token rules.
 * They are grouped and checked on whether tokens can be contained by other tokens.
 * This offers more flexibility from the injection's point of view, and in same cases lead to more accurate highlighting.
 */
final readonly class ParsedInjection
{
    public function __construct(
        public string $content,
        /** @var \Tempest\Highlight\Tokens\Token[] */
        public array $tokens = [],
    ) {
    }
}
