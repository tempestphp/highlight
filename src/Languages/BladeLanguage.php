<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages;

class BladeLanguage extends HtmlLanguage
{
    public function getPatterns(): array
    {
        return parent::getPatterns() + [

            ];
    }
}
