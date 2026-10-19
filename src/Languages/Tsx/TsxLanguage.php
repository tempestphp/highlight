<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Tsx;

use Override;
use Tempest\Highlight\Languages\TypeScript\TypeScriptLanguage;

class TsxLanguage extends TypeScriptLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'tsx';
    }

    #[Override]
    public function getAliases(): array
    {
        return [];
    }
}
