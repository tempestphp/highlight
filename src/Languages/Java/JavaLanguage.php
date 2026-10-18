<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeOperatorPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaAnnotationPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaFunctionPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaKeywordPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaLiteralPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaNamespacePattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaNumberPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaStringPattern;
use Tempest\Highlight\Languages\Java\Patterns\JavaTypePattern;

final class JavaLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'java';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CLikeCommentPattern(),
            new JavaAnnotationPattern(),
            new JavaNamespacePattern(),
            new JavaStringPattern(),
            new JavaNumberPattern(),
            new JavaLiteralPattern(),
            new JavaKeywordPattern(),
            new JavaTypePattern(),
            new JavaFunctionPattern(),
            new CLikeOperatorPattern(),
        ];
    }
}
