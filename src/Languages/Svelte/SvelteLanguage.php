<?php


declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte;

use Override;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Svelte\Injections\SvelteBlockExpressionInjection;
use Tempest\Highlight\Languages\Svelte\Injections\SvelteExpressionInjection;
use Tempest\Highlight\Languages\Svelte\Injections\SvelteTypeScriptInjection;
use Tempest\Highlight\Languages\Svelte\Patterns\SvelteBlockKeywordPattern;
use Tempest\Highlight\Languages\Svelte\Patterns\SvelteDirectiveArgumentPattern;
use Tempest\Highlight\Languages\Svelte\Patterns\SvelteDirectivePattern;

class SvelteLanguage extends HtmlLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'svelte';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new SvelteTypeScriptInjection(),
            new SvelteExpressionInjection(),
            new SvelteBlockExpressionInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new SvelteBlockKeywordPattern(),
            new SvelteDirectivePattern(),
            new SvelteDirectiveArgumentPattern(),
        ];
    }
}
