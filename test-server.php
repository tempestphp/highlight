<?php

require_once __DIR__ . '/vendor/autoload.php';

$port = intval($argv[1] ?? 8000);

passthru("php -S localhost:$port -t tests/");
