<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'package com.example.app', output: 'com.example.app')]
#[PatternTest(input: 'import kotlin.io.*', output: 'kotlin.io.*')]
final readonly class KotlinNamespacePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:package|import)\s+(?<match>[A-Za-z_]\w*(?:\.[A-Za-z_*][\w*]*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
