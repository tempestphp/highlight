<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig;

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
            ["{% extends \"admin/empty_base.html.twig\" %}", '<span class="hl-injection">{% <span class="hl-keyword">extends</span> &quot;<span class="hl-value">admin/empty_base.html.twig</span>&quot; %}</span>'],
            ['{{ stimulus_target("main-search","contentArea") }}', '<span class="hl-injection">{{ <span class="hl-property">stimulus_target</span>(&quot;<span class="hl-value">main-search</span>&quot;,&quot;<span class="hl-value">contentArea</span>&quot;) }}</span>'],
            ["{{ 'Search'|trans }}", '<span class="hl-injection">{{ \'<span class="hl-value">Search</span>\'|<span class="hl-property">trans</span> }}</span>'],
            ['{#<div class="form-inline">#}', '<span class="hl-comment">{#&lt;div class=&quot;form-inline&quot;&gt;#}</span>'],
            ['{#<a href="#">{{ app.user.userIdentifier }}</a>#}', '<span class="hl-comment">{#&lt;a href=&quot;#&quot;&gt;{{ app.<span class="hl-property">user</span>.<span class="hl-property">userIdentifier</span> }}&lt;/a&gt;#}</span>'],
            ["{% if is_granted('IS_IMPERSONATOR') %}", '<span class="hl-injection">{% <span class="hl-keyword">if</span> <span class="hl-property">is_granted</span>(\'<span class="hl-value">IS_IMPERSONATOR</span>\') %}</span>'],
            ["{% else %}", '<span class="hl-injection">{% <span class="hl-keyword">else</span> %}</span>'],
            ["{% endif %}", '<span class="hl-injection">{% <span class="hl-keyword">endif</span> %}</span>'],
            ["{% block layout %}", '<span class="hl-injection">{% <span class="hl-keyword">block</span> layout %}</span>'],
            ["{{ parent() }}", '<span class="hl-injection">{{ <span class="hl-property">parent</span>() }}</span>'],
            ["{{ impersonation_exit_path(path('app.user.list') ) }}", '<span class="hl-injection">{{ <span class="hl-property">impersonation_exit_path</span>(<span class="hl-property">path</span>(\'<span class="hl-value">app.user.list</span>\') ) }}</span>'],
            ["{{ app.user.userIdentifier }}", '<span class="hl-injection">{{ app.<span class="hl-property">user</span>.<span class="hl-property">userIdentifier</span> }}</span>'],
            ['<script>const mainSearchUrl = "";</script>', '&lt;<span class="hl-keyword">script</span>&gt;<span class="hl-keyword">const</span> mainSearchUrl = <span class="hl-value">&quot;&quot;</span>;&lt;/<span class="hl-keyword">script</span>&gt;'],
            ['{% cache "cache key" %}', '<span class="hl-injection">{% <span class="hl-keyword">cache</span> &quot;<span class="hl-value">cache key</span>&quot; %}</span>'],
            ['{{ "<b>foobar</b>"|data_uri(mime="text/html", parameters={charset: "ascii"}) }}', '<span class="hl-injection">{{ &quot;<span class="hl-value">&lt;b&gt;foobar&lt;/b&gt;</span>&quot;|<span class="hl-property">data_uri</span>(<span class="hl-property">mime</span>=&quot;<span class="hl-value">text/html</span>&quot;, <span class="hl-property">parameters</span>={<span class="hl-property">charset</span>: &quot;<span class="hl-value">ascii</span>&quot;}) }}</span>'],
        ];
    }
}
