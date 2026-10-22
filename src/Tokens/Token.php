<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Pattern;

final class Token
{
    public int $length;
    public int $start;
    public int $end;
    public readonly string $typeValue;
    /** @var Token[] */
    public array $children = [];
    public ?Token $parent = null;

    public function __construct(
        public int $offset,
        public string $value,
        public TokenType $type,
        public ?Pattern $pattern = null,
        ?int $length = null,
    ) {
        $this->length = $length ?? strlen($this->value);
        $this->start = $this->offset;
        $this->end = $this->offset + $this->length;
        $this->typeValue = $type->getValue();
    }

    public function equals(Token $other): bool
    {
        return $this->value === $other->value
            && $this->offset === $other->offset
            && $this->type === $other->type;
    }

    public function containsOrOverlaps(Token $other): bool
    {
        return
            ! $this->equals($other)
            && $this->start <= $other->start
            && $other->start < $this->end;
    }

    public function addChild(Token $child): void
    {
        $this->children[] = $child;
        $child->parent = $this;
    }

    public function hasChildren(): bool
    {
        return $this->children !== [];
    }

    public function cloneWithoutParent(): self
    {
        $clone = clone $this;

        $clone->parent = null;

        return $clone;
    }

    public function resetHierarchy(): void
    {
        $this->children = [];
        $this->parent = null;
    }

    public function canContain(Token $otherToken): bool
    {
        foreach ($this->children as $childToken) {
            // If there's already a child token at the exact position,
            // we're not going to allow another child to be added,
            // unless one of them is a highlight marker wrapping the other
            if (
                $childToken->start === $otherToken->start
                && $childToken->end === $otherToken->end
                && ! $childToken->type instanceof DynamicTokenType
                && ! $otherToken->type instanceof DynamicTokenType
            ) {
                return false;
            }
        }

        // Highlight markers like {_ _} or {:class: :} may be placed anywhere,
        // including inside strings or comments, so built-in token types can
        // always contain them.
        if (
            (
                $otherToken->type === TokenTypeEnum::HIDDEN
                || $otherToken->type instanceof DynamicTokenType
            )
            && $this->type instanceof TokenTypeEnum
        ) {
            return true;
        }

        return $this->type->canContain($otherToken->type);
    }
}
