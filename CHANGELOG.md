# Change Log


## Unreleased

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
