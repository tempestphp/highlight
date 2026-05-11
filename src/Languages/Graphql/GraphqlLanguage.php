<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlCommentPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlDirectivePattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlFieldPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlKeywordPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlLiteralPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlNumberPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlPunctuationPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlStringPattern;
use Tempest\Highlight\Languages\Graphql\Patterns\GraphqlVariablePattern;

class GraphqlLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'graphql';
    }

    public function getAliases(): array
    {
        return ['gql'];
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

            // Comments
            new GraphqlCommentPattern(),

            // Strings
            new GraphqlStringPattern(),

            // Keywords: query, mutation, type, etc.
            new GraphqlKeywordPattern(),

            // Literals: true, false, null, and Types like String, Int
            new GraphqlLiteralPattern(),

            // Variables: $id
            new GraphqlVariablePattern(),

            // Directives: @deprecated
            new GraphqlDirectivePattern(),

            // Numbers
            new GraphqlNumberPattern(),

            // Symbols/Fields: name followed by a colon
            new GraphqlFieldPattern(),

            // Punctuation: !, (, ), :, =, [, ], {, |, } and ...
            new GraphqlPunctuationPattern(),
        ];
    }
}
