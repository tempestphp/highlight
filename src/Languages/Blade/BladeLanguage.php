<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade;

use Tempest\Highlight\Languages\Blade\Injections\BladeEchoInjection;
use Tempest\Highlight\Languages\Blade\Injections\BladeKeywordInjection;
use Tempest\Highlight\Languages\Blade\Injections\BladePhpInjection;
use Tempest\Highlight\Languages\Blade\Injections\BladeRawEchoInjection;
use Tempest\Highlight\Languages\Blade\Patterns\BladeCommentPattern;
use Tempest\Highlight\Languages\Blade\Patterns\BladeComponentCloseTagPattern;
use Tempest\Highlight\Languages\Blade\Patterns\BladeComponentOpenTagPattern;
use Tempest\Highlight\Languages\Blade\Patterns\BladeKeywordPattern;
use Tempest\Highlight\Languages\Html\HtmlLanguage;

class BladeLanguage extends HtmlLanguage
{
    public function getName(): string
    {
        return 'blade';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new BladeKeywordInjection(),
            new BladePhpInjection(),
            new BladeEchoInjection(),
            new BladeRawEchoInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BladeComponentOpenTagPattern(),
            new BladeComponentCloseTagPattern(),
            new BladeKeywordPattern(),
            new BladeCommentPattern(),
        ];
    }
}
