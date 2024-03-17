<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Base\Injections\AdditionInjection;
use Tempest\Highlight\Languages\Base\Injections\BlurInjection;
use Tempest\Highlight\Languages\Base\Injections\CustomClassInjection;
use Tempest\Highlight\Languages\Base\Injections\DeletionInjection;
use Tempest\Highlight\Languages\Base\Injections\EmphasizeInjection;
use Tempest\Highlight\Languages\Base\Injections\StrongInjection;

class BaseLanguage implements Language
{
    public function getInjections(): array
    {
        return [
            new BlurInjection(),
            new EmphasizeInjection(),
            new StrongInjection(),
            new AdditionInjection(),
            new DeletionInjection(),
            new CustomClassInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [];
    }
}
