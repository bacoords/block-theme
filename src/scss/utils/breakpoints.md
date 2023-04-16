# Breakpoints in Tangent

Breakpoints are defined in `src/theme-json/settings/custom/breakpoints.jsonc`. The provided breakpoints closely match the block editor's breakpoints, but you can add or remove breakpoints as needed.

The `build` command will regenerate the `src/scss/abstracts/_breakpoints.scss` file for you.

**Do not directly edit the `_breakpoints.scss` file.** It will be overwritten by the `build` command.

## Usage in SCSS

```scss
// Import the respond-to mixin
@use "../utils/breakpoint-mixin.scss" as *;

// Use the breakpoints
@include breakpoint('md') {
  // Styles for screens larger than the 'md' breakpoint
}
```