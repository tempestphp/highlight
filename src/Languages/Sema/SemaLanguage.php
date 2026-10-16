<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Sema\Patterns\SemaCallPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaCharacterPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaCommentPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaDefinedNamePattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaDefinedVariablePattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaKeywordPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaLambdaArgumentPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaLiteralPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaNumberPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaOperatorPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaParameterPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaSpecialFormPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaStringPattern;

class SemaLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'sema';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            new SemaCommentPattern(),
            new SemaStringPattern(),
            new SemaCharacterPattern(),
            new SemaDefinedNamePattern(),
            new SemaDefinedVariablePattern(),
            new SemaParameterPattern(),
            new SemaSpecialFormPattern(),
            new SemaOperatorPattern(),
            new SemaKeywordPattern(),
            new SemaLiteralPattern(),
            new SemaNumberPattern(),
            new SemaCallPattern(),
            new SemaLambdaArgumentPattern(),
        ];
    }
}
