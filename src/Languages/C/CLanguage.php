<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\C;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\C\Patterns\CKeywordPattern;
use Tempest\Highlight\Languages\C\Patterns\CLiteralPattern;
use Tempest\Highlight\Languages\C\Patterns\CNumberPattern;
use Tempest\Highlight\Languages\C\Patterns\CStringPattern;
use Tempest\Highlight\Languages\C\Patterns\CTypePattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeFunctionPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeIncludePattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeOperatorPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikePreprocessorKeywordPattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class CLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'c';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CLikeCommentPattern(),
            new CLikePreprocessorKeywordPattern(),
            new CLikeIncludePattern(),
            new CStringPattern(),
            new CNumberPattern(),
            new CKeywordPattern(),
            new CTypePattern(),
            new CLiteralPattern(),
            new CLikeFunctionPattern(),
            new CLikeOperatorPattern(),
        ];
    }
}
