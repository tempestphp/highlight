<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Gdscript\Patterns\AnnotationPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\AsTypePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\ClassNamePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\CombinedGdscriptKeywordPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\ExtendsPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\FunctionCallPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\FunctionNamePattern;
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

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
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
            new OperatorPattern('&'),
            new OperatorPattern('^'),
            new OperatorPattern('|'),
            new OperatorPattern('<'),
            new OperatorPattern('>'),
            new OperatorPattern('!'),

            new CombinedGdscriptKeywordPattern([
                'if',
                'elif',
                'else',
                'for',
                'while',
                'match',
                'break',
                'continue',
                'pass',
                'return',
                'class',
                'class_name',
                'extends',
                'is',
                'not',
                'and',
                'or',
                'in',
                'as',
                'self',
                'signal',
                'func',
                'static',
                'const',
                'enum',
                'var',
                'breakpoint',
                'preload',
                'await',
                'yield',
                'assert',
                'super',
                'PI',
                'INF',
                'TAU',
                'NAN',
            ]),

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
