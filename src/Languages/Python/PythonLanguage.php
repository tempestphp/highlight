<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;
use Tempest\Highlight\Languages\Python\Patterns\PyArgumentPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyBuiltinPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyClassNamePattern;
use Tempest\Highlight\Languages\Python\Patterns\PyCommentPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyDecoratorPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyFunctionPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyKeywordPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyLogicalValuePattern;
use Tempest\Highlight\Languages\Python\Patterns\PyNumberPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyOperatorPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyTripleDoubleQuoteStringPattern;
use Tempest\Highlight\Languages\Python\Patterns\PyTripleSingleQuoteStringPattern;

class PythonLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'python';
    }

    public function getAliases(): array
    {
        return ['py'];
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

            // KEYWORDS
            new PyKeywordPattern(),

            // PROPERTY
            new PyClassNamePattern(),
            new PyDecoratorPattern(),
            new PyFunctionPattern(),

            // TYPES
            new PyBuiltinPattern(),

            // COMMENTS
            new PyCommentPattern(),

            // NUMBERS
            new PyNumberPattern(),

            // LITERALS
            new PyLogicalValuePattern(),

            // OPERATORS
            new PyOperatorPattern(),

            // VALUES
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),
            new PyTripleDoubleQuoteStringPattern(),
            new PyTripleSingleQuoteStringPattern(),

            // VARIABLES
            new PyArgumentPattern(),
        ];
    }
}
