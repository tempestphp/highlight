<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\TypeScript;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TypeScriptLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'ts'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'typescript'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [
                'type Alias = string;',
                '<span class="hl-keyword">type</span> Alias = <span class="hl-type">string</span>;',
            ],
            [
                <<<'TXT'
                interface User {
                    id: number;
                    name: string;
                }
                TXT,
                <<<'TXT'
                <span class="hl-keyword">interface</span> User {
                    <span class="hl-property">id</span>: <span class="hl-type">number</span>;
                    <span class="hl-property">name</span>: <span class="hl-type">string</span>;
                }
                TXT,
            ],
            [
                'const x: boolean = true;',
                '<span class="hl-keyword">const</span> <span class="hl-property">x</span>: <span class="hl-type">boolean</span> = <span class="hl-keyword">true</span>;',
            ],
            [
                'readonly name: string;',
                '<span class="hl-keyword">readonly</span> <span class="hl-property">name</span>: <span class="hl-type">string</span>;',
            ],
            [
                'function greet(name: string): void {}',
                '<span class="hl-keyword">function</span> <span class="hl-property">greet</span>(<span class="hl-property">name</span>: <span class="hl-type">string</span>): <span class="hl-keyword">void</span> {}',
            ],
            [
                'let u: User = getUser();',
                '<span class="hl-keyword">let</span> <span class="hl-property">u</span>: <span class="hl-type">User</span> = <span class="hl-property">getUser</span>();',
            ],
            [
                'function identity<T>(v: T): T {}',
                '<span class="hl-keyword">function</span> identity<span class="hl-generic">&lt;T&gt;</span>(<span class="hl-property">v</span>: <span class="hl-type">T</span>): <span class="hl-type">T</span> {}',
            ],
            [
                'class Service<K, V extends Base> {}',
                '<span class="hl-keyword">class</span> <span class="hl-type">Service</span><span class="hl-generic">&lt;K, V <span class="hl-keyword">extends</span> Base&gt;</span> {}',
            ],
            [
                <<<'TXT'
                @Component({ selector: 'x' })
                class Foo {}
                TXT,
                <<<'TXT'
                <span class="hl-attribute">@<span class="hl-property">Component</span></span>({ <span class="hl-property">selector</span>: <span class="hl-value">'x'</span> })
                <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> {}
                TXT,
            ],
            [
                <<<'TXT'
                @Injectable
                export class Bar {}
                TXT,
                <<<'TXT'
                <span class="hl-attribute">@Injectable</span>
                <span class="hl-keyword">export</span> <span class="hl-keyword">class</span> <span class="hl-type">Bar</span> {}
                TXT,
            ],
            [
                <<<'TXT'
                /**
                 * Greet a user.
                 * @param {string} name
                 */
                function greet(name: string): void {}
                TXT,
                <<<'TXT'
                <span class="hl-comment">/**
                 * Greet a user.
                 * <span class="hl-value">@param</span> <span class="hl-type">{string}</span> <span class="hl-value">name</span>
                 */</span>
                <span class="hl-keyword">function</span> <span class="hl-property">greet</span>(<span class="hl-property">name</span>: <span class="hl-type">string</span>): <span class="hl-keyword">void</span> {}
                TXT,
            ],
        ];
    }
}
