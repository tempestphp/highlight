<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\BBCode;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\BBCode\Patterns\BBCodeAttributePattern;
use Tempest\Highlight\Languages\BBCode\Patterns\BBCodeCloseTagPattern;
use Tempest\Highlight\Languages\BBCode\Patterns\BBCodeTagPattern;

class BBCodeLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'bbcode';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BBCodeAttributePattern(),
            new BBCodeTagPattern(),
            new BBCodeCloseTagPattern(),
        ];
    }
}
