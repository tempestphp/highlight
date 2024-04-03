<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Twig\Patterns\TwigArrayKeyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigFilterPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigMethodPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigNamedArgumentPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigPropertyPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigSingleQuoteValuePattern;

final class TwigEchoLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'twigEcho';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),


            // PROPERTIES
            new TwigMethodPattern(),
            new TwigPropertyPattern(),
            new TwigFilterPattern(),
            new TwigArrayKeyPattern(),
            new TwigNamedArgumentPattern(),

            // VALUES
            new TwigDoubleQuoteValuePattern(),
            new TwigSingleQuoteValuePattern(),
        ];
    }
}
