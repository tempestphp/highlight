<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface Language
{
    public function getName(): string;

    public function getAliases(): array;

    /**
     * @return Injection[]
     */
    public function getInjections(): array;

    /**
     * @return Pattern[]
     */
    public function getPatterns(): array;
}
