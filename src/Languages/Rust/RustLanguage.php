<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Rust\Patterns\RustAttributePattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustCharacterPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustCommentPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustFunctionPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustKeywordPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustLifetimePattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustLiteralPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustMacroPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustNumberPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustOperatorPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustPunctuationPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustStringPattern;
use Tempest\Highlight\Languages\Rust\Patterns\RustTypePattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class RustLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'rust';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['rs'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new RustCommentPattern(),
            new RustAttributePattern(),
            new RustStringPattern(),
            new RustCharacterPattern(),
            new RustLifetimePattern(),
            new RustNumberPattern(),
            new RustLiteralPattern(),
            new RustKeywordPattern(),
            new RustTypePattern(),
            new RustMacroPattern(),
            new RustFunctionPattern(),
            new RustOperatorPattern(),
            new RustPunctuationPattern(),
        ];
    }
}
