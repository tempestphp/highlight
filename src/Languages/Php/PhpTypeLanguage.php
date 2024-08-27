<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Injections\PhpAttributeInstanceInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpAttributePlainInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpDocCommentInjection;
use Tempest\Highlight\Languages\Php\Patterns\ClassPropertyPattern;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Php\Patterns\MultilineSingleDocCommentPattern;
use Tempest\Highlight\Languages\Php\Patterns\NewObjectPattern;
use Tempest\Highlight\Languages\Php\Patterns\SinglelineCommentPattern;
use Tempest\Highlight\Languages\Php\Patterns\TypeForVariablePattern;

final class PhpTypeLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'phptype';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpAttributePlainInjection(),
            new PhpAttributeInstanceInjection(),
            new PhpDocCommentInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // COMMENTS
            new MultilineSingleDocCommentPattern(),
            new SinglelineCommentPattern(),

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
