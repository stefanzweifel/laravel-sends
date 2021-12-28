# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-sends/compare/v1.0.0...HEAD)

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
