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
            ["{% extends 'admin/empty_base.html.twig' %}", '<span class="hl-type">{%</span> <span class="hl-keyword">extends</span> \'<span class="hl-value">admin/empty_base.html.twig</span>\' <span class="hl-type">%}</span>'],
            ['{{ stimulus_target("main-search","contentArea") }}', '<span class="hl-type">{{</span> <span class="hl-property">stimulus_target</span>(&quot;<span class="hl-value">main-search</span>&quot;,&quot;<span class="hl-value">contentArea</span>&quot;) <span class="hl-type">}}</span>'],
            ["{{ 'Search'|trans }}", '<span class="hl-type">{{</span> \'<span class="hl-value">Search</span>\'|<span class="hl-property">trans</span> <span class="hl-type">}}</span>'],
            ['{#<div class="form-inline">#}', '<span class="hl-comment">{#&lt;div class=&quot;form-inline&quot;&gt;#}</span>'],
            ['{#<a href="#">{{ app.user.userIdentifier }}</a>#}', '<span class="hl-comment">{#&lt;a href=&quot;#&quot;&gt;{{ app.user.userIdentifier }}&lt;/a&gt;#}</span>'],
            ["{% if is_granted('IS_IMPERSONATOR') %}", '<span class="hl-type">{%</span> <span class="hl-keyword">if</span> <span class="hl-property">is_granted</span>(\'<span class="hl-value">IS_IMPERSONATOR</span>\') <span class="hl-type">%}</span>'],
            ["{% else %}", '<span class="hl-type">{%</span> <span class="hl-keyword">else</span> <span class="hl-type">%}</span>'],
            ["{% endif %}", '<span class="hl-type">{%</span> <span class="hl-keyword">endif</span> <span class="hl-type">%}</span>'],
            ["{% block layout %}", '<span class="hl-type">{%</span> <span class="hl-keyword">block</span> layout <span class="hl-type">%}</span>'],
            ["{{ parent() }}", '<span class="hl-type">{{</span> <span class="hl-property">parent</span>() <span class="hl-type">}}</span>'],
            ["{{ impersonation_exit_path(path('app.user.list') ) }}", '<span class="hl-type">{{</span> <span class="hl-property">impersonation_exit_path</span>(<span class="hl-property">path</span>(\'<span class="hl-value">app.user.list</span>\') ) <span class="hl-type">}}</span>'],
            ["{{ app.user.userIdentifier }}", '<span class="hl-type">{{</span> app.<span class="hl-property">user</span>.<span class="hl-property">userIdentifier</span> <span class="hl-type">}}</span>'],

        ];
    }
}
