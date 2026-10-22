<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinAnnotationPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinCallablePattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinKeywordPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinLiteralPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinNamespacePattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinNumberPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinOperatorPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinPropertyPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinStringPattern;
use Tempest\Highlight\Languages\Kotlin\Patterns\KotlinTypePattern;

final class KotlinLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'kotlin';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['kt', 'kts'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CLikeCommentPattern(),
            new KotlinAnnotationPattern(),
            new KotlinNamespacePattern(),
            new KotlinStringPattern(),
            new KotlinNumberPattern(),
            new KotlinLiteralPattern(),
            new KotlinKeywordPattern(),
            new KotlinTypePattern(),
            new KotlinCallablePattern(),
            new KotlinPropertyPattern(),
            new KotlinOperatorPattern(),
        ];
    }
}
