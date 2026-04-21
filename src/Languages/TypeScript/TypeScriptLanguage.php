<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\TypeScript;

use Override;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;
use Tempest\Highlight\Languages\JavaScript\Patterns\CombinedJsKeywordPattern;
use Tempest\Highlight\Languages\TypeScript\Patterns\TsBuiltInTypePattern;
use Tempest\Highlight\Languages\TypeScript\Patterns\TsDecoratorPattern;
use Tempest\Highlight\Languages\TypeScript\Patterns\TsGenericPattern;
use Tempest\Highlight\Languages\TypeScript\Patterns\TsTypeAnnotationPattern;

class TypeScriptLanguage extends JavaScriptLanguage
{
    private const array TS_KEYWORDS = [
        'type', 'declare', 'readonly', 'namespace', 'keyof', 'infer',
        'satisfies', 'abstract', 'is', 'module', 'override', 'asserts',
    ];

    #[Override]
    public function getName(): string
    {
        return 'ts';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['typescript'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CombinedJsKeywordPattern(self::TS_KEYWORDS),
            new TsBuiltInTypePattern(),
            new TsTypeAnnotationPattern(),
            new TsDecoratorPattern(),
            new TsGenericPattern(),
        ];
    }
}
