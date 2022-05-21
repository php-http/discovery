<?php
$loader = require __DIR__.'/../vendor/autoload.php';

// Temporary fix for Puli
if (PHP_VERSION_ID >= 50600) {
    $loader->addClassMap([
        'Puli\\GeneratedPuliFactory' => __DIR__.'/../.puli/GeneratedPuliFactory.php',
    ]);
}

if (PHP_VERSION_ID < 70300 && class_exists('Puli\\GeneratedPuliFactory')) {
    class PuliIsSupported {}
}
