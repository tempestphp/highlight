<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html;

use Tempest\Highlight\Languages\Html\Injections\CssAttributeInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\CssInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\JavaScriptInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\PhpInHtmlInjection;
use Tempest\Highlight\Languages\Html\Injections\PhpShortEchoInHtmlInjection;
use Tempest\Highlight\Languages\Xml\XmlLanguage;

class HtmlLanguage extends XmlLanguage
{
    public function getName(): string
    {
        return 'html';
    }

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

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
        ];
    }
}
