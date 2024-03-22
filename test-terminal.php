<?php

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\TerminalTheme;

require_once __DIR__ . '/vendor/autoload.php';

$highlighter = new Highlighter(new TerminalTheme());

$target = 'targets' . DIRECTORY_SEPARATOR . 'test.md';

if ($argc > 1) {
    $target = $argv[1];
}

$code = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . $target);

$language = 'html';

preg_match('/```(\w+)/', $code, $matches);

if (count($matches) > 0) {
    $language = $matches[1];
}

$code = str_replace(
    ['```' . $language, '```'],
    '',
    $code,
);

echo PHP_EOL;

echo html_entity_decode($highlighter->parse($code, $language));

echo PHP_EOL.PHP_EOL;
