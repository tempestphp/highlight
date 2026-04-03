<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'curl -OL https://example.com/file.phar', output: 'https://example.com/file.phar')]
#[PatternTest(input: 'wget http://archive.ubuntu.com/ubuntu', output: 'http://archive.ubuntu.com/ubuntu')]
#[PatternTest(input: 'curl ftp://files.example.com/data.csv', output: 'ftp://files.example.com/data.csv')]
#[PatternTest(input: 'git clone ssh://git@github.com/user/repo', output: 'ssh://git@github.com/user/repo')]
final readonly class TerminalUrlPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>(?:https?|ftp|sftp|ssh|file):\/\/\S+)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
