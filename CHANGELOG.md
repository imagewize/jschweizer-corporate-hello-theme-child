# Changelog

All notable changes to the Hello Elementor Child theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### [2.1.0] - 2025-12-12

#### Added
- Comprehensive AI-assisted development guidance documentation
  - Added [AGENTS.md](AGENTS.md) with general guidance for AI agents working with the WordPress child theme codebase
  - Added [CLAUDE.md](CLAUDE.md) with Claude Code-specific instructions and development patterns
- Performance optimization documentation
  - Multi-layered font loading optimization strategy with font-display swap implementation
  - Resource preconnect strategy for Google Fonts and YouTube domains
  - Hook priorities and cache busting patterns via version constants
- Developer guidance and conventions
  - Function naming conventions (jochen_schweizer_ and hello_elementor_child_ prefixes)
  - Security requirements including ABSPATH checks
  - Code organization patterns and modification areas

#### Changed
- Formalized theme's technical approach and AI-powered development practices
- Enhanced documentation for maintaining optimal performance and Core Web Vitals metrics

## [2.0.1] - 2025-12-12

### Added
- Initial documentation update
- .gitignore file for version control

### Changed
- Project structure improvements
- Base theme setup and configuration

## [2.0.0] - 2025-12-12

### Added
- Initial release of Hello Elementor Child theme
- Base child theme structure inheriting from Hello Elementor parent theme
- Custom styles foundation
