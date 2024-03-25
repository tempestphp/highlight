<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html;

use Tempest\Highlight\Languages\Css\Injections\CssAttributeInjection;
use Tempest\Highlight\Languages\Css\Injections\CssInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpShortEchoInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigCommentInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigKeywordInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigPropertyInjection;
use Tempest\Highlight\Languages\Xml\XmlLanguage;

class HtmlLanguage extends XmlLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpInjection(),
            new PhpShortEchoInjection(),
            new CssInjection(),
            new CssAttributeInjection(),
            new TwigPropertyInjection(),
            new TwigKeywordInjection(),
            new TwigCommentInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
        ];
    }
}
