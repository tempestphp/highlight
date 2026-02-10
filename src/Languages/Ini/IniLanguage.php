<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ini;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Ini\Patterns\IniCommentPattern;
use Tempest\Highlight\Languages\Ini\Patterns\IniKeyPattern;
use Tempest\Highlight\Languages\Ini\Patterns\IniTagPattern;

final class IniLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'ini';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new IniKeyPattern(),
            new IniTagPattern(),
            new IniCommentPattern(),
        ];
    }
}
