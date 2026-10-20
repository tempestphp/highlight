<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyCommentPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyConstantPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyHashKeyPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyHeredocPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyKeywordPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyLiteralPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyMethodNamePattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyNumberPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyOperatorPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyPercentLiteralPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyRegexPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyStringPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubySymbolPattern;
use Tempest\Highlight\Languages\Ruby\Patterns\RubyVariablePattern;

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
    public function getPatterns(): array
    {
        $lexer = new RubyLexer();

        return [
            ...parent::getPatterns(),

            // COMMENTS
            new RubyCommentPattern(lexer: $lexer),

            // VALUES
            new RubyHeredocPattern(lexer: $lexer),
            new RubyPercentLiteralPattern(lexer: $lexer),
            new RubyStringPattern(lexer: $lexer),
            new RubyRegexPattern(lexer: $lexer),

            // PROPERTIES
            new RubyMethodNamePattern(lexer: $lexer),
            new RubyHashKeyPattern(lexer: $lexer),

            // KEYWORDS
            new RubyKeywordPattern(lexer: $lexer),

            // TYPES
            new RubyConstantPattern(lexer: $lexer),

            // LITERALS
            new RubyLiteralPattern(lexer: $lexer),
            new RubySymbolPattern(lexer: $lexer),

            // VARIABLES
            new RubyVariablePattern(lexer: $lexer),

            // NUMBERS
            new RubyNumberPattern(lexer: $lexer),

            // OPERATORS
            new RubyOperatorPattern(lexer: $lexer),
        ];
    }
}
