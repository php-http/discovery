# HTTP Discovery

[![Latest Version](https://img.shields.io/github/release/php-http/discovery.svg?style=flat-square)](https://github.com/php-http/discovery/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/php-http/discovery.svg?style=flat-square)](https://travis-ci.org/php-http/discovery)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-http/discovery.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/discovery)
[![Quality Score](https://img.shields.io/scrutinizer/g/php-http/discovery.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/discovery)
[![HHVM Status](https://img.shields.io/hhvm/php-http/discovery.svg?style=flat-square)](http://hhvm.h4cc.de/package/php-http/discovery)
[![Total Downloads](https://img.shields.io/packagist/dt/php-http/discovery.svg?style=flat-square)](https://packagist.org/packages/php-http/discovery)

**Finds installed adapters and message factories.**


## Install

Via Composer

``` bash
$ composer require php-http/discovery
```


## Usage

Static containers to ease the auto initialization of objects.

Currently the following discovery strategies are available:

- Http Adapter discovery
- Message Factory discovery
- URI Factory discovery


### Http Adapter discovery

HTTP Adapters provided by us are registered in the discovery by default.

``` php
use Http\Discovery\HttpAdapterDiscovery;

HttpAdapterDiscovery::register('my_adapter', 'My\Adapter\Class');

$adapter = HttpAdapterDiscovery::find();
```


### Message Factory discovery

Two common message factories are bundled with this package. ([Guzzle](https://github.com/guzzle/psr7) and [Diactoros](https://github.com/zendframework/zend-diactoros))

``` php
use Http\Discovery\MessageFactoryDiscovery;

MessageFactoryDiscovery::register('my_factory', 'My\Factory\Class', 'Psr\Request\Implementation\Class');

$factory = MessageFactoryDiscovery::find();
```


### URI Factory discovery

Two common URI factories are bundled with this package: ([Guzzle](https://github.com/guzzle/psr7) and [Diactoros](https://github.com/zendframework/zend-diactoros)).

``` php
use Http\Discovery\UriFactoryDiscovery;

MessageFactoryDiscovery::register('my_factory', 'My\Factory\Class', 'Psr\Uri\Implementation\Class');

$factory = UriFactoryDiscovery::find();
```


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
