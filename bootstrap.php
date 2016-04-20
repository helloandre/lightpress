<?php

require 'vendor/autoload.php';

// we need a templates folder or Pressing has a heart attack
if (!file_exists( __DIR__ . '/templates')) {
    mkdir(__DIR__ . '/templates');
}

$pressing = new Pressing\Pressing;
$pressing->generate();

echo "You may now start a local server to start testing" . PHP_EOL;
echo "To start a server, use:" . PHP_EOL . PHP_EOL;
echo "php -S localhost:8080 -t public/ public/admin/index.php" . PHP_EOL . PHP_EOL;
echo "then visit http://localhost:8080/admin" . PHP_EOL;