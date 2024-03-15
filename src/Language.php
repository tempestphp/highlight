<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface Language
{
    /**
     * @return \App\Injection[]
     */
    public function getInjections(): array;

    /**
     * @return \App\Pattern[]
     */
    public function getPatterns(): array;
}
