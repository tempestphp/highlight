<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Twig\Patterns\TwigArrayKeyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigFilterPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigKeywordPattern;
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
            new TwigKeywordPattern('set'),
            new TwigKeywordPattern('apply'),
            new TwigKeywordPattern('autoescape'),
            new TwigKeywordPattern('endautoescape'),
            new TwigKeywordPattern('block'),
            new TwigKeywordPattern('endblock'),
            new TwigKeywordPattern('cache'),
            new TwigKeywordPattern('deprecated'),
            new TwigKeywordPattern('do'),
            new TwigKeywordPattern('embed'),
            new TwigKeywordPattern('extends'),
            new TwigKeywordPattern('flush'),
            new TwigKeywordPattern('for'),
            new TwigKeywordPattern('endfor'),
            new TwigKeywordPattern('from'),
            new TwigKeywordPattern('if'),
            new TwigKeywordPattern('else'),
            new TwigKeywordPattern('elseif'),
            new TwigKeywordPattern('endif'),
            new TwigKeywordPattern('import'),
            new TwigKeywordPattern('include'),
            new TwigKeywordPattern('macro'),
            new TwigKeywordPattern('endmacro'),
            new TwigKeywordPattern('sandbox'),
            new TwigKeywordPattern('set'),
            new TwigKeywordPattern('use'),
            new TwigKeywordPattern('verbatim'),
            new TwigKeywordPattern('with'),
            new TwigKeywordPattern('end'),
            new TwigKeywordPattern('as'),
            new TwigKeywordPattern('in'),
            new TwigKeywordPattern('endapply'),
            new TwigKeywordPattern('endcache'),
            new TwigKeywordPattern('endembed'),
            new TwigKeywordPattern('endset'),
            new TwigKeywordPattern('endsandbox'),
            new TwigKeywordPattern('endverbatim'),
            new TwigKeywordPattern('endwith'),
        ];
    }
}
