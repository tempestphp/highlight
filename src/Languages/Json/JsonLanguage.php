<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Json;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Json\Patterns\JsonAccoladesPattern;
use Tempest\Highlight\Languages\Json\Patterns\JsonArrayBracketsPattern;
use Tempest\Highlight\Languages\Json\Patterns\JsonDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Json\Patterns\JsonPropertyPattern;

class JsonLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'json';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new JsonPropertyPattern(),
            new JsonAccoladesPattern(),
            new JsonArrayBracketsPattern(),
            new JsonDoubleQuoteValuePattern(),
        ];
    }
}
