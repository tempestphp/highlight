<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Diff\Injections\DiffAdditionInjection;
use Tempest\Highlight\Languages\Diff\Injections\DiffDeletionInjection;

class DiffLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'diff';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new DiffAdditionInjection(),
            new DiffDeletionInjection(),
        ];
    }
}
