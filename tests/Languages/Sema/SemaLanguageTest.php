<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Sema;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class SemaLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'sema'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            'comment' => ['; budgets', '<span class="hl-comment">; budgets</span>'],
            'shebang' => [
                <<<'SEMA'
                #!/usr/bin/env sema
                1
                SEMA,
                <<<'HTML'
                <span class="hl-comment">#!/usr/bin/env sema</span>
                <span class="hl-number">1</span>
                HTML,
            ],
            'string' => ['"Oslo"', '<span class="hl-value">&quot;Oslo&quot;</span>'],
            'regex literal' => ['#"^[a-z]{5}$"', '<span class="hl-value">#&quot;^[a-z]{5}$&quot;</span>'],
            'f-string' => ['f"hi ${name}"', '<span class="hl-value">f&quot;hi ${name}&quot;</span>'],
            'f-string holding strings and maps' => ['f"${(greet {:name "World"})}!"', '<span class="hl-value">f&quot;${(greet {:name &quot;World&quot;})}!&quot;</span>'],
            'character' => ['#\\space', '<span class="hl-value">#\\space</span>'],
            'quote character' => ['#\\"', '<span class="hl-value">#\\&quot;</span>'],
            'unknown character name' => ['#\\alarm', '#\\alarm'],
            'special form' => ['(lambda (x) x)', '(<span class="hl-keyword">lambda</span> (<span class="hl-variable">x</span>) x)'],
            'namespaced special form' => ['(term/with-mouse (draw))', '(<span class="hl-keyword">term/with-mouse</span> (<span class="hl-property">draw</span>))'],
            'threading macro' => ['(->> xs)', '(<span class="hl-keyword">-&gt;&gt;</span> xs)'],
            'defined name' => ['(defagent guide)', '(<span class="hl-keyword">defagent</span> <span class="hl-type">guide</span>)'],
            'defined function' => ['(define (greet name))', '(<span class="hl-keyword">define</span> (<span class="hl-type">greet</span> <span class="hl-variable">name</span>))'],
            'namespaced defined function' => ['(define (gen/int lo))', '(<span class="hl-keyword">define</span> (<span class="hl-type">gen/int</span> <span class="hl-variable">lo</span>))'],
            'redefined form' => ['(defmacro unless)', '(<span class="hl-keyword">defmacro</span> <span class="hl-type">unless</span>)'],
            'keyword' => ['{:max-turns 3}', '{<span class="hl-literal">:max-turns</span> <span class="hl-number">3</span>}'],
            'keywords back to back' => [':a:b', '<span class="hl-literal">:a</span><span class="hl-literal">:b</span>'],
            'map' => ['{:name "World" :age 3}', '{<span class="hl-literal">:name</span> <span class="hl-value">&quot;World&quot;</span> <span class="hl-literal">:age</span> <span class="hl-number">3</span>}'],
            'literals' => ['[#t #f nil]', '[<span class="hl-literal">#t</span> <span class="hl-literal">#f</span> <span class="hl-literal">nil</span>]'],
            'numbers' => ['[-1.5e3 1/2 #xFF]', '[<span class="hl-number">-1.5e3</span> <span class="hl-number">1/2</span> <span class="hl-number">#xFF</span>]'],
            'complex and prefixed numbers' => ['[3+4i +i #e1.5 #x-ff #e#xFF +inf]', '[<span class="hl-number">3+4i</span> <span class="hl-number">+i</span> <span class="hl-number">#e1.5</span> <span class="hl-number">#x-ff</span> <span class="hl-number">#e#xFF</span> <span class="hl-number">+inf</span>]'],
            'namespaced call' => ['(llm/complete p)', '(<span class="hl-property">llm/complete</span> p)'],
            'lambda arguments' => ['#(* % %2 %&)', '#(<span class="hl-operator">*</span> <span class="hl-variable">%</span> <span class="hl-variable">%2</span> <span class="hl-variable">%&amp;</span>)'],
            'unicode symbols' => ['(:λ m)', '(<span class="hl-literal">:λ</span> m)'],
            'whole atoms only' => ['(if-let x diff nil? 1st)', '(<span class="hl-keyword">if-let</span> x diff nil? 1st)'],
            'quoted symbols' => ["(list 'if 'async)", '(<span class="hl-property">list</span> \'if \'async)'],
            'semicolon in a string' => ['(display "a;b") ; done', '(<span class="hl-property">display</span> <span class="hl-value">&quot;a;b&quot;</span>) <span class="hl-comment">; done</span>'],
            'quote in a comment' => [
                <<<'SEMA'
                ; say "hi
                (f "x")
                SEMA,
                <<<'HTML'
                <span class="hl-comment">; say &quot;hi</span>
                (<span class="hl-property">f</span> <span class="hl-value">&quot;x&quot;</span>)
                HTML,
            ],
            'quote character before a string' => ['(= c #\\") (f "x")', '(<span class="hl-operator">=</span> c <span class="hl-value">#\\&quot;</span>) (<span class="hl-property">f</span> <span class="hl-value">&quot;x&quot;</span>)'],
            'string across lines' => [
                <<<'SEMA'
                (f "one;
                two")
                ; done
                SEMA,
                <<<'HTML'
                (<span class="hl-property">f</span> <span class="hl-value">&quot;one;
                two&quot;</span>)
                <span class="hl-comment">; done</span>
                HTML,
            ],
            'addition markup' => [
                <<<'SEMA'
                (define x 1)
                {+(define y 2)+}
                SEMA,
                <<<'HTML'
                (<span class="hl-keyword">define</span> <span class="hl-variable">x</span> <span class="hl-number">1</span>)
                <span class="hl-addition">(<span class="hl-keyword">define</span> <span class="hl-variable">y</span> <span class="hl-number">2</span>)</span>
                HTML,
            ],
            'builtin call' => ['(println "hi" (string/append a b))', '(<span class="hl-property">println</span> <span class="hl-value">&quot;hi&quot;</span> (<span class="hl-property">string/append</span> a b))'],
            'user function call' => ['(ask city)', '(<span class="hl-property">ask</span> city)'],
            'operators in call position' => ['(+ 1 (* 2 3) (>= a b))', '(<span class="hl-operator">+</span> <span class="hl-number">1</span> (<span class="hl-operator">*</span> <span class="hl-number">2</span> <span class="hl-number">3</span>) (<span class="hl-operator">&gt;=</span> a b))'],
            'operators as arguments' => ['(reduce + 0 xs)', '(<span class="hl-property">reduce</span> + <span class="hl-number">0</span> xs)'],
            'prelude macro' => ['(step "fetch" (http/get url))', '(<span class="hl-keyword">step</span> <span class="hl-value">&quot;fetch&quot;</span> (<span class="hl-property">http/get</span> url))'],
            'prelude macro name as an argument' => ['(+ step 1)', '(<span class="hl-operator">+</span> step <span class="hl-number">1</span>)'],
            'defined variable' => ['(define cities (list "Oslo"))', '(<span class="hl-keyword">define</span> <span class="hl-variable">cities</span> (<span class="hl-property">list</span> <span class="hl-value">&quot;Oslo&quot;</span>))'],
            'set!' => ['(set! count (+ count 1))', '(<span class="hl-keyword">set!</span> <span class="hl-variable">count</span> (<span class="hl-operator">+</span> count <span class="hl-number">1</span>))'],
            'lambda parameters' => ['(lambda (x y) (+ x y))', '(<span class="hl-keyword">lambda</span> (<span class="hl-variable">x</span> <span class="hl-variable">y</span>) (<span class="hl-operator">+</span> x y))'],
            'let bindings' => ['(let ((a (f 1)) (b "(")) (g a b))', '(<span class="hl-keyword">let</span> ((<span class="hl-variable">a</span> (<span class="hl-property">f</span> <span class="hl-number">1</span>)) (<span class="hl-variable">b</span> <span class="hl-value">&quot;(&quot;</span>)) (<span class="hl-property">g</span> a b))'],
            'not a call' => ['(1 2 3)', '(<span class="hl-number">1</span> <span class="hl-number">2</span> <span class="hl-number">3</span>)'],
            'vector' => ['[a b]', '[a b]'],
            'quoted list' => ["'(a b)", "'(a b)"],
            'named let' => ['(let loop ((i 0)) (loop (+ i 1)))', '(<span class="hl-keyword">let</span> loop ((<span class="hl-variable">i</span> <span class="hl-number">0</span>)) (<span class="hl-property">loop</span> (<span class="hl-operator">+</span> i <span class="hl-number">1</span>)))'],
            'function parameters' => ['(defn fib "Fibonacci." (n) (fib (- n 1)))', '(<span class="hl-keyword">defn</span> <span class="hl-type">fib</span> <span class="hl-value">&quot;Fibonacci.&quot;</span> (<span class="hl-variable">n</span>) (<span class="hl-property">fib</span> (<span class="hl-operator">-</span> n <span class="hl-number">1</span>)))'],
            'cond clauses' => ['(cond ((> x 1) "big") (else "small"))', '(<span class="hl-keyword">cond</span> ((<span class="hl-operator">&gt;</span> x <span class="hl-number">1</span>) <span class="hl-value">&quot;big&quot;</span>) (<span class="hl-keyword">else</span> <span class="hl-value">&quot;small&quot;</span>))'],
            'binding named like a special form' => ['(let ((message "hi")) message)', '(<span class="hl-keyword">let</span> ((<span class="hl-variable">message</span> <span class="hl-value">&quot;hi&quot;</span>)) message)'],
            'parameters named like special forms' => ['(define (reply message prompt) (llm/complete prompt message))', '(<span class="hl-keyword">define</span> (<span class="hl-type">reply</span> <span class="hl-variable">message</span> <span class="hl-variable">prompt</span>) (<span class="hl-property">llm/complete</span> prompt message))'],
            'vector parameters' => ['(fn [a b] (+ a b))', '(<span class="hl-keyword">fn</span> [<span class="hl-variable">a</span> <span class="hl-variable">b</span>] (<span class="hl-operator">+</span> a b))'],
            'destructuring binding' => ['(let (([a b] (list 1 2))) b)', '(<span class="hl-keyword">let</span> (([<span class="hl-variable">a</span> <span class="hl-variable">b</span>] (<span class="hl-property">list</span> <span class="hl-number">1</span> <span class="hl-number">2</span>))) b)'],
            'single binding forms' => ['(dotimes (i 3) (when-let (x (f i)) x))', '(<span class="hl-keyword">dotimes</span> (<span class="hl-variable">i</span> <span class="hl-number">3</span>) (<span class="hl-keyword">when-let</span> (<span class="hl-variable">x</span> (<span class="hl-property">f</span> i)) x))'],
            'dotted rest parameter' => ['(defmacro m (. body) body)', '(<span class="hl-keyword">defmacro</span> <span class="hl-type">m</span> (. <span class="hl-variable">body</span>) body)'],
            'symbol ending at a keyword' => ['(foo:bar x)', '(<span class="hl-property">foo</span><span class="hl-literal">:bar</span> x)'],
            'number ending at a reader construct' => ['(f 123#(+ % 1))', '(<span class="hl-property">f</span> <span class="hl-number">123</span>#(<span class="hl-operator">+</span> <span class="hl-variable">%</span> <span class="hl-number">1</span>))'],
            'infinity spellings' => ['[inf -inf +Infinity -Inf]', '[<span class="hl-number">inf</span> <span class="hl-number">-inf</span> <span class="hl-number">+Infinity</span> -Inf]'],
            'i64 array' => ['#i64(-1 2)', '#i64(<span class="hl-number">-1</span> <span class="hl-number">2</span>)'],
            'character before a symbol' => ['#\\;x', '<span class="hl-value">#\\;</span>x'],
            'symbol ending in f before a string' => ['(str/f"x")', '(<span class="hl-property">str/f</span><span class="hl-value">&quot;x&quot;</span>)'],
            'unterminated string' => ['(f "unterminated', '(<span class="hl-property">f</span> <span class="hl-value">&quot;unterminated</span>'],
            'agent' => [
                <<<'SEMA'
                (deftool lookup
                  "Look up a fact about a city."
                  {:city {:type :string}}
                  (lambda (city)
                    (string/append "Facts about " city)))

                (defagent guide {:tools [lookup] :max-turns 3})

                (define (ask city)
                  (llm/with-budget {:max-cost-usd 0.05}
                    (fn ()
                      (let ((answer (agent/run guide f"Tell me about ${city}")))
                        (if (string? answer) answer (throw "no answer"))))))
                SEMA,
                <<<'HTML'
                (<span class="hl-keyword">deftool</span> <span class="hl-type">lookup</span>
                  <span class="hl-value">&quot;Look up a fact about a city.&quot;</span>
                  {<span class="hl-literal">:city</span> {<span class="hl-literal">:type</span> <span class="hl-literal">:string</span>}}
                  (<span class="hl-keyword">lambda</span> (<span class="hl-variable">city</span>)
                    (<span class="hl-property">string/append</span> <span class="hl-value">&quot;Facts about &quot;</span> city)))

                (<span class="hl-keyword">defagent</span> <span class="hl-type">guide</span> {<span class="hl-literal">:tools</span> [lookup] <span class="hl-literal">:max-turns</span> <span class="hl-number">3</span>})

                (<span class="hl-keyword">define</span> (<span class="hl-type">ask</span> <span class="hl-variable">city</span>)
                  (<span class="hl-property">llm/with-budget</span> {<span class="hl-literal">:max-cost-usd</span> <span class="hl-number">0.05</span>}
                    (<span class="hl-keyword">fn</span> ()
                      (<span class="hl-keyword">let</span> ((<span class="hl-variable">answer</span> (<span class="hl-property">agent/run</span> guide <span class="hl-value">f&quot;Tell me about ${city}&quot;</span>)))
                        (<span class="hl-keyword">if</span> (<span class="hl-property">string?</span> answer) answer (<span class="hl-keyword">throw</span> <span class="hl-value">&quot;no answer&quot;</span>))))))
                HTML,
            ],
        ];
    }
}
