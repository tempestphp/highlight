<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Twig\Injections\TwigEchoInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigTagInjection;
use Tempest\Highlight\Languages\Twig\Patterns\TwigCommentPattern;

class TwigLanguage extends HtmlLanguage
{
    public function getName(): string
    {
        return 'twig';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new TwigTagInjection(),
            new TwigEchoInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new TwigCommentPattern(),
        ];
    }
}
