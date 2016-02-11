# Change Log


## 0.8.0 - 2016-02-11

### Changed

- Puli composer plugin must be installed separately


## 0.7.0 - 2016-01-15

### Added

- Temporary puli.phar (Beta 10) executable

### Changed

- Updated HTTPlug dependencies
- Updated Puli dependencies
- Local configuration to make tests passing

### Removed

- Puli CLI dependency


## 0.6.4 - 2016-01-07

### Fixed

- Puli [not working](https://twitter.com/PuliPHP/status/685132540588507137) with the latest json-schema


## 0.6.3 - 2016-01-04

### Changed

- Adjust Puli dependencies


## 0.6.2 - 2016-01-04

### Changed

- Make Puli CLI a requirement


## 0.6.1 - 2016-01-03

### Changed

- More flexible Puli requirement


## 0.6.0 - 2015-12-30

### Changed

- Use [Puli](http://puli.io) for discovery
- Improved exception messages


## 0.5.0 - 2015-12-25

### Changed

- Updated message factory dependency (php-http/message)


## 0.4.0 - 2015-12-17

### Added

- Array condition evaluation in the Class Discovery

### Removed

- Message factories (moved to php-http/utils)


## 0.3.0 - 2015-11-18

### Added

- HTTP Async Client Discovery
- Stream factories

### Changed

- Discoveries and Factories are final
- Message and Uri factories have the type in their names
- Diactoros Message factory uses Stream factory internally

### Fixed

- Improved docblocks for API documentation generation


## 0.2.0 - 2015-10-31

### Changed

- Renamed AdapterDiscovery to ClientDiscovery


## 0.1.1 - 2015-06-13

### Fixed

- Bad HTTP Adapter class name for Guzzle 5


## 0.1.0 - 2015-06-12

### Added

- Initial release
