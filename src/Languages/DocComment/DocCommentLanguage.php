<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\DocComment\Injections\GenericTypeInjection;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentGenericTypePattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentParamTypePattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentReturnTypePattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentTagPattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentTemplateTypePattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentVariablePattern;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentVarTypePattern;

class DocCommentLanguage extends BaseLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new GenericTypeInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new DocCommentTagPattern(),
            new DocCommentParamTypePattern(),
            new DocCommentVarTypePattern(),
            new DocCommentReturnTypePattern(),
            new DocCommentTemplateTypePattern(),
            new DocCommentGenericTypePattern(),
            new DocCommentVariablePattern(),
        ];
    }
}
