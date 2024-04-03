<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface Language
{
    public function getName(): string;

    public function getAliases(): array;

    /**
     * @return \Tempest\Highlight\Injection[]
     */
    public function getInjections(): array;

    /**
     * @return \Tempest\Highlight\Pattern[]
     */
    public function getPatterns(): array;
}
