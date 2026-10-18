<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;

final class KotlinLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'kotlin';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['kt', 'kts'];
    }
}
