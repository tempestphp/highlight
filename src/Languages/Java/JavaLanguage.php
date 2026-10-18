<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java;

use Tempest\Highlight\Languages\Base\BaseLanguage;

final class JavaLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'java';
    }
}
