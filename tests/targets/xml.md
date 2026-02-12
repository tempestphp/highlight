```xml
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<?xml-stylesheet type="text/xsl" href="transform.xsl"?>
<?custom-pi target data="value" arbitrary content here ?>
<?pi?>

<!DOCTYPE root [
  <!ELEMENT root ANY>
  <!ELEMENT item (#PCDATA|sub)*>
  <!ELEMENT sub EMPTY>
  <!ELEMENT container (item+)>
  <!ATTLIST item
    id    ID      #REQUIRED
    ref   IDREF   #IMPLIED
    type  (a|b|c) "a"
    flag  CDATA   #FIXED "on"
    xml:lang CDATA #IMPLIED
  >
  <!ENTITY copy "&#169;">
  <!ENTITY logo SYSTEM "logo.png" NDATA png>
  <!ENTITY % shared "<!ELEMENT shared (#PCDATA)>">
  %shared;
  <!ENTITY recursive "&copy; nested">
  <!ENTITY lt "&#60;">
  <!ENTITY xml-in-entity "<inner attr='val'>text</inner>">
  <!NOTATION png SYSTEM "image/png">
  <!-- Comment inside DTD -->
]>

<!-- Comment outside root -->
<!-- Double -- dashes -- in comment (invalid but common) -->
<!----> <!-- Minimal comment -->

<root
  xmlns="http://example.com/default"
  xmlns:a="http://example.com/ns-a"
  xmlns:b="http://example.com/ns-b"
  xmlns:xml="http://www.w3.org/XML/1998/namespace"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://example.com/default schema.xsd"
  xml:lang="en"
  xml:space="preserve"
  xml:base="https://example.com/"
  xml:id="root-element"
>

  <!-- Namespace prefixes and default namespace -->
  <a:element a:attr="namespaced-attr" b:other="cross-namespace">
    <b:nested xmlns:c="http://example.com/ns-c" c:deep="yes">
      <c:leaf/>
    </b:nested>
  </a:element>

  <!-- Default namespace override and undeclaration -->
  <container xmlns="http://example.com/override">
    <item xmlns="">Back to no namespace</item>
    <item xmlns="http://example.com/default">Back to original</item>
  </container>

  <!-- Same prefix, different namespace (rebinding) -->
  <a:element xmlns:a="http://example.com/rebound">
    <a:child>Prefix 'a' now means something else</a:child>
  </a:element>

  <!-- CDATA sections -->
  <![CDATA[Raw text with <tags> & "quotes" & 'apostrophes' that aren't parsed]]>
  <item id="cdata-tests">
    <![CDATA[]]><!-- Empty CDATA -->
    <![CDATA[Ends with ]]><!-- ]]> split across boundary -->
    <![CDATA[Contains ] and ]] but not ]]]><!-- near-miss endings -->
    <![CDATA[
      function() { if (a < b && c > d) return "<xml>"; }
      Multiline CDATA with <every> &possible; "gotcha"
    ]]>
  </item>

  <!-- Entity references -->
  <item id="entities">
    &lt; &gt; &amp; &quot; &apos;
    &#169; &#x00A9; &#xA9; &#xa9;
    &#9; &#10; &#13;<!-- tab, LF, CR -->
    &#x20; &#32;<!-- space as entity -->
    &copy; &recursive;<!-- custom DTD entities -->
    &xml-in-entity;<!-- entity containing markup -->
  </item>

  <!-- Whitespace handling -->
  <item id="whitespace" xml:space="preserve">  spaces   and
    newlines
    	tabs		preserved  </item>
  <item id="ws-default" xml:space="default">  normalized  whitespace  </item>
  <item
    id =
    "multiline-attr"
    type
    =
    "a"
    ref
    = "cdata-tests"
  >Attributes split across lines with varied spacing</item>

  <!-- Empty elements: explicit vs self-closing -->
  <item id="empty-explicit"></item>
  <sub/>
  <a:empty xmlns:a="http://example.com/ns-a" />
  <item id="self-close-with-space" />

  <!-- Attribute value edge cases (always quoted in XML) -->
  <item id="attr-quotes" type='single"inside'>Single-quoted with double inside</item>
  <item id="attr-entities" type="a&lt;b&amp;c&quot;d">Entities in attribute values</item>
  <item id="attr-newline" type="line1&#10;line2">Newline entity in attribute</item>
  <item id="attr-empty" type="">Empty attribute value</item>

  <!-- Mixed content -->
  <item id="mixed">Text <sub/> more text <b xmlns="http://example.com/html">bold</b> tail text</item>

  <!-- Deeply nested + repetition -->
  <a:element xmlns:a="http://example.com/ns-a">
    <a:element><a:element><a:element><a:element>5 deep</a:element></a:element></a:element></a:element>
  </a:element>

  <!-- Processing instructions inside content -->
  <?pi-in-content data?>
  <?pi-with-question-mark content with ? inside?>
  <?pi-ending-tricky content?ending with question ?>

  <!-- Comments inside content -->
  <!-- <item>commented out element</item> -->
  <item id="around-comment">before<!-- inside -->after</item>

  <!-- Case sensitivity: these are ALL different elements -->
  <CaseSensitive/>
  <casesensitive/>
  <CASESENSITIVE/>
  <caseSensitive/>

  <!-- Numeric / unicode element and attribute names -->
  <_underscore-start xmlns:_ns="http://example.com/us" _ns:_attr="val">Valid name starting with underscore</_underscore-start>
  <élément>Unicode element name (valid in XML 1.1 / XML 1.0 5th ed)</élément>

  <!-- Colon edge cases (colons only valid as namespace separator) -->
  <a:b xmlns:a="http://example.com/ns-a">Prefixed element with prefixed attribute: <a:c a:d="e"/></a:b>

  <!-- Long attribute value and text content -->
  <item id="long" type="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa">Long content: aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</item>

  <!-- Element with only whitespace content -->
  <item id="ws-only">   </item>
  <item id="newline-only">
</item>

  <!-- Adjacent CDATA and text -->
  <item id="adjacent">text<![CDATA[ cdata ]]>text<![CDATA[ cdata ]]>text</item>

  <!-- Embedded XML declaration lookalike (invalid, but parsers should handle) -->
  <item id="fake-prolog">&lt;?xml version="1.0"?&gt; not a real prolog</item>

  <!-- CDATA end sequence lookalike in text -->
  <item id="cdata-lookalike">The sequence ]] &gt; in text (split to be valid)</item>

  <!-- Namespace used then undeclared in sibling -->
  <a:parent xmlns:a="http://example.com/ns-a">
    <a:child>Has namespace</a:child>
  </a:parent>
  <!-- a: prefix no longer valid here -->

  <shared>&copy; Content from DTD-defined element &amp; entity</shared>

</root>
<!-- Trailing comment after root (valid) -->
<?trailing-pi valid-after-root?>
```