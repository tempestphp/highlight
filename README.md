# Fast, extensible, server-side code highlighting
[![Coverage Status](https://coveralls.io/repos/github/tempestphp/highlight/badge.svg?branch=main)](https://coveralls.io/github/tempestphp/highlight?branch=main)

## Quickstart

```php
composer require tempest/highlight
```

Highlight code like this:

```php
$highlighter = new \Tempest\Highlight\Highlighter();

$code = $highlighter->parse($code, 'php');
```

Continue reading in the docs: [https://tempest.stitcher.io/highlight/01-getting-started](https://tempest.stitcher.io/highlight/01-getting-started).