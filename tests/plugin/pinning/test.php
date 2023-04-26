<?php

use Http\Discovery\Psr17FactoryDiscovery;

require __DIR__.'/vendor/autoload.php';

echo get_class(Psr17FactoryDiscovery::findRequestFactory())."\n";
