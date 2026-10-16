<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Sema\Patterns\SemaCharacterPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaCommentPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaDefinedNamePattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaKeywordPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaLambdaArgumentPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaLiteralPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaNamespacedCallPattern;
use Tempest\Highlight\Languages\Sema\Patterns\SemaNumberPattern;
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
            new SemaSpecialFormPattern(),
            new SemaKeywordPattern(),
            new SemaLiteralPattern(),
            new SemaNumberPattern(),
            new SemaNamespacedCallPattern(),
            new SemaLambdaArgumentPattern(),
        ];
    }
}
