<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Override;
use Tempest\Highlight\Languages\DocComment\DocCommentLanguage;
use Tempest\Highlight\Languages\Php\Injections\PhpGenericTypeInjection;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentGenericTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentParamTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentReturnTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentReturnTypeSingleLinePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentTemplateTypePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentVariablePattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpDocCommentVarTypePattern;

class PhpDocCommentLanguage extends DocCommentLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'phpdoc';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpGenericTypeInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new PhpDocCommentParamTypePattern(),
            new PhpDocCommentVarTypePattern(),
            new PhpDocCommentReturnTypeSingleLinePattern(),
            new PhpDocCommentReturnTypePattern(),
            new PhpDocCommentTemplateTypePattern(),
            new PhpDocCommentGenericTypePattern(),
            new PhpDocCommentVariablePattern(),
        ];
    }
}
