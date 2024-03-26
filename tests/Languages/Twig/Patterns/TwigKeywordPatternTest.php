<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Patterns\TwigKeywordPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class TwigKeywordPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new TwigKeywordPattern("extends"),
            content: "{% extends 'admin/empty_base.html.twig' %}",
            expected: 'extends',
        );

        $this->assertMatches(
            pattern: new TwigKeywordPattern("if"),
            content: "{% if is_granted('IS_IMPERSONATOR') %}",
            expected: 'if',
        );
    }
}
