# StinkReporter

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - 2026-09-13

### Added

- Reports may carry the weather the client already looked up. It is optional:
  when omitted the server fetches it itself, so a report is never rejected
  because the client could not reach the weather service.

### Changed

- Weather is read from Open-Meteo instead of OpenWeatherMap. No API key is
  needed any more. Units are unchanged: temperature in Kelvin, wind in m/s,
  direction in degrees.
- The production `env.php` needs no changes. The server always reads weather
  from Open-Meteo; a `weatherService()` left in `env.php` is no longer called
  and can be removed.
- Requires PHP 8.1 or newer. Dependencies updated (Slim 4.15, slim/psr7 1.8).
- Weather lookups time out after 10 seconds instead of holding up the report.

### Fixed

- Past weather no longer depends on OpenWeatherMap's One Call 2.5, which was
  retired in 2024.
- A report missing one of its sections is answered with 400 instead of 500.

## [1.2.0] - 2021-02-26

### Added

- Reports with start and end time can be sent

### Changed

- Run everything dockerized to facilitate development and ensure consistent behaviour of local and remote execution

## [1.1.0] - 2020-11-08

### Added

- Parameter indicating if the report's address is the reporter's home address

## [1.0.0] - 2020-09-02

### Added

- Get weather data from openWeatherMap and attach to the report

### Changed

- **breaking**: Removed `Time` Parameter from post interface. Now every report will be assumed to be meant for the current time

## [0.0.2] - 2020-06-21

### Fixed

- Mixed up latitude longitude
- Don't fail if "to" address for report mails is empty

## [0.0.1] - 2020-06-21

### Fixed

- Allow milliseconds in timestamps

## [0.0.0] - 2020-05-26

### Added

- Endpoint to post a stink report
- Endpoint to get previous stink reports
- Functionality to mail reports
