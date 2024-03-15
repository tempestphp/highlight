<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages;

use Tempest\Highlight\Injections\CssInjection;
use Tempest\Highlight\Injections\PhpInjection;
use Tempest\Highlight\Injections\PhpShortEchoInjection;
use Tempest\Highlight\Language;
use Tempest\Highlight\Patterns\Html\CloseTagPattern;
use Tempest\Highlight\Patterns\Html\HtmlCommentPattern;
use Tempest\Highlight\Patterns\Html\OpenTagPattern;
use Tempest\Highlight\Patterns\Html\TagAttributePattern;

class HtmlLanguage implements Language
{
    public function getInjections(): array
    {
        return [
            new PhpInjection(),
            new PhpShortEchoInjection(),
            new CssInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            new OpenTagPattern(),
            new CloseTagPattern(),
            new TagAttributePattern(),
            new HtmlCommentPattern(),
        ];
    }
}
