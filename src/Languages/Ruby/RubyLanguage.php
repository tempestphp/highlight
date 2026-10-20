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
        return [
            ...parent::getPatterns(),

            // COMMENTS
            new RubyCommentPattern(),

            // VALUES
            new RubyHeredocPattern(),
            new RubyPercentLiteralPattern(),
            new RubyStringPattern(),
            new RubyRegexPattern(),

            // PROPERTIES
            new RubyMethodNamePattern(),
            new RubyHashKeyPattern(),

            // KEYWORDS
            new RubyKeywordPattern(),

            // TYPES
            new RubyConstantPattern(),

            // LITERALS
            new RubyLiteralPattern(),
            new RubySymbolPattern(),

            // VARIABLES
            new RubyVariablePattern(),

            // NUMBERS
            new RubyNumberPattern(),

            // OPERATORS
            new RubyOperatorPattern(),
        ];
    }
}
