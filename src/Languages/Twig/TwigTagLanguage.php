<?php

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Twig\Patterns\TwigKeywordPattern;

final class TwigTagLanguage extends BaseLanguage
{
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

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
        ];
    }
}