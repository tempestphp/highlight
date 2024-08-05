<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers;

use Tempest\Highlight\Languages\Antlers\Injections\AntlersDelimiterInjection;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersEchoInjection;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersPhpInjection;
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
            new AntlersDelimiterInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
        ];
    }
}
