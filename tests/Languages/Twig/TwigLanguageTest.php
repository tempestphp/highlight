<?php

declare(strict_types=1);

namespace Languages\Twig;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TwigLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'twig'),
        );
    }

    public static function data(): array
    {
        return [
            ["{% extends 'admin/empty_base.html.twig' %}", '{% <span class="hl-keyword">extends</span> \'<span class="hl-value">admin/empty_base.html.twig</span>\' %}'],
            ['{{ stimulus_target("main-search","contentArea") }}', '{{ <span class="hl-property">stimulus_target</span>(&quot;<span class="hl-value">main-search</span>&quot;,&quot;<span class="hl-value">contentArea</span>&quot;) }}'],
            ["{{ 'Search'|trans }}", '{{ \'<span class="hl-value">Search</span>\'|<span class="hl-property">trans</span> }}'],
            ['{#<div class="form-inline">#}', '<span class="hl-comment">{#&lt;div class=&quot;form-inline&quot;&gt;#}</span>'],
            ['{#<a href="#">{{ app.user.userIdentifier }}</a>#}', '<span class="hl-comment">{#&lt;a href=&quot;#&quot;&gt;{{ app.user.userIdentifier }}&lt;/a&gt;#}</span>'],
            ["{% if is_granted('IS_IMPERSONATOR') %}", '{% <span class="hl-keyword">if</span> <span class="hl-property">is_granted</span>(\'<span class="hl-value">IS_IMPERSONATOR</span>\') %}'],
            ["{% else %}", '{% <span class="hl-keyword">else</span> %}'],
            ["{% endif %}", '{% <span class="hl-keyword">endif</span> %}'],
            ["{% block layout %}", '{% <span class="hl-keyword">block</span> layout %}'],
            ["{{ parent() }}", '{{ <span class="hl-property">parent</span>() }}'],
            ["{{ impersonation_exit_path(path('app.user.list') ) }}", '{{ <span class="hl-property">impersonation_exit_path</span>(<span class="hl-property">path</span>(\'<span class="hl-value">app.user.list</span>\') ) }}'],
            ["{{ app.user.userIdentifier }}", '{{ app.<span class="hl-property">user</span>.<span class="hl-property">userIdentifier</span> }}'],
            ['<script>const mainSearchUrl = "";</script>', '&lt;<span class="hl-keyword">script</span>&gt;<span class="hl-keyword">const</span> mainSearchUrl = &quot;<span class="hl-value"><span class="hl-value"></span></span>&quot;;&lt;/<span class="hl-keyword">script</span>&gt;'],
        ];
    }
}
