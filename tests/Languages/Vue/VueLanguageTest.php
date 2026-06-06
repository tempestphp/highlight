<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Vue;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class VueLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'vue'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [
                '<p>{{ user.name }}</p>',
                '&lt;<span class="hl-keyword">p</span>&gt;{{ user.<span class="hl-property">name</span> }}&lt;/<span class="hl-keyword">p</span>&gt;',
            ],
            [
                '<p>Total: {{ items.length }}</p>',
                '&lt;<span class="hl-keyword">p</span>&gt;Total: {{ items.<span class="hl-property">length</span> }}&lt;/<span class="hl-keyword">p</span>&gt;',
            ],
            [
                '<p v-if="x === 1">one</p>',
                '&lt;<span class="hl-keyword">p</span> <span class="hl-property">v-if</span>=&quot;x === 1&quot;&gt;one&lt;/<span class="hl-keyword">p</span>&gt;',
            ],
            [
                <<<'TXT'
                <p v-if="x === 1">one</p>
                <p v-else-if="x === 2">two</p>
                <p v-else>other</p>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">p</span> <span class="hl-property">v-if</span>=&quot;x === 1&quot;&gt;one&lt;/<span class="hl-keyword">p</span>&gt;
                &lt;<span class="hl-keyword">p</span> <span class="hl-property">v-else-if</span>=&quot;x === 2&quot;&gt;two&lt;/<span class="hl-keyword">p</span>&gt;
                &lt;<span class="hl-keyword">p</span> <span class="hl-property">v-else</span>&gt;other&lt;/<span class="hl-keyword">p</span>&gt;
                TXT,
            ],
            [
                '<li v-for="(item, i) in items" :key="i">{{ item.name }}</li>',
                '&lt;<span class="hl-keyword">li</span> <span class="hl-property">v-for</span>=&quot;(item, i) in items&quot; <span class="hl-property">:key</span>=&quot;i&quot;&gt;{{ item.<span class="hl-property">name</span> }}&lt;/<span class="hl-keyword">li</span>&gt;',
            ],
            [
                '<input v-model="value" />',
                '&lt;<span class="hl-keyword">input</span> <span class="hl-property">v-model</span>=&quot;value&quot; /&gt;',
            ],
            [
                '<a v-bind:href="url" v-on:click="go">link</a>',
                '&lt;<span class="hl-keyword">a</span> <span class="hl-property">v-bind:href</span>=&quot;url&quot; <span class="hl-property">v-on:click</span>=&quot;go&quot;&gt;link&lt;/<span class="hl-keyword">a</span>&gt;',
            ],
            [
                '<button @click="handler" :class="cls">x</button>',
                '&lt;<span class="hl-keyword">button</span> <span class="hl-property">@</span><span class="hl-property">click</span>=&quot;handler&quot; <span class="hl-property">:class</span>=&quot;cls&quot;&gt;x&lt;/<span class="hl-keyword">button</span>&gt;',
            ],
            [
                '<MyComp #default="slotProps">x</MyComp>',
                '&lt;<span class="hl-keyword">MyComp</span> <span class="hl-property">#</span><span class="hl-property">default</span>=&quot;slotProps&quot;&gt;x&lt;/<span class="hl-keyword">MyComp</span>&gt;',
            ],
            [
                <<<'TXT'
                <script setup lang="ts">
                import { ref } from "vue"
                const count = ref(0)
                </script>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">script</span> setup <span class="hl-property">lang</span>=&quot;ts&quot;&gt;
                <span class="hl-keyword">import</span> { ref } <span class="hl-keyword">from</span> <span class="hl-value">&quot;vue&quot;</span>
                <span class="hl-keyword">const</span> count = <span class="hl-property">ref</span>(0)
                &lt;/<span class="hl-keyword">script</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                <script setup>
                const x = 1
                </script>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">script</span> setup&gt;
                <span class="hl-keyword">const</span> <span class="hl-property">x</span> = 1
                &lt;/<span class="hl-keyword">script</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                <style scoped>
                h1 { color: red; }
                </style>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">style</span> scoped&gt;<span class="hl-keyword">
                h1 </span>{ <span class="hl-property">color</span>: red; }
                &lt;/<span class="hl-keyword">style</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                <style lang="scss" scoped>
                h1 { color: red; }
                </style>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">style</span> <span class="hl-property">lang</span>=&quot;scss&quot; scoped&gt;<span class="hl-keyword">
                h1 </span>{ <span class="hl-property">color</span>: red; }
                &lt;/<span class="hl-keyword">style</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                <template>
                  <h1>Hello {{ name }}</h1>
                </template>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">template</span>&gt;
                  &lt;<span class="hl-keyword">h1</span>&gt;Hello {{ name }}&lt;/<span class="hl-keyword">h1</span>&gt;
                &lt;/<span class="hl-keyword">template</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                <script setup lang="ts">
                import { ref } from "vue"
                const count = ref(0)
                </script>

                <template>
                  <button @click="count++">{{ count }}</button>
                </template>

                <style scoped>
                button { color: red; }
                </style>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">script</span> setup <span class="hl-property">lang</span>=&quot;ts&quot;&gt;
                <span class="hl-keyword">import</span> { ref } <span class="hl-keyword">from</span> <span class="hl-value">&quot;vue&quot;</span>
                <span class="hl-keyword">const</span> count = <span class="hl-property">ref</span>(0)
                &lt;/<span class="hl-keyword">script</span>&gt;

                &lt;<span class="hl-keyword">template</span>&gt;
                  &lt;<span class="hl-keyword">button</span> <span class="hl-property">@</span><span class="hl-property">click</span>=&quot;count++&quot;&gt;{{ count }}&lt;/<span class="hl-keyword">button</span>&gt;
                &lt;/<span class="hl-keyword">template</span>&gt;

                &lt;<span class="hl-keyword">style</span> scoped&gt;<span class="hl-keyword">
                button </span>{ <span class="hl-property">color</span>: red; }
                &lt;/<span class="hl-keyword">style</span>&gt;
                TXT,
            ],
        ];
    }
}
