# StinkReporter

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
