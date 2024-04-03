<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Css\Patterns\CssAttributePattern;
use Tempest\Highlight\Languages\Css\Patterns\CssCommentPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssFunctionPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssSelectorPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssVariablePattern;

class CssLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'css';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CssCommentPattern(),
            new CssSelectorPattern(),
            new CssAttributePattern(),
            new CssFunctionPattern(),
            new CssVariablePattern(),
        ];
    }
}
