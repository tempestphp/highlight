<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Global;

use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Global\Injections\BlurInjection;
use Tempest\Highlight\Languages\Global\Injections\EmphasizeInjection;
use Tempest\Highlight\Languages\Global\Injections\StrongInjection;

class BaseLanguage implements Language
{
    public function getInjections(): array
    {
        return [
            new BlurInjection(),
            new EmphasizeInjection(),
            new StrongInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [];
    }
}
