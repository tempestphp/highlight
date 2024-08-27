<?php

require_once __DIR__ . '/vendor/autoload.php';

passthru("php -S localhost:8000 -t tests/");