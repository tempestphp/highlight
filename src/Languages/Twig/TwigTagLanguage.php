<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Twig\Patterns\CombinedTwigKeywordPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigArrayKeyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigFilterPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigMethodPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigNamedArgumentPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigPropertyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigSingleQuoteValuePattern;

final class TwigTagLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'twigTag';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // PROPERTIES
            new TwigMethodPattern(),
            new TwigPropertyPattern(),
            new TwigFilterPattern(),
            new TwigNamedArgumentPattern(),
            new TwigArrayKeyPattern(),

            // VALUES
            new TwigDoubleQuoteValuePattern(),
            new TwigSingleQuoteValuePattern(),

            // KEYWORDS
            new CombinedTwigKeywordPattern([
                'set',
                'apply',
                'autoescape',
                'endautoescape',
                'block',
                'endblock',
                'cache',
                'deprecated',
                'do',
                'embed',
                'extends',
                'flush',
                'for',
                'endfor',
                'from',
                'if',
                'else',
                'elseif',
                'endif',
                'import',
                'include',
                'macro',
                'endmacro',
                'sandbox',
                'use',
                'verbatim',
                'with',
                'end',
                'as',
                'in',
                'endapply',
                'endcache',
                'endembed',
                'endset',
                'endsandbox',
                'endverbatim',
                'endwith',
            ]),
        ];
    }
}
