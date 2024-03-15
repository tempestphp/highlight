<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Pattern;

final class Token
{
    public int $length;
    public int $start;
    public int $end;
    /** @var \App\Highlight\Token[] */
    public array $children = [];
    public ?Token $parent = null;

    public function __construct(
        public int $offset,
        public string $value,
        public TokenType $type,
        public ?Pattern $pattern = null,
    ) {
        $this->length = strlen($this->value);
        $this->start = $this->offset;
        $this->end = $this->offset + $this->length;
    }

    public function equals(Token $other): bool
    {
        return $this->value === $other->value
            && $this->offset === $other->offset;
        //            && $this->type === $other->type;
    }

    public function contains(Token $other): bool
    {
        return
            ! $this->equals($other)
            && $this->start <= $other->start
            && $this->end >= $other->end;
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

    public function before(): string
    {
        return $this->type->before();
    }

    public function after(): string
    {
        return $this->type->after();
    }
}
