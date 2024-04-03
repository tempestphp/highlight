<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Gdscript\Patterns\AnnotationPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\AsTypePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\ClassNamePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\ExtendsPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\FunctionCallPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\FunctionNamePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\OperatorPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\PropertyAccessPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\ReturnTypePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\SinglelineCommentPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\SingleQuoteValuePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\VarTypePattern;

class GdscriptLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'gdscript';
    }

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

            new OperatorPattern('**='),
            new OperatorPattern('<<='),
            new OperatorPattern('>>='),
            new OperatorPattern('**'),
            new OperatorPattern('||'),
            new OperatorPattern('&&'),
            new OperatorPattern('<='),
            new OperatorPattern('>='),
            new OperatorPattern('=='),
            new OperatorPattern('!='),
            new OperatorPattern('<<'),
            new OperatorPattern('>>'),
            new OperatorPattern('+='),
            new OperatorPattern('-='),
            new OperatorPattern('*='),
            new OperatorPattern('/='),
            new OperatorPattern('%='),
            new OperatorPattern('&='),
            new OperatorPattern('|='),
            new OperatorPattern('^='),
            new OperatorPattern('->'),
            new OperatorPattern('/'),
            new OperatorPattern('%'),
            new OperatorPattern('+'),
            new OperatorPattern('-'),
            new OperatorPattern('*'),
            new OperatorPattern('/'),
            new OperatorPattern('&'),
            new OperatorPattern('^'),
            new OperatorPattern('|'),
            new OperatorPattern('<'),
            new OperatorPattern('>'),
            new OperatorPattern('!'),

            new KeywordPattern('if'),
            new KeywordPattern('elif'),
            new KeywordPattern('else'),
            new KeywordPattern('for'),
            new KeywordPattern('while'),
            new KeywordPattern('match'),
            new KeywordPattern('break'),
            new KeywordPattern('continue'),
            new KeywordPattern('pass'),
            new KeywordPattern('return'),
            new KeywordPattern('class'),
            new KeywordPattern('class_name'),
            new KeywordPattern('extends'),
            new KeywordPattern('is'),
            new KeywordPattern('not'),
            new KeywordPattern('and'),
            new KeywordPattern('or'),
            new KeywordPattern('in'),
            new KeywordPattern('as'),
            new KeywordPattern('self'),
            new KeywordPattern('signal'),
            new KeywordPattern('func'),
            new KeywordPattern('static'),
            new KeywordPattern('const'),
            new KeywordPattern('enum'),
            new KeywordPattern('var'),
            new KeywordPattern('breakpoint'),
            new KeywordPattern('preload'),
            new KeywordPattern('await'),
            new KeywordPattern('yield'),
            new KeywordPattern('assert'),
            new KeywordPattern('super'),
            new KeywordPattern('PI'),
            new KeywordPattern('INF'),
            new KeywordPattern('TAU'),
            new KeywordPattern('NAN'),

            new SinglelineCommentPattern(),

            new AnnotationPattern(),
            new ExtendsPattern(),
            new ClassNamePattern(),
            new FunctionNamePattern(),
            new FunctionCallPattern(),
            new ReturnTypePattern(),
            new AsTypePattern(),
            new VarTypePattern(),
            new PropertyAccessPattern(),

            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),
        ];
    }
}
