<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentTagPattern;

class DocCommentLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'doc';
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
            new DocCommentTagPattern(),
        ];
    }
}
