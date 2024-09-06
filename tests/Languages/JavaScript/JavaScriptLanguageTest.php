<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\JavaScript;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class JavaScriptLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'js'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'javascript'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'node'),
        );
    }

    public static function data(): array
    {
        return [
            [<<<'TXT'
/**
 * Class making something fun and easy.
 * @param {string} arg1 An argument that makes this more interesting.
 * @param {Array.<number>} arg2 List of numbers to be processed.
 * @constructor
 */
function someMethod(obj) {
    // ...

qq.DeleteFileAjaxRequester = function(o) {
    "use strict";

    var requester,
        options = {
            method: "DELETE",
            uuidParamName: "qquuid",
            endpointStore: {},
            maxConnections: 3,
            customHeaders: function(id) {return {};},
            paramsStore: {},
            cors: {
                expected: false,
                sendCredentials: false
            },
            log: function(str, level) {},
            onDelete: function(id) {},
            onDeleteComplete: function(id, xhrOrXdr, isError) {}
        };

    qq.extend(options, o);

    function getMandatedParams() {
        if (options.method.toUpperCase() === "POST") {
            return {
                _method: "DELETE"
            };
        }

        return {};
    }

    requester = qq.extend(this, new qq.AjaxRequester({
        acceptHeader: "application/json",
        validMethods: ["POST", "DELETE"],
        method: options.method,
        endpointStore: options.endpointStore,
        paramsStore: options.paramsStore,
        mandatedParams: getMandatedParams(),
        maxConnections: options.maxConnections,
        customHeaders: function(id) {
            return options.customHeaders.get(id);
        },
        log: options.log,
        onSend: options.onDelete,
        onComplete: options.onDeleteComplete,
        cors: options.cors
    }));

    qq.extend(this, {
        sendDelete: function(id, uuid, additionalMandatedParams) {
            var additionalOptions = additionalMandatedParams || {};

            options.log("Submitting delete file request for " + id);

            if (options.method === "DELETE") {
                requester.initTransport(id)
                    .withPath(uuid)
                    .withParams(additionalOptions)
                    .send();
            }
            else {
                additionalOptions[options.uuidParamName] = uuid;
                requester.initTransport(id)
                    .withParams(additionalOptions)
                    .send();
            }
        }
    });
};
TXT,
                <<<'TXT'
<span class="hl-comment">/**
 * Class making something fun and easy.
 * <span class="hl-value">@param</span> <span class="hl-type">{string}</span> <span class="hl-value">arg1</span> An argument that makes this more interesting.
 * <span class="hl-value">@param</span> <span class="hl-type">{Array.&lt;number&gt;}</span> <span class="hl-value">arg2</span> List of numbers to be processed.
 * <span class="hl-value">@constructor</span>
 */</span>
<span class="hl-keyword">function</span> <span class="hl-property">someMethod</span>(obj) {
    <span class="hl-comment">// ...</span>

qq.<span class="hl-property">DeleteFileAjaxRequester</span> = <span class="hl-keyword">function</span>(o) {
    <span class="hl-value">&quot;use strict&quot;</span>;

    <span class="hl-keyword">var</span> requester,
        options = {
            <span class="hl-property">method</span>: <span class="hl-value">&quot;DELETE&quot;</span>,
            <span class="hl-property">uuidParamName</span>: <span class="hl-value">&quot;qquuid&quot;</span>,
            <span class="hl-property">endpointStore</span>: {},
            <span class="hl-property">maxConnections</span>: 3,
            <span class="hl-property">customHeaders</span>: <span class="hl-keyword">function</span>(id) {<span class="hl-keyword">return</span> {};},
            <span class="hl-property">paramsStore</span>: {},
            <span class="hl-property">cors</span>: {
                <span class="hl-property">expected</span>: <span class="hl-keyword">false</span>,
                <span class="hl-property">sendCredentials</span>: <span class="hl-keyword">false</span>
            },
            <span class="hl-property">log</span>: <span class="hl-keyword">function</span>(str, level) {},
            <span class="hl-property">onDelete</span>: <span class="hl-keyword">function</span>(id) {},
            <span class="hl-property">onDeleteComplete</span>: <span class="hl-keyword">function</span>(id, xhrOrXdr, isError) {}
        };

    qq.<span class="hl-property">extend</span>(options, o);

    <span class="hl-keyword">function</span> <span class="hl-property">getMandatedParams</span>() {
        <span class="hl-keyword">if</span> (options.<span class="hl-property">method</span>.<span class="hl-property">toUpperCase</span>() === <span class="hl-value">&quot;POST&quot;</span>) {
            <span class="hl-keyword">return</span> {
                <span class="hl-property">_method</span>: <span class="hl-value">&quot;DELETE&quot;</span>
            };
        }

        <span class="hl-keyword">return</span> {};
    }

    requester = qq.<span class="hl-property">extend</span>(<span class="hl-keyword">this</span>, <span class="hl-keyword">new</span> qq.<span class="hl-type">AjaxRequester</span>({
        <span class="hl-property">acceptHeader</span>: <span class="hl-value">&quot;application/json&quot;</span>,
        <span class="hl-property">validMethods</span>: [<span class="hl-value">&quot;POST&quot;</span>, <span class="hl-value">&quot;DELETE&quot;</span>],
        <span class="hl-property">method</span>: options.<span class="hl-property">method</span>,
        <span class="hl-property">endpointStore</span>: options.<span class="hl-property">endpointStore</span>,
        <span class="hl-property">paramsStore</span>: options.<span class="hl-property">paramsStore</span>,
        <span class="hl-property">mandatedParams</span>: <span class="hl-property">getMandatedParams</span>(),
        <span class="hl-property">maxConnections</span>: options.<span class="hl-property">maxConnections</span>,
        <span class="hl-property">customHeaders</span>: <span class="hl-keyword">function</span>(id) {
            <span class="hl-keyword">return</span> options.<span class="hl-property">customHeaders</span>.<span class="hl-property">get</span>(id);
        },
        <span class="hl-property">log</span>: options.<span class="hl-property">log</span>,
        <span class="hl-property">onSend</span>: options.<span class="hl-property">onDelete</span>,
        <span class="hl-property">onComplete</span>: options.<span class="hl-property">onDeleteComplete</span>,
        <span class="hl-property">cors</span>: options.<span class="hl-property">cors</span>
    }));

    qq.<span class="hl-property">extend</span>(<span class="hl-keyword">this</span>, {
        <span class="hl-property">sendDelete</span>: <span class="hl-keyword">function</span>(id, uuid, additionalMandatedParams) {
            <span class="hl-keyword">var</span> additionalOptions = additionalMandatedParams || {};

            options.<span class="hl-property">log</span>(<span class="hl-value">&quot;Submitting delete file request for &quot;</span> + id);

            <span class="hl-keyword">if</span> (options.<span class="hl-property">method</span> === <span class="hl-value">&quot;DELETE&quot;</span>) {
                requester.<span class="hl-property">initTransport</span>(id)
                    .<span class="hl-property">withPath</span>(uuid)
                    .<span class="hl-property">withParams</span>(additionalOptions)
                    .<span class="hl-property">send</span>();
            }
            <span class="hl-keyword">else</span> {
                additionalOptions[options.<span class="hl-property">uuidParamName</span>] = uuid;
                requester.<span class="hl-property">initTransport</span>(id)
                    .<span class="hl-property">withParams</span>(additionalOptions)
                    .<span class="hl-property">send</span>();
            }
        }
    });
};
TXT],
            [
                <<<'TXT'
class Point {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }

  static displayName = "Point";
  static distance(a, b) {
    const dx = a.x - b.x;
    const dy = a.y - b.y;

    return Math.hypot(dx, dy);
  }
}

const p1 = new Point(5, 5);
const p2 = new Point(10, 10);
p1.displayName; // undefined
p1.distance; // undefined
p2.displayName; // undefined
p2.distance; // undefined

console.log(Point.displayName); // "Point"
console.log(Point.distance(p1, p2)); // 7.0710678118654755
TXT,
                <<<'TXT'
<span class="hl-keyword">class</span> <span class="hl-type">Point</span> {
  <span class="hl-keyword">constructor</span>(x, y) {
    <span class="hl-keyword">this</span>.<span class="hl-property">x</span> = x;
    <span class="hl-keyword">this</span>.<span class="hl-property">y</span> = y;
  }

  <span class="hl-keyword">static</span> <span class="hl-property">displayName</span> = <span class="hl-value">&quot;Point&quot;</span>;
  <span class="hl-keyword">static</span> <span class="hl-property">distance</span>(a, b) {
    <span class="hl-keyword">const</span> dx = a.<span class="hl-property">x</span> - b.<span class="hl-property">x</span>;
    <span class="hl-keyword">const</span> dy = a.<span class="hl-property">y</span> - b.<span class="hl-property">y</span>;

    <span class="hl-keyword">return</span> <span class="hl-type">Math</span>.<span class="hl-property">hypot</span>(dx, dy);
  }
}

<span class="hl-keyword">const</span> p1 = <span class="hl-keyword">new</span> <span class="hl-type">Point</span>(5, 5);
<span class="hl-keyword">const</span> p2 = <span class="hl-keyword">new</span> <span class="hl-type">Point</span>(10, 10);
p1.<span class="hl-property">displayName</span>; <span class="hl-comment">// undefined</span>
p1.<span class="hl-property">distance</span>; <span class="hl-comment">// undefined</span>
p2.<span class="hl-property">displayName</span>; <span class="hl-comment">// undefined</span>
p2.<span class="hl-property">distance</span>; <span class="hl-comment">// undefined</span>

console.<span class="hl-property">log</span>(<span class="hl-type">Point</span>.<span class="hl-property">displayName</span>); <span class="hl-comment">// &quot;Point&quot;</span>
console.<span class="hl-property">log</span>(<span class="hl-type">Point</span>.<span class="hl-property">distance</span>(p1, p2)); <span class="hl-comment">// 7.0710678118654755</span>
TXT
            ],
        ];
    }
}
