<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Toml\Patterns\TomlBooleanPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlCommentPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlDateTimePattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlKeyPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlNumberPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlOperatorPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlStringPattern;
use Tempest\Highlight\Languages\Toml\Patterns\TomlTablePattern;
use Tempest\Highlight\SourcePreservingLanguage;

final class TomlLanguage extends BaseLanguage implements SourcePreservingLanguage
{
    public function getName(): string
    {
        return 'toml';
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new TomlKeyPattern(),
            new TomlTablePattern(),
            new TomlStringPattern(),
            new TomlDateTimePattern(),
            new TomlNumberPattern(),
            new TomlBooleanPattern(),
            new TomlCommentPattern(),
            new TomlOperatorPattern(),
        ];
    }
}
