# Changelog

## [0.4.18] - 2026-04-15

### Removed
- Theme activation automation for GeneratePress Customizer defaults, automatic Header Menu creation/assignment, and Homepage/Blog static front-page setup

## [0.4.17] - 2026-04-15

### Added
- Gap tokens (`--gap-1` to `--gap-3`) and section padding tokens (`--padding-1` to `--padding-4`)

### Changed
- Increased `--padding-4` ceiling to `14rem` for loose section spacing

## [0.4.16] - 2026-04-15

### Removed
- Bundled `gb-global-styles.xml` (GenerateBlocks global styles for section rhythm, horizontal wrap, and gap utilities)

## [0.4.15] - 2026-04-15

### Added
- One-time theme activation: GeneratePress Customizer defaults (1024px container, one-container, text alignment, no sidebars; smooth scroll when GP Premium is active), static front page (Homepage + Blog pages), empty **Header Menu** assigned to primary location
- One-time import of GenerateBlocks global styles from bundled `gb-global-styles.xml` into `gblocks_styles` posts

### Removed
- Section rhythm (`.section-*`), `.section-wrap`, and gap utilities (`.gap-*`) from `style.css` (prefer block-level / GenerateBlocks styling)

## [0.4.14] - 2026-04-07

### Changed
- `.section-wrap` now removes horizontal padding at `min-width: 1024px` to align with desktop container width

## [0.4.13] - 2026-04-07

### Added
- Section spacing utilities: `.section-tight`, `.section-normal`, `.section-relaxed`, `.section-loose`
- Section wrap utility: `.section-wrap`
- Gap utilities: `.gap-tight`, `.gap-normal`, `.gap-relaxed`

## [0.4.12] - 2026-04-07

### Added
- Developer reference doc (`DEVELOPERS.md`) with initial website building blocks section:
  - Site Header
  - Site Footer
- Additional spacing tokens (`--space-7`, `--space-9`, `--space-14`, `--space-18`, `--space-28`, `--space-36`, `--space-40`, `--space-48`)
- Additional radius tokens (`--radius-3xl`, `--radius-4xl`)

## [0.4.8] - 2025-03-10

### Added
- `scroll-behavior: smooth` on html
- `-webkit-overflow-scrolling: touch` on body
- Radius design tokens (`--radius-xs` through `--radius-full`)

### Changed
- Design tokens: width moved before typography in `:root`

## [0.4.7] - 2025-03-09

### Added
- style.css scope documentation: global design system classes and CSS variables only; local/component CSS belongs in GenerateBlocks Pro; warns that non-global block/section classes cause issues with GeneratePress + GenerateBlocks

## [0.4.6] - 2025-03-09

### Added
- Block editor style enqueues (child theme CSS, Customizer CSS)

### Removed
- inc/customizer-typography-defaults.json

## [0.4.5] - 2025-03-09

### Removed
- Customizer/editor integration: block editor style enqueues, GeneratePress typography defaults filter (fixes WSOD)

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
