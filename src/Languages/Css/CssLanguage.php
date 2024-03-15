<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css;

use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Css\Patterns\CssAttributePattern;
use Tempest\Highlight\Languages\Css\Patterns\CssCommentPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssFunctionPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssSelectorPattern;

class CssLanguage implements Language
{
    public function getInjections(): array
    {
        return [];
    }

    public function getPatterns(): array
    {
        return [
            new CssCommentPattern(),
            new CssSelectorPattern(),
            new CssAttributePattern(),
            new CssFunctionPattern(),
        ];
    }
}
