# Fast, extensible, server-side code highlighting

## Quickstart

Highlight code like this

```php
$highlighter = new \Tempest\Highlight\Highlighter();

$code = $highlighter->parse($escapedCode, 'php');
```

**Note: you should always pass the _escaped_ version of your code**:

```php
$code = $highlighter->parse(htmlentities($raw), 'php');
```

Next, you can import one of the provided themes:

```css
@import "../vendor/tempest/highlight/src/Themes/highlight-light-lite.css";
```

Or you can build your own with just a couple of classes:

```css
.hl-keyword {
    color: #4F95D1;
}

.hl-property {
    color: #46b98d;
}

.hl-attribute {
    font-style: italic;
}

.hl-type {
    color: #D14F57;
}

.hl-generic {
    color: #9D3AF6;
}

.hl-comment {
    color: #888888;
}
```

You should style `<pre>` tags yourself.

## CommonMark integration

If you're using `league/commonmark`, you can add highlight support to codeblocks like so:

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\HighlightCodeBlockRenderer;

$environment = new Environment();

$environment
    ->addExtension(new CommonMarkCoreExtension())
    ->addRenderer(FencedCode::class, new HighlightCodeBlockRenderer());

$markdown = new MarkdownConverter($environment);
```

Keep in mind that you need to manually install `league/commonmark`:

```php
composer require league/commonmark;
```