<?php

namespace Tempest\Highlight\Languages;

use Tempest\Highlight\Languages\Blade\Injections\BladeKeywordInjection;
use Tempest\Highlight\Languages\Blade\Injections\BladePhpInjection;
use Tempest\Highlight\Languages\Blade\Patterns\BladeKeywordPattern;
use Tempest\Highlight\Languages\Html\HtmlLanguage;

class BladeLanguage extends HtmlLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new BladePhpInjection(),
            new BladeKeywordInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BladeKeywordPattern(),
        ];
    }
}