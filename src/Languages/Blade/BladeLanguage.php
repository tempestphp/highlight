<?php

namespace Tempest\Highlight\Languages\Blade;

use Tempest\Highlight\Languages\Blade\Patterns\BladeKeywordPattern;
use Tempest\Highlight\Languages\Html\HtmlLanguage;

class BladeLanguage extends HtmlLanguage
{
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BladeKeywordPattern(),
        ];
    }
}