# Changelog

## [0.4.4] - 2025-03-09

### Removed
- WP admin panel brand skin (admin-style.css and related enqueue hooks)

## [0.4.3] - 2025-03-09

### Added
- WP admin panel brand skin (admin-style.css): Portico Webworks colors, Inter font, styled sidebar, admin bar, buttons, login page

## [0.4.2] - 2025-03-09

### Changed
- Test release (minor)

## [0.4.1] - 2025-03-09

### Fixed
- Release workflow: add `contents: write` permission for asset upload
- Release workflow: build in temp dir to avoid nested zip structure

## [0.4] - 2025-03-09

### Added
- GitHub Action: release workflow builds `portico_webworks_theme.zip` with correct slug for WP theme uploader (preserves Customizer values on update)
- Design tokens: line-height (`--leading-*`), letter-spacing (`--tracking-*`)

## [0.3] - 2025-03-09

### Changed
- Flatten repo structure: theme files at root for WordPress compatibility (single folder on download)

## [0.2] - 2025-03-09

### Added
- Design token variables in `:root`:
  - **Spacing** (`--space-1` through `--space-32`): base 4px scale for padding, margin, gap
  - **Typography** (`--text-xs` through `--text-5xl`): major third scale (1.25rem base)
  - **Width** (`--w-xs` through `--w-3xl`): semantic max-width tokens for layout containers
