<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\TypeForVariablePattern;

final class PhpTypeLanguage extends BaseLanguage
{
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new TypeForVariablePattern(),
        ];
    }
}
