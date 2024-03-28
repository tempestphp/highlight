<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Pxp;

use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Languages\Pxp\Injections\PxpGenericTypeInjection;
use Tempest\Highlight\Languages\Pxp\Patterns\PxpTypeAliasPattern;
use Tempest\Highlight\Languages\Pxp\Patterns\PxpTypeDefinitionPattern;

class PxpLanguage extends PhpLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),

            new PxpGenericTypeInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            new KeywordPattern('type'),

            new PxpTypeAliasPattern(),
            new PxpTypeDefinitionPattern(),
        ];
    }
}
