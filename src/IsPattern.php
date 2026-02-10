<?php

declare(strict_types=1);

namespace Tempest\Highlight;

trait IsPattern
{
    abstract public function getPattern(): string;

    public function match(string $content): array
    {
        $pattern = $this->getPattern();

        if (($pattern[0] ?? '') !== '/') {
            $pattern = "/{$pattern}/";
        }

        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        return $matches;
    }
}
