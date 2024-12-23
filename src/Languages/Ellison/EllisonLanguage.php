<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ellison;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Ellison\Injections\ParserInjection;

class EllisonLanguage extends BaseLanguage
{
    #[\Override]
    public function getName(): string
    {
        return 'ellison';
    }

    #[\Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new ParserInjection(),
        ];
    }
}
