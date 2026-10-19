<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Tsx;

use Override;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxAttributePattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxEntityPattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxFragmentPattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxSpreadAttributePattern;
use Tempest\Highlight\Languages\Jsx\Patterns\JsxTagPattern;
use Tempest\Highlight\Languages\Tsx\Patterns\TsxGenericArrowPattern;
use Tempest\Highlight\Languages\TypeScript\TypeScriptLanguage;

class TsxLanguage extends TypeScriptLanguage
{
    #[Override]
    public function getName(): string
    {
        return 'tsx';
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
            new TsxGenericArrowPattern(),
            new JsxTagPattern(),
            new JsxFragmentPattern(),
            new JsxAttributePattern(),
            new JsxSpreadAttributePattern(),
            new JsxEntityPattern(),
        ];
    }
}
