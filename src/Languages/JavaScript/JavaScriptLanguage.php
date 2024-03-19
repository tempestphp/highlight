<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsMultilineCommentPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsObjectPropertyPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsPropertyPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsSinglelineCommentPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsSingleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;

class JavaScriptLanguage extends BaseLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new KeywordPattern('set'),
            new KeywordPattern('of'),
            new KeywordPattern('get'),
            new KeywordPattern('from'),
            new KeywordPattern('eval'),
            new KeywordPattern('async'),
            new KeywordPattern('as'),
            new KeywordPattern('break'),
            new KeywordPattern('case'),
            new KeywordPattern('catch'),
            new KeywordPattern('class'),
            new KeywordPattern('const'),
            new KeywordPattern('continue'),
            new KeywordPattern('debugger'),
            new KeywordPattern('default'),
            new KeywordPattern('delete'),
            new KeywordPattern('do'),
            new KeywordPattern('else'),
            new KeywordPattern('export'),
            new KeywordPattern('extends'),
            new KeywordPattern('false'),
            new KeywordPattern('finally'),
            new KeywordPattern('for'),
            new KeywordPattern('function'),
            new KeywordPattern('if'),
            new KeywordPattern('import'),
            new KeywordPattern('in'),
            new KeywordPattern('instanceof'),
            new KeywordPattern('new'),
            new KeywordPattern('null'),
            new KeywordPattern('return'),
            new KeywordPattern('super'),
            new KeywordPattern('switch'),
            new KeywordPattern('this'),
            new KeywordPattern('throw'),
            new KeywordPattern('true'),
            new KeywordPattern('try'),
            new KeywordPattern('typeof'),
            new KeywordPattern('var'),
            new KeywordPattern('void'),
            new KeywordPattern('while'),
            new KeywordPattern('with'),
            new KeywordPattern('let'),
            new KeywordPattern('static'),
            new KeywordPattern('yield'),
            new KeywordPattern('await'),
            new KeywordPattern('enum'),
            new KeywordPattern('implements'),
            new KeywordPattern('interface'),
            new KeywordPattern('package'),
            new KeywordPattern('private'),
            new KeywordPattern('protected'),
            new KeywordPattern('public'),

            // COMMENTS
            new JsMultilineCommentPattern(),
            new JsSinglelineCommentPattern(),

            // PROPERTIES
            new JsPropertyPattern(),
            new JsObjectPropertyPattern(),

            // VALUES
            new JsSingleQuoteValuePattern(),
            new JsDoubleQuoteValuePattern(),
        ];
    }
}
