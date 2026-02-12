<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Html\Injections\CssAttributeInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\CssInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\JavaScriptInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\PhpInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\PhpShortEchoInHtmlInjection;
use Tempest\Highlight\Languages\Html\Patterns\HtmlAttributePattern;
use Tempest\Highlight\Languages\Html\Patterns\HtmlCloseTagPattern;
use Tempest\Highlight\Languages\Html\Patterns\HtmlOpenTagPattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlCommentPattern;

class HtmlLanguage extends BaseLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'html';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpInHtmlInjection(),
            new PhpShortEchoInHtmlInjection(),
            new CssInHtmlInjection(),
            new CssAttributeInHtmlInjection(),
            new JavaScriptInHtmlInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new HtmlOpenTagPattern(),
            new HtmlCloseTagPattern(),
            new HtmlAttributePattern(),
            new XmlCommentPattern(),
        ];
    }
}
