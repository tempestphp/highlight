<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript;

use Tempest\Highlight\Languages\DocComment\DocCommentLanguage;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsDocParamNamePattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsDocTypePattern;

class JsDocLanguage extends DocCommentLanguage
{
    public function getName(): string
    {
        return 'jsdoc';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new JsDocTypePattern(),
            new JsDocParamNamePattern(),
        ];
    }
}
