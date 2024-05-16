<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers;

use Tempest\Highlight\Languages\Antlers\Injections\AntlersCommentInjection;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersEchoInjection;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersPhpInjection;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersTagInjection;
use Tempest\Highlight\Languages\Antlers\Patterns\AntlersCommentPattern;
use Tempest\Highlight\Languages\Html\HtmlLanguage;

class AntlersLanguage extends HtmlLanguage
{
    public function getName(): string
    {
        return 'antlers';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new AntlersPhpInjection(),
            new AntlersEchoInjection(),
            // new AntlersCommentInjection(),
            new AntlersTagInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new AntlersCommentPattern(),
        ];
    }
}
