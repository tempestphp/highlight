<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftAttributePattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftFunctionPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftKeywordPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftLiteralPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftMultilineCommentPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftMultilineStringPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftNumberPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftSinglelineCommentPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftStringPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftTypeAnnotationPattern;
use Tempest\Highlight\Languages\Swift\Patterns\SwiftTypeDeclarationPattern;

class SwiftLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'swift';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // KEYWORDS
            new SwiftKeywordPattern(),

            // ATTRIBUTES
            new SwiftAttributePattern(),

            // TYPES
            new SwiftTypeDeclarationPattern(),
            new SwiftTypeAnnotationPattern(),

            // PROPERTIES
            new SwiftFunctionPattern(),

            // COMMENTS
            new SwiftMultilineCommentPattern(),
            new SwiftSinglelineCommentPattern(),

            // NUMBERS
            new SwiftNumberPattern(),

            // LITERALS
            new SwiftLiteralPattern(),

            // VALUES
            new SwiftMultilineStringPattern(),
            new SwiftStringPattern(),
        ];
    }
}
