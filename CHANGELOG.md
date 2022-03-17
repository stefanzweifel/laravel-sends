# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-sends/compare/v2.1.1...HEAD)

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
