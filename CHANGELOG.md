# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-sends/compare/v2.6.1...HEAD)

## [v2.6.1](https://github.com/stefanzweifel/laravel-sends/compare/v2.6.0...v2.6.1) - 2025-01-03

### Fixed

- Fix compatibility with HasFactory ([#25](https://github.com/stefanzweifel/laravel-sends/pull/25))

## [v2.6.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.5.0...v2.6.0) - 2024-11-13

### Added

- Add Support for PHP 8.4 ([#24](https://github.com/stefanzweifel/laravel-sends/pull/24))

## [v2.5.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.4.2...v2.5.0) - 2024-10-14

### Changed

- Change getMailClassHeader return value from self to static ([#23](https://github.com/stefanzweifel/laravel-sends/pull/23))

### Fixed

- Increase Phpstan Level to 9 ([#21](https://github.com/stefanzweifel/laravel-sends/pull/21))
- Corrected User Association in Readme ([#22](https://github.com/stefanzweifel/laravel-sends/pull/22))

## [v2.4.2](https://github.com/stefanzweifel/laravel-sends/compare/v2.4.1...v2.4.2) - 2024-02-03

### Changed

- Add Support for Laravel 11 ([#19](https://github.com/stefanzweifel/laravel-sends/pull/19))

## [v2.4.1](https://github.com/stefanzweifel/laravel-sends/compare/v2.4.0...v2.4.1) - 2023-11-25

### Fixed

- fix saving Message-ID ([#18](https://github.com/stefanzweifel/laravel-sends/pull/18))

## [v2.4.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.3.1...v2.4.0) - 2023-10-16

### Added

- Add Support for PHP 8.3 ([#17](https://github.com/stefanzweifel/laravel-sends/pull/17))

### Changed

- Upgrade to Pest v2 ([#16](https://github.com/stefanzweifel/laravel-sends/pull/16))

## [v2.3.1](https://github.com/stefanzweifel/laravel-sends/compare/v2.3.0...v2.3.1) - 2023-01-25

### Changed

- Add Support for Laravel 10 ([#15](https://github.com/stefanzweifel/laravel-sends/pull/15))

## [v2.3.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.2.0...v2.3.0) - 2022-11-05

### Added

- Add Support for new Mailable syntax ([#14](https://github.com/stefanzweifel/laravel-sends/pull/14))
- Add Support for PHP 8.2 ([#13](https://github.com/stefanzweifel/laravel-sends/pull/13))

## [v2.2.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.1.1...v2.2.0) - 2022-03-28

## Added

- Add better support for custom send attributes ([#11](https://github.com/stefanzweifel/laravel-sends/pull/11))

## Changed

- Change Visibility of getAddressesValue ([#10](https://github.com/stefanzweifel/laravel-sends/pull/10))

## [v2.1.1](https://github.com/stefanzweifel/laravel-sends/compare/v2.1.0...v2.1.1) - 2022-03-17

## Fixed

- Allow consumers to use their own Send Factory for their custom Send Model ([#9](https://github.com/stefanzweifel/laravel-sends/pull/9))

## [v2.1.0](https://github.com/stefanzweifel/laravel-sends/compare/v2.0.1...v2.1.0) - 2022-01-18

## Added

- Add Support for Laravel 9 ([#8](https://github.com/stefanzweifel/laravel-sends/pull/8))

## Changed

- Drop Support for Laravel 8 ([#8](https://github.com/stefanzweifel/laravel-sends/pull/8))

## [v2.0.1](https://github.com/stefanzweifel/laravel-sends/compare/v2.0.0...v2.0.1) - 2022-01-10

## Fixed

- Fix internals when a Custom Model is used ([#7](https://github.com/stefanzweifel/laravel-sends/pull/7))

## [v2.0.0](https://github.com/stefanzweifel/laravel-sends/compare/v1.0.0...v2.0.0) - 2022-01-05

See [UPGRADING.md](https://github.com/stefanzweifel/laravel-sends/blob/main/UPGRADING.md#from-v10-to-v20) for guidance on how to deal with breaking changes.

## Added

- Store Content of outgoing mail messages in the database ([#6](https://github.com/stefanzweifel/laravel-sends/pull/6))

## [v1.0.0](https://github.com/stefanzweifel/laravel-sends/compare/v0.1.0...v1.0.0) - 2021-12-28

See [UPGRADING.md](https://github.com/stefanzweifel/laravel-sends/blob/main/UPGRADING.md#from-v01-to-v10) for guidance on how to deal with breaking changes.

## Changed

- Rename `custom_message_id` column to `uuid`; update related code ([#5](https://github.com/stefanzweifel/laravel-sends/pull/5))
- Update `associateWith()` signature to either pass an array or multiple HasSends models as arguments ([#4](https://github.com/stefanzweifel/laravel-sends/pull/4))
- Rename Send Scopes ([#2](https://github.com/stefanzweifel/laravel-sends/pull/2))

## Fixed

- Fix DocBlocks for Send Properties ([#1](https://github.com/stefanzweifel/laravel-sends/pull/1))

## v0.1.0 - 2021-12-03

- initial release
