<?php

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\TerminalTheme;

require_once __DIR__ . '/vendor/autoload.php';

$highlighter = new Highlighter(new TerminalTheme());

$code = str_replace(
    ['```html', '```php', '```'],
    '',
    file_get_contents(__DIR__ . '/tests/test.md')
);

echo PHP_EOL;

echo html_entity_decode($highlighter->parse($code, 'html'));

echo PHP_EOL.PHP_EOL;