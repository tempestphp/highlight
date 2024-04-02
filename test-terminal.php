<?php

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

require_once __DIR__ . '/vendor/autoload.php';

$highlighter = (new Highlighter(new LightTerminalTheme()))->withGutter();

$target = $argc > 1
    ? $argv[1]
    : 'targets' . DIRECTORY_SEPARATOR . 'test.md';

$code = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . $target);

preg_match('/```(\w+)/', $code, $matches);

$language = count($matches) > 0
    ? $matches[1]
    : 'html';

$code = str_replace(
    ['```' . $language, '```'],
    '',
    $code,
);

echo PHP_EOL, $highlighter->parse($code, $language), PHP_EOL, PHP_EOL;
