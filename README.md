# HTTPlug Discovery

[![Latest Version](https://img.shields.io/github/release/php-http/discovery.svg?style=flat-square)](https://github.com/php-http/discovery/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/php-http/discovery.svg?style=flat-square)](https://travis-ci.org/php-http/discovery)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-http/discovery.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/discovery)
[![Quality Score](https://img.shields.io/scrutinizer/g/php-http/discovery.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/discovery)
[![Total Downloads](https://img.shields.io/packagist/dt/php-http/discovery.svg?style=flat-square)](https://packagist.org/packages/php-http/discovery)

**Finds installed HTTPlug implementations and PSR-7 message factories.**


## Install

Via Composer

``` bash
$ composer require php-http/discovery
```


## Documentation

Please see the [official documentation](http://php-http.readthedocs.org/en/latest/discovery.html).


## Testing

``` bash
$ composer test
```

## Backwards compatibility promise

The backwards compatibility promise does not include classes marked with the `@internal` annotation. Nor does it
include the default order of which the strategies are executed. However we do promise that we do not remove any strategies 
and we will also not remove any classes in the `CommonClassesStrategy`. We do also promise to support the following Puli versions: 

* 1.0.0-beta10

## Contributing

Please see our [contributing guide](http://docs.php-http.org/en/latest/development/contributing.html).


## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
