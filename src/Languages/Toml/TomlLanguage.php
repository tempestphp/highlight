<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml;

use Tempest\Highlight\Languages\Base\BaseLanguage;

final class TomlLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'toml';
    }
}
