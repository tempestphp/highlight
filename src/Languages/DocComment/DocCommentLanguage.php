<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\DocComment\Patterns\DocCommentTagPattern;
use Tempest\Highlight\Languages\Php\Injections\PhpGenericTypeInjection;

class DocCommentLanguage extends BaseLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpGenericTypeInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new DocCommentTagPattern(),
        ];
    }
}
