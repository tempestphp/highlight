<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Tempest\Highlight\Languages\DocComment\DocCommentLanguage;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentGenericTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentParamTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentReturnTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentTemplateTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentVariablePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentVarTypePattern;

class PhpDocCommentLanguage extends DocCommentLanguage
{
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new PhpDocCommentParamTypePattern(),
            new PhpDocCommentVarTypePattern(),
            new PhpDocCommentReturnTypePattern(),
            new PhpDocCommentTemplateTypePattern(),
            new PhpDocCommentGenericTypePattern(),
            new PhpDocCommentVariablePattern(),
        ];
    }
}
