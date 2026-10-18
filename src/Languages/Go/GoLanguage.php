<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Go;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Go\Patterns\GoCommentPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoFunctionPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoKeywordPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoLiteralPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoNumberPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoOperatorPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoStringPattern;
use Tempest\Highlight\Languages\Go\Patterns\GoTypePattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class GoLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'go';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['golang'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new GoCommentPattern(),
            new GoStringPattern(),
            new GoNumberPattern(),
            new GoKeywordPattern(),
            new GoTypePattern(),
            new GoLiteralPattern(),
            new GoFunctionPattern(),
            new GoOperatorPattern(),
        ];
    }
}
