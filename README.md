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
@import "../vendor/tempest/highlight/src/Themes/highlight-tempest.css";
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