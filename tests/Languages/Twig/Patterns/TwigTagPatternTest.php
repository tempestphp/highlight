<?php

declare(strict_types=1);

namespace Languages\Twig\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Patterns\TwigTagPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class TwigTagPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new TwigTagPattern("extends"),
            content: "{% extends 'admin/empty_base.html.twig' %}",
            expected: 'extends',
        );

        $this->assertMatches(
            pattern: new TwigTagPattern("if"),
            content: "{% if is_granted('IS_IMPERSONATOR') %}",
            expected: 'if',
        );
    }
}
