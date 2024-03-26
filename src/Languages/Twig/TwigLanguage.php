<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Twig\Injections\TwigTagInjection;
use Tempest\Highlight\Languages\Twig\Patterns\TwigCommentPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigFilterPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigMethodPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigPropertyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigSingleQuoteValuePattern;

class TwigLanguage extends HtmlLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new TwigTagInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // PROPERTIES
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
