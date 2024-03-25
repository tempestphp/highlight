<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Twig\Patterns\TwigCommentPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigFilterPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigMethodPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigPropertyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigSingleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigTagPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigTokenPattern;
use Tempest\Highlight\Tokens\TokenType;

class TwigLanguage extends BaseLanguage
{
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

            new TwigTokenPattern("^{%", TokenType::TYPE),
            new TwigTokenPattern("%}$", TokenType::TYPE),
            new TwigTokenPattern("^{{", TokenType::TYPE),
            new TwigTokenPattern("}}$", TokenType::TYPE),
            new TwigTokenPattern("^{#", TokenType::TYPE),
            new TwigTokenPattern("#}$", TokenType::TYPE),
            // TAGS
            new TwigTagPattern('set'),
            new TwigTagPattern('apply'),
            new TwigTagPattern('autoescape'),
            new TwigTagPattern('block'),
            new TwigTagPattern('endblock'),
            new TwigTagPattern('cache'),
            new TwigTagPattern('deprecated'),
            new TwigTagPattern('do'),
            new TwigTagPattern('embed'),
            new TwigTagPattern('extends'),
            new TwigTagPattern('flush'),
            new TwigTagPattern('for'),
            new TwigTagPattern('endfor'),
            new TwigTagPattern('from'),
            new TwigTagPattern('if'),
            new TwigTagPattern('else'),
            new TwigTagPattern('elseif'),
            new TwigTagPattern('endif'),
            new TwigTagPattern('import'),
            new TwigTagPattern('include'),
            new TwigTagPattern('macro'),
            new TwigTagPattern('endmacro'),
            new TwigTagPattern('sandbox'),
            new TwigTagPattern('set'),
            new TwigTagPattern('use'),
            new TwigTagPattern('verbatim'),
            new TwigTagPattern('with'),

            // METHOD AND PROPERTY
            new TwigMethodPattern(),
            new TwigPropertyPattern(),
            new TwigFilterPattern(),
            // COMMENTS
            new TwigCommentPattern(),


            // VALUES
            new TwigSingleQuoteValuePattern(),
            new TwigDoubleQuoteValuePattern(),
        ];
    }
}
