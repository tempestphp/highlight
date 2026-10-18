<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Cpp;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeCommentPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeFunctionPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeIncludePattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikeOperatorPattern;
use Tempest\Highlight\Languages\CLike\Patterns\CLikePreprocessorKeywordPattern;
use Tempest\Highlight\Languages\Cpp\Patterns\CppKeywordPattern;
use Tempest\Highlight\Languages\Cpp\Patterns\CppLiteralPattern;
use Tempest\Highlight\Languages\Cpp\Patterns\CppNumberPattern;
use Tempest\Highlight\Languages\Cpp\Patterns\CppStringPattern;
use Tempest\Highlight\Languages\Cpp\Patterns\CppTypePattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class CppLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'cpp';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['c++'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CLikeCommentPattern(),
            new CLikePreprocessorKeywordPattern(),
            new CLikeIncludePattern(),
            new CppStringPattern(),
            new CppNumberPattern(),
            new CppKeywordPattern(),
            new CppTypePattern(),
            new CppLiteralPattern(),
            new CLikeFunctionPattern(),
            new CLikeOperatorPattern(),
        ];
    }
}
