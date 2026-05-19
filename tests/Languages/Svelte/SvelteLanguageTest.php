<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Svelte;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class SvelteLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'svelte'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [
                <<<'TXT'
                <script lang="ts">
                    let count: number = 0;
                    const increment = (): void => count++;
                </script>

                <button on:click={increment}>
                    Clicked {count} times
                </button>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">script</span> <span class="hl-property">lang</span>=&quot;ts&quot;&gt;
                    <span class="hl-keyword">let</span> <span class="hl-property">count</span>: <span class="hl-type">number</span> = 0;
                    <span class="hl-keyword">const</span> increment = (): <span class="hl-keyword">void</span> =&gt; count++;
                &lt;/<span class="hl-keyword">script</span>&gt;

                &lt;<span class="hl-keyword">button</span> <span class="hl-property">on</span>:<span class="hl-property">click</span>={increment}&gt;
                    Clicked {count} times
                &lt;/<span class="hl-keyword">button</span>&gt;
                TXT
            ],
            [
                <<<'TXT'
                <!-- a counter component -->
                <script lang="ts">
                    let name: string = "world";
                </script>

                <h1>Hello {name}!</h1>

                <style>
                    h1 { color: red; }
                </style>
                TXT,
                <<<'TXT'
                <span class="hl-comment">&lt;!-- a counter component --&gt;</span>
                &lt;<span class="hl-keyword">script</span> <span class="hl-property">lang</span>=&quot;ts&quot;&gt;
                    <span class="hl-keyword">let</span> <span class="hl-property">name</span>: <span class="hl-type">string</span> = <span class="hl-value">&quot;world&quot;</span>;
                &lt;/<span class="hl-keyword">script</span>&gt;

                &lt;<span class="hl-keyword">h1</span>&gt;Hello {name}!&lt;/<span class="hl-keyword">h1</span>&gt;

                &lt;<span class="hl-keyword">style</span>&gt;<span class="hl-keyword">
                    h1 </span>{ <span class="hl-property">color</span>: red; }
                &lt;/<span class="hl-keyword">style</span>&gt;
                TXT
            ],
            [
                '<input type="text" bind:value={name} placeholder="enter name" />',
                '&lt;<span class="hl-keyword">input</span> <span class="hl-property">type</span>=&quot;text&quot; <span class="hl-property">bind</span>:<span class="hl-property">value</span>={name} <span class="hl-property">placeholder</span>=&quot;enter name&quot; /&gt;',
            ],
            [
                <<<'TXT'
                {#if count > 5}
                    <p>big</p>
                {:else if count > 0}
                    <p>small</p>
                {:else}
                    <p>zero</p>
                {/if}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#if</span> count &gt; 5}
                    &lt;<span class="hl-keyword">p</span>&gt;big&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:else</span> <span class="hl-keyword">if</span> count &gt; 0}
                    &lt;<span class="hl-keyword">p</span>&gt;small&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:else</span>}
                    &lt;<span class="hl-keyword">p</span>&gt;zero&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/if</span>}
                TXT,
            ],
            [
                <<<'TXT'
                <ul>
                {#each items as item, i}
                    <li>{i}: {item.name}</li>
                {/each}
                </ul>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">ul</span>&gt;
                {<span class="hl-keyword">#each</span> items <span class="hl-keyword">as</span> item, i}
                    &lt;<span class="hl-keyword">li</span>&gt;{i}: {item.<span class="hl-property">name</span>}&lt;/<span class="hl-keyword">li</span>&gt;
                {<span class="hl-keyword">/each</span>}
                &lt;/<span class="hl-keyword">ul</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                {@const total = a + b}
                <p>{@html rawContent}</p>
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">@const</span> <span class="hl-property">total</span> = a + b}
                &lt;<span class="hl-keyword">p</span>&gt;{<span class="hl-keyword">@html</span> rawContent}&lt;/<span class="hl-keyword">p</span>&gt;
                TXT,
            ],
            [
                '<p>Length: {items.length}</p>',
                '&lt;<span class="hl-keyword">p</span>&gt;Length: {items.<span class="hl-property">length</span>}&lt;/<span class="hl-keyword">p</span>&gt;',
            ],
            [
                '<form onsubmit={(e) => { e.preventDefault(); add(); }}>',
                '&lt;<span class="hl-keyword">form</span> onsubmit={(e) =&gt; { e.<span class="hl-property">preventDefault</span>(); <span class="hl-property">add</span>(); }}&gt;',
            ],
            [
                <<<'TXT'
                {#each entries as { key, value }}
                    <dt>{key}</dt>
                {/each}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#each</span> entries <span class="hl-keyword">as</span> { key, value }}
                    &lt;<span class="hl-keyword">dt</span>&gt;{key}&lt;/<span class="hl-keyword">dt</span>&gt;
                {<span class="hl-keyword">/each</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#each todos.filter((t) => ({ ...t, label: t.text })) as todo (todo.id)}
                    <li>{todo.label}</li>
                {/each}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#each</span> todos.<span class="hl-property">filter</span>((t) =&gt; ({ ...<span class="hl-property">t</span>, <span class="hl-property">label</span>: t.<span class="hl-property">text</span> })) <span class="hl-keyword">as</span> todo (todo.<span class="hl-property">id</span>)}
                    &lt;<span class="hl-keyword">li</span>&gt;{todo.<span class="hl-property">label</span>}&lt;/<span class="hl-keyword">li</span>&gt;
                {<span class="hl-keyword">/each</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#if items.some((x) => x.meta?.tags?.includes('urgent'))}
                    <p>urgent</p>
                {/if}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#if</span> items.<span class="hl-property">some</span>((x) =&gt; x.<span class="hl-property">meta</span>?.<span class="hl-property">tags</span>?.<span class="hl-property">includes</span>(<span class="hl-value">'urgent'</span>))}
                    &lt;<span class="hl-keyword">p</span>&gt;urgent&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/if</span>}
                TXT,
            ],
            [
                '{@const summary = { count: items.length, urgent: true }}',
                '{<span class="hl-keyword">@const</span> summary = { <span class="hl-property">count</span>: items.<span class="hl-property">length</span>, <span class="hl-property">urgent</span>: <span class="hl-keyword">true</span> }}',
            ],
            [
                <<<'TXT'
                {#each Object.entries({ a: 1, b: 2 }) as [key, value]}
                    <p>{key} = {value}</p>
                {/each}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#each</span> <span class="hl-type">Object</span>.<span class="hl-property">entries</span>({ <span class="hl-property">a</span>: 1, <span class="hl-property">b</span>: 2 }) <span class="hl-keyword">as</span> [key, value]}
                    &lt;<span class="hl-keyword">p</span>&gt;{key} = {value}&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/each</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#await promise}
                    <p>waiting</p>
                {:then value}
                    <p>{value}</p>
                {:catch error}
                    <p>{error.message}</p>
                {/await}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#await</span> promise}
                    &lt;<span class="hl-keyword">p</span>&gt;waiting&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:then</span> value}
                    &lt;<span class="hl-keyword">p</span>&gt;{value}&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:catch</span> error}
                    &lt;<span class="hl-keyword">p</span>&gt;{error.<span class="hl-property">message</span>}&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/await</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#key id}
                    <div>content</div>
                {/key}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#key</span> id}
                    &lt;<span class="hl-keyword">div</span>&gt;content&lt;/<span class="hl-keyword">div</span>&gt;
                {<span class="hl-keyword">/key</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#snippet greet(name)}
                    <p>Hello {name}</p>
                {/snippet}
                {@render greet('world')}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#snippet</span> <span class="hl-property">greet</span>(name)}
                    &lt;<span class="hl-keyword">p</span>&gt;Hello {name}&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/snippet</span>}
                {<span class="hl-keyword">@render</span> <span class="hl-property">greet</span>(<span class="hl-value">'world'</span>)}
                TXT,
            ],
            [
                '{@debug user, count}',
                '{<span class="hl-keyword">@debug</span> user, count}',
            ],
            [
                '<input class:active={isActive} bind:value={text} on:input={handle} />',
                '&lt;<span class="hl-keyword">input</span> <span class="hl-property">class</span>:<span class="hl-property">active</span>={isActive} <span class="hl-property">bind</span>:<span class="hl-property">value</span>={text} <span class="hl-property">on</span>:<span class="hl-property">input</span>={handle} /&gt;',
            ],
            [
                '<Modal {title} {onclose} />',
                '&lt;<span class="hl-keyword">Modal</span> {title} {onclose} /&gt;',
            ],
            [
                <<<'TXT'
                <script lang="ts">
                    let count = $state(0);
                    let doubled = $derived(count * 2);
                </script>
                TXT,
                <<<'TXT'
                &lt;<span class="hl-keyword">script</span> <span class="hl-property">lang</span>=&quot;ts&quot;&gt;
                    <span class="hl-keyword">let</span> count = <span class="hl-property">$state</span>(0);
                    <span class="hl-keyword">let</span> doubled = <span class="hl-property">$derived</span>(count * 2);
                &lt;/<span class="hl-keyword">script</span>&gt;
                TXT,
            ],
            [
                <<<'TXT'
                {#if x === 1}
                    <p>one</p>
                {:else if x === 2}
                    <p>two</p>
                {:else if x === 3}
                    <p>three</p>
                {:else}
                    <p>other</p>
                {/if}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#if</span> x === 1}
                    &lt;<span class="hl-keyword">p</span>&gt;one&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:else</span> <span class="hl-keyword">if</span> x === 2}
                    &lt;<span class="hl-keyword">p</span>&gt;two&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:else</span> <span class="hl-keyword">if</span> x === 3}
                    &lt;<span class="hl-keyword">p</span>&gt;three&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">:else</span>}
                    &lt;<span class="hl-keyword">p</span>&gt;other&lt;/<span class="hl-keyword">p</span>&gt;
                {<span class="hl-keyword">/if</span>}
                TXT,
            ],
            [
                <<<'TXT'
                {#each groups as group}
                    <h2>{group.name}</h2>
                    {#each group.items as item}
                        <p>{item}</p>
                    {/each}
                {/each}
                TXT,
                <<<'TXT'
                {<span class="hl-keyword">#each</span> groups <span class="hl-keyword">as</span> group}
                    &lt;<span class="hl-keyword">h2</span>&gt;{group.<span class="hl-property">name</span>}&lt;/<span class="hl-keyword">h2</span>&gt;
                    {<span class="hl-keyword">#each</span> group.<span class="hl-property">items</span> <span class="hl-keyword">as</span> item}
                        &lt;<span class="hl-keyword">p</span>&gt;{item}&lt;/<span class="hl-keyword">p</span>&gt;
                    {<span class="hl-keyword">/each</span>}
                {<span class="hl-keyword">/each</span>}
                TXT,
            ],
        ];
    }
}
