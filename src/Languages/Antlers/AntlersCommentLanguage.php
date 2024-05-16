<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers;

use Tempest\Highlight\Languages\Antlers\Patterns\AntlersCommentPattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;

class AntlersCommentLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'antlerscomment';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            new AntlersCommentPattern(),
        ];
    }
}
