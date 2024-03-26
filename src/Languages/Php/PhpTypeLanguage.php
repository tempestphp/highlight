<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\ClassPropertyPattern;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Php\Patterns\NewObjectPattern;
use Tempest\Highlight\Languages\Php\Patterns\TypeForVariablePattern;

final class PhpTypeLanguage extends BaseLanguage
{
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            new KeywordPattern('public'),
            new KeywordPattern('private'),
            new KeywordPattern('protected'),
            new KeywordPattern('null'),
            new KeywordPattern('true'),
            new KeywordPattern('false'),
            new KeywordPattern('new'),
            new KeywordPattern('readonly'),

            new TypeForVariablePattern(),
            new ClassPropertyPattern(),
            new NewObjectPattern(),
        ];
    }
}
