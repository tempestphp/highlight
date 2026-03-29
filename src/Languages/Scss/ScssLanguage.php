<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss;

use Override;
use Tempest\Highlight\Languages\Css\CssLanguage;
use Tempest\Highlight\Languages\Scss\Patterns\ScssCommentPattern;
use Tempest\Highlight\Languages\Scss\Patterns\ScssInterpolationPattern;
use Tempest\Highlight\Languages\Scss\Patterns\ScssKeywordPattern;
use Tempest\Highlight\Languages\Scss\Patterns\ScssSelectorPattern;
use Tempest\Highlight\Languages\Scss\Patterns\ScssVariablePattern;

class ScssLanguage extends CssLanguage
{
    public function getName(): string
    {
        return 'scss';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new ScssSelectorPattern(),
            new ScssCommentPattern(),
            new ScssVariablePattern(),
            new ScssKeywordPattern(),
            new ScssInterpolationPattern(),
        ];
    }
}
