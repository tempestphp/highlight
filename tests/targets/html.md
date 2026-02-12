```html
<!DOCTYPE html>
<html lang=en>
<head>
  <meta charset=UTF-8>
  <!-- Standard comment -->
  <!---->
  <!-- -- nested dashes -- are tricky -->
  <!--> this is NOT a comment in some parsers -->
  <!----> <!-- empty with extra dash -->

  <title>Quotes &amp; "escapes" &lt;in&gt; title</title>

  <!-- Unquoted, single-quoted, double-quoted, empty attributes -->
  <meta name=description content='Single "quoted" value'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv=X-UA-Compatible content=IE=edge>
  <meta name=empty-value content="">
  <meta name=no-value content>

  <!-- Boolean & valueless attributes -->
  <script defer async crossorigin></script>

  <style>
    /* CSS with HTML-like content that should NOT be parsed as HTML */
    .a::before { content: "<div>not a tag</div>"; }
    .b::after { content: '</script>'; }
    .c { --d: "<!-- not a comment -->"; }
    [data-x="<b>bold</b>"] { color: red; }
  </style>
</head>

<!-- Optional body tag omission — body is implicit here -->

  <!-- Void elements: no closing tag, with and without self-closing slash -->
  <br>
  <br/>
  <br />
  <hr>
  <hr/>
  <img src=x.png alt=photo width=100 height=100>
  <img src="x.png" alt="" />
  <input type=text value=unquoted>
  <input type="text" value="quoted" />
  <link rel=icon href=favicon.ico>
  <meta name=test content=value>
  <wbr>
  <col>
  <embed src=x type=text/plain>
  <source srcset=x.webp>
  <track src=t.vtt default>

  <!-- Optional closing tags — these are all valid -->
  <p>Paragraph one
  <p>Paragraph two — the first &lt;p&gt; auto-closes
  <p>Third with <em>inline</em> that <strong>doesn't break</p>

  <ul>
    <li>Item 1
    <li>Item 2
    <li>Item 3 with <a href=#>link</a>
  </ul>

  <dl>
    <dt>Term
    <dd>Definition
    <dt>Another
    <dd>Def 2
  </dl>

  <table>
    <tr><td>A<td>B
    <tr><td>C<td>D
  </table>

  <select>
    <option>One
    <option selected>Two
    <option>Three
  </select>

  <!-- Raw text elements: content is NOT parsed as HTML -->
  <script>
    // These should NOT trigger tag highlighting:
    var x = "<div class='foo'>bar</div>";
    var y = '</script' + '>';
    if (1 < 2 && 3 > 1) { console.log("<b>not bold</b>"); }
    var tpl = `<template><slot name="x"></slot></template>`;
  </script>

  <script type=text/plain>
    This <b>bold tag</b> should be treated as raw text, not HTML.
  </script>

  <textarea>
    <div>This is raw text in textarea</div>
    <script>alert("not executed")</script>
    &amp; but this entity IS parsed in textarea
  </textarea>

  <!-- Escaped & unescaped entities -->
  <p>&amp; &lt; &gt; &quot; &apos; &#169; &#x00A9; &#xA9; &copy;</p>
  <p>Bare & ampersand, and 3 < 5 > 2 technically invalid but tolerated</p>
  <p>&nonexistent; entity — parser should handle gracefully</p>
  <p>Numeric edge: &#0; &#x0; &#999999;</p>

  <!-- Attribute edge cases -->
  <div id=no-quotes class="double quotes" title='single quotes' hidden>Mixed quoting</div>
  <div data-json='{"key":"value","arr":[1,2]}'>JSON in single-quoted attr</div>
  <div data-json="{&quot;key&quot;:&quot;val&quot;}">JSON in double-quoted with entities</div>
  <div data-empty="" data-bool data-unquoted=hello data-trailing-space="val " data-equals=a=b=c>Attr soup</div>
  <div data-newline="line1
line2">Newline in attribute value</div>
  <div data-single-in-double="it's fine" data-double-in-single='say "hello"'>Nested quotes</div>
  <input disabled readonly checked required autofocus multiple>
  <div CLASS=upper ID=mixed Data-Custom=yes>Case insensitive attrs</div>

  <!-- SVG with namespaces -->
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" width=100 height=100>
    <defs>
      <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="red" />
        <stop offset="100%" stop-color="blue" />
      </linearGradient>
      <clipPath id="cp"><circle cx=50 cy=50 r=40 /></clipPath>
      <filter id="blur"><feGaussianBlur stdDeviation="2" /></filter>
    </defs>
    <g clip-path="url(#cp)" filter="url(#blur)">
      <rect x=0 y=0 width=100 height=100 fill="url(#g1)" />
      <foreignObject x=10 y=10 width=80 height=80>
        <div xmlns="http://www.w3.org/1999/xhtml">
          <p style="color:white">HTML inside SVG foreignObject</p>
        </div>
      </foreignObject>
    </g>
    <text x=50 y=95 text-anchor="middle" font-size=8>Text</text>
    <use xlink:href="#cp" />
    <a xlink:href="https://example.com"><text x=50 y=50>Link</text></a>
    <!-- SVG comment -->
    <image href="img.png" x=0 y=0 width=10 height=10 />
    <switch>
      <text systemLanguage="fr">Bonjour</text>
      <text>Hello</text>
    </switch>
    <style>circle { stroke: black; stroke-width: 1; }</style>
    <script>/* JS inside SVG */</script>
  </svg>

  <!-- MathML with namespaces -->
  <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
    <mrow>
      <munderover>
        <mo>&sum;</mo>
        <mrow><mi>i</mi><mo>=</mo><mn>0</mn></mrow>
        <mi>&infin;</mi>
      </munderover>
      <mfrac>
        <msup><mi>x</mi><mi>i</mi></msup>
        <mrow><mi>i</mi><mo>!</mo></mrow>
      </mfrac>
      <mo>=</mo>
      <msup><mi>e</mi><mi>x</mi></msup>
    </mrow>
    <annotation encoding="application/x-tex">\\sum_{i=0}^{\\infty} \\frac{x^i}{i!} = e^x</annotation>
  </math>

  <!-- Nested context switches -->
  <div>
    HTML context
    <svg viewBox="0 0 10 10">
      <!-- SVG context -->
      <foreignObject width=10 height=10>
        <!-- Back to HTML context -->
        <div xmlns="http://www.w3.org/1999/xhtml">
          <math xmlns="http://www.w3.org/1998/Math/MathML">
            <!-- MathML context inside HTML inside SVG -->
            <mi>x</mi>
          </math>
        </div>
      </foreignObject>
    </svg>
    Back to HTML
  </div>

  <!-- CDATA section (only valid in SVG/MathML/XML, ignored or error in HTML) -->
  <svg><script><![CDATA[
    if (1 < 2 && 3 > 1) { /* valid JS without escaping inside CDATA */ }
  ]]></script></svg>

  <!-- Custom elements & data attributes -->
  <my-component data-x=1 data-y="2" is="enhanced-div">
    <span slot=title>Slotted</span>
    <template shadowrootmode=open>
      <style>:host { display: block; }</style>
      <slot name=title></slot>
      <slot></slot>
    </template>
  </my-component>
  <x-kebab-case></x-kebab-case>

  <!-- Deeply nested -->
  <div><div><div><div><div><div><div><div><span>8 levels</span></div></div></div></div></div></div></div></div>

  <!-- Whitespace & formatting edge cases -->
  <p    id = "spaced"   class   =   spaced  >Extra spaces in attributes</p>
  <div
    id="multiline-attrs"
    class="a b c"
    style="
      color: red;
      background: blue;
    "
    data-long="This attribute value
    spans multiple lines"
  >Multiline attribute formatting</div>

  <!-- Tag name edge cases -->
  <DIV>Uppercase tag</DIV>
  <DiV>Mixed case tag</DiV>
  <h1>h1</h1><h2>h2</h2><h3>h3</h3><h4>h4</h4><h5>h5</h5><h6>h6</h6>

  <!-- Adjacent raw text elements -->
  <script>/* script 1 */</script><script>/* script 2 */</script>
  <style>.a{}</style><style>.b{}</style>

  <!-- Tricky closing tag sequences in raw text -->
  <script>var s = "</ script>"; /* space breaks the close tag match */</script>
  <script>var s = "<script>nested<\/script>"; /* escaped slash */</script>

  <!-- Ambiguous less-than signs -->
  <p>Is 5<10? And what about <b>bold</b> after?</p>
  <p>Bare angle < and > in text</p>

  <!-- dialog, popover, details — interactive -->
  <details open name=grp>
    <summary>Open by default</summary>
    <details>
      <summary>Nested details</summary>
      <p>Deeply nested</p>
    </details>
  </details>

  <dialog open id=d>
    <form method=dialog>
      <button value=ok formnovalidate>OK</button>
    </form>
  </dialog>

  <div popover=auto id=pop>Popover</div>
  <button popovertarget=pop popovertargetaction=toggle>Toggle</button>

  <!-- Empty elements & fragments -->
  <div></div>
  <span></span>
  <p></p>
  <div><!-- only a comment inside --></div>
  <div>   </div><!-- whitespace only -->

  <!-- Obsolete but parseable -->
  <center>Obsolete center</center>
  <font color=red size=3 face=serif>Obsolete font</font>
  <marquee>Obsolete marquee</marquee>
  <blink>Obsolete blink</blink>
  <xmp>Obsolete <b>xmp</b> — raw text</xmp>

  <!-- Multiple doctypes / stray tags (error recovery) -->
  </p><!-- stray end tag -->
  </br><!-- parsed as <br> by spec -->
  </ invalid><!-- not a valid tag -->

  <!-- Processing instruction (XML-style, treated as comment in HTML) -->
  <?xml version="1.0"?>

  <script type=module>
    import("./mod.js").then(m => m.default?.());
    const html = `<div class="${"dyn"}">template literal with angle brackets < > & entities</div>`;
  </script>

  <script type=application/ld+json>
    {
      "@context": "https://schema.org",
      "@type": "Thing",
      "name": "Test</script not actually closing>",
      "description": "<b>Not bold</b>"
    }
  </script>

  <noscript>
    <link rel=stylesheet href=fallback.css>
    <meta http-equiv=refresh content="0; url=/nojs">
  </noscript>

<!-- Implicit body and html closing tags omitted intentionally -->
```