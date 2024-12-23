<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Text;

use Tempest\Highlight\Languages\Base\BaseLanguage;

class TextLanguage extends BaseLanguage
{
    #[\Override]
    public function getName(): string
    {
        return 'txt';
    }

    #[\Override]
    public function getAliases(): array
    {
        return [
            'text',
        ];
    }
}
