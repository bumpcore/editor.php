# Changelog

All notable changes to `bumpcore/editor.php` are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.0] - 2026-04-06

### Added

- Added Laravel 13 support for `illuminate/support` and `illuminate/validation`.
- Added PHP 8.5, Pest 4, and Orchestra Testbench 11 coverage to the test matrix.

### Fixed

- Fixed Laravel 10 dependency resolution in CI for PHP 8.1.

### Changed

- Updated the README version support table.
- Removed the banner artwork from the repository.

## [1.2.0] - 2025-03-15

### Added

- Added Laravel 12 support for `illuminate/support` and `illuminate/validation`.
- Added Pest 3 and Orchestra Testbench 10 compatibility.

### Changed

- Updated CI coverage and README support documentation for Laravel 12.

## [1.1.0] - 2024-06-07

### Added

- Added Laravel 11 support for `illuminate/support` and `illuminate/validation`.
- Added Pest 2 and Orchestra Testbench 9 compatibility.
- Added broader matrix testing across supported Laravel and PHP versions.

### Fixed

- Fixed Faker deprecation handling in tests.
- Fixed styling in the compiled Tailwind and Bootstrap 5 PHP templates.

### Changed

- Updated README support documentation and repository banner assets.

## [1.0.0] - 2023-06-11

### Added

- Added Tailwind CSS and Bootstrap 5 template sets for rendering Editor.js blocks.
- Added compiled PHP template resources alongside Blade templates.
- Added the view-compilation workflow and repository script for generating PHP templates from Blade views.
- Added PHPStan configuration and static-analysis CI.
- Added macro support on `EditorPhp`.
- Added `has` support for block data access.
- Expanded README documentation with setup, block, rendering, Laravel, and contribution sections.

### Changed

- Refactored block rule definitions and purifier internals.
- Reorganized template resources into named template families.

### Removed

- Removed the legacy flat PHP and Blade template layout in favor of template-specific directories.

## [0.5.0] - 2023-02-14

### Changed

- Updated Laravel dependencies from Laravel 9 to Laravel 10.
- Updated the development test stack for Laravel 10 support.

## [0.4.0] - 2023-02-04

### Added

- Added fake Editor.js data generation support with Faker.
- Added getter and setter helpers for block data.
- Added default block type registration.
- Added support for creating an `EditorPhp` instance without initial input.
- Added a published configuration file.
- Added matrix testing and PHP-CS-Fixer formatting workflow coverage.

### Changed

- Refactored block data access and compact block handling.
- Renamed the custom block stub from provider terminology to block terminology.

## [0.3.0] - 2023-01-11

### Added

- Added native PHP templates for supported blocks.
- Added parser and purifier components for Editor.js output.
- Added allowed-tag sanitizing support for block field rules.
- Added a block type resolver.
- Added the main test suite, datasets, and GitHub Actions test workflow.

### Changed

- Renamed block data and provider-related internals during the early API cleanup.
- Moved the Laravel cast to `EditorPhpCast`.

### Removed

- Removed the facade and older block collection/data classes.

## [0.2.0] - 2022-12-19

### Added

- Added support and default views for the official Editor.js blocks beyond the initial block set, including attaches, checklist, code, embed, link tool, personality, quote, raw, table, and warning.

### Fixed

- Matched incoming block types case-insensitively by normalizing them to lowercase.

## [0.1.0] - 2022-12-16

### Added

- Initial package release.
- Added core `EditorPhp` parsing and rendering flow.
- Added initial block support for delimiter, header, image, list, and paragraph blocks.
- Added Laravel service provider, cast, block generator command, and Blade views.
- Added package metadata, README, and MIT license.

[Unreleased]: https://github.com/bumpcore/editor.php/compare/v1.3.0...HEAD
[1.3.0]: https://github.com/bumpcore/editor.php/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/bumpcore/editor.php/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/bumpcore/editor.php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/bumpcore/editor.php/compare/v0.5.0...v1.0.0
[0.5.0]: https://github.com/bumpcore/editor.php/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/bumpcore/editor.php/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/bumpcore/editor.php/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/bumpcore/editor.php/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/bumpcore/editor.php/releases/tag/v0.1.0
