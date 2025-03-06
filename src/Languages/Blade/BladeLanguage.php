<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade;

use Tempest\Highlight\Languages\Blade\Injections\BladeEchoPhpInjection;
use Tempest\Highlight\Languages\Blade\Injections\BladeKeywordPhpInjection;
use Tempest\Highlight\Languages\Blade\Patterns\BladeCommentPattern;
use Tempest\Highlight\Languages\Blade\Patterns\BladeKeywordPattern;
use Tempest\Highlight\Languages\Html\HtmlLanguage;

final class BladeLanguage extends HtmlLanguage
{
    public function getName(): string
    {
        return 'blade';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new BladeKeywordPhpInjection(),
            new BladeEchoPhpInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BladeKeywordPattern(),
            new BladeCommentPattern(),
        ];
    }
}
