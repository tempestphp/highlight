<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue;

use Override;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Vue\Injections\VueInterpolationInjection;
use Tempest\Highlight\Languages\Vue\Injections\VueScriptSetupInjection;
use Tempest\Highlight\Languages\Vue\Injections\VueStyleScopedInjection;
use Tempest\Highlight\Languages\Vue\Injections\VueStyleScssInjection;
use Tempest\Highlight\Languages\Vue\Injections\VueTypeScriptInjection;
use Tempest\Highlight\Languages\Vue\Patterns\VueDirectiveArgumentPattern;
use Tempest\Highlight\Languages\Vue\Patterns\VueDirectivePattern;
use Tempest\Highlight\Languages\Vue\Patterns\VueDirectiveShorthandArgumentPattern;
use Tempest\Highlight\Languages\Vue\Patterns\VueDirectiveShorthandPattern;

class VueLanguage extends HtmlLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'vue';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new VueTypeScriptInjection(),
            new VueScriptSetupInjection(),
            new VueStyleScssInjection(),
            new VueStyleScopedInjection(),
            new VueInterpolationInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new VueDirectivePattern(),
            new VueDirectiveArgumentPattern(),
            new VueDirectiveShorthandPattern(),
            new VueDirectiveShorthandArgumentPattern(),
        ];
    }
}
