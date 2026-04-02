<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Terminal;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TerminalLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'terminal'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'console'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'term'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
$ npm install --save express
added 57 packages
$ echo "Hello $USER"
Hello john
# docker ps -a
CONTAINER ID   IMAGE   STATUS
TXT,
            <<<'TXT'
<span class="hl-comment">$</span> <span class="hl-keyword">npm</span> install <span class="hl-generic">--save</span> express
added <span class="hl-number">57</span> packages
<span class="hl-comment">$</span> <span class="hl-keyword">echo</span> <span class="hl-value">&quot;Hello $USER&quot;</span>
Hello john
<span class="hl-comment">#</span> <span class="hl-keyword">docker</span> ps <span class="hl-generic">-a</span>
CONTAINER ID   IMAGE   STATUS
TXT],

            [<<<'TXT'
$ curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
$ pm2 start app.js --log /var/log/my-app.log
$ npm init @eslint/config
$ npx eslint --output-file errors.txt app/index.js
$ npx husky add .husky/pre-commit 'echo "Hello World!"'
$ brew install hashicorp/tap/terraform
TXT,
            <<<'TXT'
<span class="hl-comment">$</span> <span class="hl-keyword">curl</span> <span class="hl-generic">-OL</span> <span class="hl-value">https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar</span>
<span class="hl-comment">$</span> <span class="hl-keyword">pm2</span> start <span class="hl-property">app.js</span> <span class="hl-generic">--log</span> <span class="hl-property">/var/log/my-app.log</span>
<span class="hl-comment">$</span> <span class="hl-keyword">npm</span> init <span class="hl-property">@eslint/config</span>
<span class="hl-comment">$</span> <span class="hl-keyword">npx</span> eslint <span class="hl-generic">--output-file</span> <span class="hl-property">errors.txt</span> <span class="hl-property">app/index.js</span>
<span class="hl-comment">$</span> <span class="hl-keyword">npx</span> husky add <span class="hl-property">.husky/pre-commit</span> <span class="hl-value">'echo &quot;Hello World!&quot;'</span>
<span class="hl-comment">$</span> <span class="hl-keyword">brew</span> install <span class="hl-property">hashicorp/tap/terraform</span>
TXT],

            [<<<'TXT'
$ npx husky-init && npm install
$ echo "hello" || echo "fallback"
$ mkdir build; cd build
TXT,
            <<<'TXT'
<span class="hl-comment">$</span> <span class="hl-keyword">npx</span> husky<span class="hl-generic">-init</span> <span class="hl-operator">&amp;&amp;</span> <span class="hl-keyword">npm</span> install
<span class="hl-comment">$</span> <span class="hl-keyword">echo</span> <span class="hl-value">&quot;hello&quot;</span> <span class="hl-operator">||</span> <span class="hl-keyword">echo</span> <span class="hl-value">&quot;fallback&quot;</span>
<span class="hl-comment">$</span> <span class="hl-keyword">mkdir</span> build<span class="hl-operator">;</span> <span class="hl-keyword">cd</span> build
TXT],
        ];
    }
}
