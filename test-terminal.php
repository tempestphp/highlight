<?php

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\TerminalTheme;

require_once __DIR__ . '/vendor/autoload.php';

$highlighter = new Highlighter(new TerminalTheme());

$code = str_replace(
    ['```php', '```'],
    '',
    file_get_contents(__DIR__ . '/tests/test.md')
);

echo PHP_EOL;

echo html_entity_decode($highlighter->parse(htmlentities($code), 'php'));

echo PHP_EOL.PHP_EOL;