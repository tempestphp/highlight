<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\JavaScript\Injections\JsDocInjection;
use Tempest\Highlight\Languages\JavaScript\Patterns\CombinedJsKeywordPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsClassNamePattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsMethodPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsMultilineCommentPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsNewObjectPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsObjectPropertyPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsPropertyPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsSinglelineCommentPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsSingleQuoteValuePattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsStaticClassPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsStaticPropertyPattern;

class JavaScriptLanguage extends BaseLanguage
{
    private const array KEYWORDS = [
        'set', 'of', 'get', 'from', 'eval', 'async', 'as', 'break',
        'case', 'catch', 'class', 'const', 'continue', 'debugger',
        'default', 'delete', 'do', 'else', 'export', 'extends',
        'false', 'finally', 'for', 'function', 'if', 'import', 'in',
        'instanceof', 'new', 'null', 'return', 'super', 'switch',
        'this', 'throw', 'true', 'try', 'typeof', 'var', 'void',
        'while', 'with', 'let', 'static', 'yield', 'await', 'enum',
        'implements', 'interface', 'package', 'private', 'protected',
        'public', 'constructor',
    ];

    public function getName(): string
    {
        return 'js';
    }

    #[Override]
    public function getAliases(): array
    {
        return [
            'javascript',
            'node',
        ];
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new JsDocInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new CombinedJsKeywordPattern(self::KEYWORDS),

            // COMMENTS
            new JsMultilineCommentPattern(),
            new JsSinglelineCommentPattern(),

            // TYPES
            new JsClassNamePattern(),
            new JsNewObjectPattern(),
            new JsStaticClassPattern(),

            // PROPERTIES
            new JsPropertyPattern(),
            new JsObjectPropertyPattern(),
            new JsMethodPattern(),
            new JsStaticPropertyPattern(),

            // VALUES
            new JsSingleQuoteValuePattern(),
            new JsDoubleQuoteValuePattern(),
        ];
    }
}
