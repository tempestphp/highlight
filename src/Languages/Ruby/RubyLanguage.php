<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyBlockCommentPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyClassNamePattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyCommentPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyConstantPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyDoubleQuoteStringPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyGlobalVariablePattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyInstanceVariablePattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyKeywordPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyLogicalValuePattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyMethodPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyNumberPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyOperatorPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubySingleQuoteStringPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubySymbolPattern;

class RubyLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'ruby';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['rb'];
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

            // COMMENTS
            new RubyBlockCommentPattern(),
            new RubyCommentPattern(),

            // KEYWORDS
            new RubyKeywordPattern(),

            // PROPERTY
            new RubyClassNamePattern(),
            new RubyMethodPattern(),

            // TYPES
            new RubyConstantPattern(),

            // NUMBERS
            new RubyNumberPattern(),

            // LITERALS
            new RubyLogicalValuePattern(),
            new RubySymbolPattern(),

            // VALUES
            new RubySingleQuoteStringPattern(),
            new RubyDoubleQuoteStringPattern(),

            // VARIABLES
            new RubyInstanceVariablePattern(),
            new RubyGlobalVariablePattern(),

            // OPERATORS
            new RubyOperatorPattern(),
        ];
    }
}
