<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;

final class CSharpLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'csharp';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['cs', 'c#'];
    }
}
