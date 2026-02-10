<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Injections\PhpAttributeInstanceInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpAttributePlainInjection;
use Tempest\Highlight\Languages\Php\Injections\PhpDocCommentInjection;
use Tempest\Highlight\Languages\Php\Patterns\ClassPropertyPattern;
use Tempest\Highlight\Languages\Php\Patterns\CombinedKeywordPattern;
use Tempest\Highlight\Languages\Php\Patterns\MultilineSingleDocCommentPattern;
use Tempest\Highlight\Languages\Php\Patterns\NewObjectPattern;
use Tempest\Highlight\Languages\Php\Patterns\PhpAsymmetricPropertyPattern;
use Tempest\Highlight\Languages\Php\Patterns\SinglelineCommentPattern;
use Tempest\Highlight\Languages\Php\Patterns\TypeForVariablePattern;

final class PhpTypeLanguage extends BaseLanguage
{
    private const array KEYWORDS = [
        'public', 'private', 'protected',
        'null', 'true', 'false',
        'new', 'readonly',
    ];

    public function getName(): string
    {
        return 'phptype';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new PhpAttributePlainInjection(),
            new PhpAttributeInstanceInjection(),
            new PhpDocCommentInjection(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // COMMENTS
            new MultilineSingleDocCommentPattern(),
            new SinglelineCommentPattern(),

            new CombinedKeywordPattern(self::KEYWORDS),

            new TypeForVariablePattern(),
            new ClassPropertyPattern(),
            new NewObjectPattern(),
            new PhpAsymmetricPropertyPattern(),
        ];
    }
}
