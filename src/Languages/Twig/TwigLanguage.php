<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig;

use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Twig\Injections\TwigCommentInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigEchoInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigTagInjection;

class TwigLanguage extends HtmlLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new TwigCommentInjection(),
            new TwigTagInjection(),
            new TwigEchoInjection(),
        ];
    }
}
