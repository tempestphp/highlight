<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DotEnv;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\DotEnv\Patterns\DotEnvCommentPattern;
use Tempest\Highlight\Languages\DotEnv\Patterns\DotEnvKeyPattern;

final class DotEnvLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'dotenv';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['env'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new DotEnvKeyPattern(),
            new DotEnvCommentPattern(),
        ];
    }
}
