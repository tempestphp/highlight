<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages;

use Tempest\Highlight\Language;
use Tempest\Highlight\Patterns\Css\CssAttributePattern;
use Tempest\Highlight\Patterns\Css\CssCommentPattern;
use Tempest\Highlight\Patterns\Css\CssFunctionPattern;
use Tempest\Highlight\Patterns\Css\CssSelectorPattern;

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
