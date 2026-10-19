<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx;

use Override;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxAttributePattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxEntityPattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxFragmentPattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxSpreadAttributePattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxTagPattern;

class JsxLanguage extends JavaScriptLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'jsx';
    }

    #[Override]
    public function getAliases(): array
    {
        return [];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new JsxTagPattern(),
            new JsxFragmentPattern(),
            new JsxAttributePattern(),
            new JsxSpreadAttributePattern(),
            new JsxEntityPattern(),
        ];
    }
}
