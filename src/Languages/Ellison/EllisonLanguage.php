<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ellison;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Ellison\Injections\ParserInjection;

class EllisonLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'ellison';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new ParserInjection(),
        ];
    }
}
