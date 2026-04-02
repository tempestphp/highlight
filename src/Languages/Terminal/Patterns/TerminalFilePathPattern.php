<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'start app.js --log', output: 'app.js')]
#[PatternTest(input: '--log /var/log/my-app.log', output: '/var/log/my-app.log')]
#[PatternTest(input: 'add .husky/pre-commit foo', output: '.husky/pre-commit')]
#[PatternTest(input: 'install hashicorp/tap/terraform', output: 'hashicorp/tap/terraform')]
final readonly class TerminalFilePathPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\.?\/?[\w.-]+(?:\/[\w.\/-]+)+|[\w][\w-]*\.[a-zA-Z]{1,10}\b)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
