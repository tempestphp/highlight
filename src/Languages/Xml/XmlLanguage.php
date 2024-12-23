<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Xml\Patterns\XmlAttributePattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlCloseTagPattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlCommentPattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlOpenTagPattern;

class XmlLanguage extends BaseLanguage
{
    #[\Override]
    public function getName(): string
    {
        return 'xml';
    }

    #[\Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[\Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new XmlOpenTagPattern(),
            new XmlCloseTagPattern(),
            new XmlAttributePattern(),
            new XmlCommentPattern(),
        ];
    }
}
