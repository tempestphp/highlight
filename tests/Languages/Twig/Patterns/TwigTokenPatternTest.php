<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Patterns\TwigTokenPattern;
use Tempest\Highlight\Tests\TestsPatterns;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class TwigTokenPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new TwigTokenPattern("^{%", TokenTypeEnum::TYPE),
            content: "{% extends 'admin/empty_base.html.twig' %}",
            expected: '{%',
        );

        $this->assertMatches(
            pattern: new TwigTokenPattern("}}$", TokenTypeEnum::TYPE),
            content: "{{ path('app.logout') }}",
            expected: '}}',
        );
    }
}
