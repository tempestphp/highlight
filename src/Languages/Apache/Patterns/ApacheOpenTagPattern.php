<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<VirtualHost *:80>', output: 'VirtualHost')]
#[PatternTest(input: '<Directory /var/www>', output: 'Directory')]
#[PatternTest(input: '<Location /admin>', output: 'Location')]
#[PatternTest(input: '<IfModule mod_ssl.c>', output: 'IfModule')]
#[PatternTest(input: '<FilesMatch "\.php$">', output: 'FilesMatch')]
final readonly class ApacheOpenTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<(?<match>[A-Za-z]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
