<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens\Fixtures;

use ArrayObject;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class ConfigurablePattern implements Pattern
{
    use IsPattern;

    /**
     * @param ArrayObject<string, mixed> $config
     */
    public function __construct(
        private ArrayObject $config,
    ) {
    }

    public function getPattern(): string
    {
        return "(?<match>{$this->config['word']})";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return $this->config['type'];
    }
}
