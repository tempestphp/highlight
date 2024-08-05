<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class AntlersLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'antlers'),
        );
    }

    public static function data(): array
    {
        return [
            // Comments
            ['{{# Antlers comment #}}', '{{<span class="hl-injection"><span class="hl-comment"># Antlers comment #</span></span>}}'],
            ['{{# comment #}} and {{# other comment #}}', '{{<span class="hl-injection"><span class="hl-comment"># comment #</span></span>}} and {{<span class="hl-injection"><span class="hl-comment"># other comment #</span></span>}}'],
            ['{{# <div> #}}', '{{<span class="hl-injection"><span class="hl-comment"># &lt;div&gt; #</span></span>}}'],

            // Multi-line comments
            ["{{# Antlers\ncomment #}}", "{{<span class=\"hl-injection\"><span class=\"hl-comment\"># Antlers\ncomment #</span></span>}}"],
            ["{{# comment\n<h1> #}}", "{{<span class=\"hl-injection\"><span class=\"hl-comment\"># comment\n&lt;h1&gt; #</span></span>}}"],

            // Failing test with a tag into a comment
            // ['{{# {{ variable }} #}}', '{{<span class="hl-injection"><span class="hl-comment"># {{ variable }} #</span></span>}}'],

            // Failing test with multiline comment
            // ["{{# comment\n<h1>{{ variable}}</h1> #}}", "{{<span class=\"hl-injection\"><span class=\"hl-comment\"># comment\n&lt;h1&gt;{{ variable}}</h1> #</span></span>}}"],

            // Literals
            ['{{ true }}', '{{<span class="hl-injection"> <span class="hl-literal">true</span> </span>}}'],
            ['{{ false }}', '{{<span class="hl-injection"> <span class="hl-literal">false</span> </span>}}'],
            ['{{ null }}', '{{<span class="hl-injection"> <span class="hl-literal">null</span> </span>}}'],

            // Numbers
            ['{{ 123 }}', '{{<span class="hl-injection"> <span class="hl-number">123</span> </span>}}'],
            ['{{ 10 }} 20', '{{<span class="hl-injection"> <span class="hl-number">10</span> </span>}} 20'],

            // Values
            ['{{ "value" }}', '{{<span class="hl-injection"> &quot;<span class="hl-value">value</span>&quot; </span>}}'],
            ['{{ \'value\' }}', '{{<span class="hl-injection"> \'<span class="hl-value">value</span>\' </span>}}'],

            // Variables
            ['{{foo}}', '{{<span class="hl-injection"><span class="hl-variable">foo</span></span>}}'],
            ['{{this_iS-RiDicuL-ou5_}}', '{{<span class="hl-injection"><span class="hl-variable">this_iS-RiDicuL-ou5_</span></span>}}'],
            ['{{ foo }}', '{{<span class="hl-injection"> <span class="hl-variable">foo</span> </span>}}'],
            ['{{ ab }} heey {{ cd }}', '{{<span class="hl-injection"> <span class="hl-variable">ab</span> </span>}} heey {{<span class="hl-injection"> <span class="hl-variable">cd</span> </span>}}'],

            // Nested variable
            ['{{skaters:0:name}}', '{{<span class="hl-injection"><span class="hl-variable">skaters</span>:<span class="hl-number">0</span>:<span class="hl-variable">name</span></span>}}'],
            ['{{skaters.1.name}}', '{{<span class="hl-injection"><span class="hl-variable">skaters</span>.<span class="hl-number">1</span>.<span class="hl-variable">name</span></span>}}'],
            ['{{skaters[2][\'name\']}}', '{{<span class="hl-injection"><span class="hl-variable">skaters</span>[<span class="hl-number">2</span>][\'<span class="hl-value">name</span>\']</span>}}'],

            // Modifiers
            ['{{ "value" | upper }}', '{{<span class="hl-injection"> &quot;<span class="hl-value">value</span>&quot; | <span class="hl-property">upper</span> </span>}}',],
            ['{{ "value" | upper | lower }}', '{{<span class="hl-injection"> &quot;<span class="hl-value">value</span>&quot; | <span class="hl-property">upper</span> | <span class="hl-property">lower</span> </span>}}'],
            ['{{ "value" | upper(variable) }}', '{{<span class="hl-injection"> &quot;<span class="hl-value">value</span>&quot; | <span class="hl-property">upper</span>(<span class="hl-variable">variable</span>) </span>}}'],
            ['{{ "value" | upper(variable) | lower }}', '{{<span class="hl-injection"> &quot;<span class="hl-value">value</span>&quot; | <span class="hl-property">upper</span>(<span class="hl-variable">variable</span>) | <span class="hl-property">lower</span> </span>}}'],
            ['{{ var | modifier(\'hi\', [\'pooh\', \'pea\'], null, 42, $favoriteVar) }}', '{{<span class="hl-injection"> <span class="hl-variable">var</span> | <span class="hl-property">modifier</span>(\'<span class="hl-value">hi</span>\', [\'<span class="hl-value">pooh</span>\', \'<span class="hl-value">pea</span>\'], <span class="hl-literal">null</span>, <span class="hl-number">42</span>, <span class="hl-variable">$favoriteVar</span>) </span>}}'],
            ['{{ ab }} text | dont_match {{ cd }}', '{{<span class="hl-injection"> <span class="hl-variable">ab</span> </span>}} text | dont_match {{<span class="hl-injection"> <span class="hl-variable">cd</span> </span>}}'],

            // Antlers keywords
            ['{{ if }}', '{{<span class="hl-injection"> <span class="hl-keyword">if</span> </span>}}'],
            ['{{ loop from="1" to="10" }} hello! {{ /loop }}', '{{<span class="hl-injection"> <span class="hl-keyword">loop</span> <span class="hl-property">from</span>=&quot;<span class="hl-value">1</span>&quot; <span class="hl-property">to</span>=&quot;<span class="hl-value">10</span>&quot; </span>}} hello! {{<span class="hl-injection"> /<span class="hl-keyword">loop</span> </span>}}'],

            // Sub expression
            ['{{ items = {collection:products sort="rating:desc" limit="5"} }}', '{{<span class="hl-injection"> <span class="hl-variable">items</span> = {<span class="hl-keyword">collection</span>:<span class="hl-variable">products</span> <span class="hl-property">sort</span>=&quot;<span class="hl-value">rating:desc</span>&quot; <span class="hl-property">limit</span>=&quot;<span class="hl-value">5</span>&quot;} </span>}}'],

            // Antlers is an HTML templating language
            ['<h1>{{ title }}</h1>', '&lt;<span class="hl-keyword">h1</span>&gt;{{<span class="hl-injection"> <span class="hl-variable">title</span> </span>}}&lt;/<span class="hl-keyword">h1</span>&gt;'],
        ];
    }
}
