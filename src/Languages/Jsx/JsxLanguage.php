<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx;

use Override;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;

class JsxLanguage extends JavaScriptLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'jsx';
    }

    #[Override]
    public function getAliases(): array
    {
        return [];
    }
}
