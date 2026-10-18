<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpAttributePattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpCallablePattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpDeclarationPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpDelegatePattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpKeywordPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpLiteralPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpNamespacePattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpNumberPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpOperatorPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpPreprocessorPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpPropertyPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpStringPattern;
use Tempest\Highlight\Languages\CSharp\Patterns\CSharpTypePattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class CSharpLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'csharp';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['cs', 'c#'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CLikeCommentPattern(),
            new CSharpStringPattern(),
            new CSharpPreprocessorPattern(),
            new CSharpAttributePattern(),
            new CSharpNamespacePattern(),
            new CSharpNumberPattern(),
            new CSharpLiteralPattern(),
            new CSharpKeywordPattern(),
            new CSharpDeclarationPattern(),
            new CSharpDelegatePattern(),
            new CSharpCallablePattern(),
            new CSharpPropertyPattern(),
            new CSharpTypePattern(),
            new CSharpOperatorPattern(),
        ];
    }
}
