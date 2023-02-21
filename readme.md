# Tangent

Tangent is a new starter theme (currently in development) for WordPress.
[tangentwp.com](https://tangentwp.com)

## Theme Setup

Tangent is a "hybrid" theme, which means that most of the theme setup is handled in the `inc/setup.php` file. This includes:

- Theme supports
- Menus and widgets
- Any custom theme options

Similarly, most of the design setup starts in the `src/theme-json` folder. More on that below.

## Build Process

As of now, this repository does _not_ include the final built assets. You'll need to build them once you've cloned the repo. (You may also want to exclude them from your `.gitignore` file, depending on your workflow.)

`npm run build` will build the theme's CSS, JavaScript files, and theme.json.

`npm run watch` will watch for changes to the theme's SCSS, JavaScript files, and theme.json partials and rebuild them automatically.

### CSS & SCSS

Tangent does enqueue stylesheets for the frontend and the block editor, However, Tangent's superpowers include the ability to pull props _directly from your theme.json_ as well as generate _block-specific CSS files_ and enqueue them to their specific blocks.

- [Using SCSS in Tangent](https://github.com/understrap/tangent/tree/develop/src/scss#readme)
- [Using the functions found in the `props.scss` file](https://github.com/understrap/tangent/blob/develop/src/scss/abstracts/props.md)
- [Breakpoints in Tangent](https://github.com/understrap/tangent/blob/develop/src/scss/abstracts/breakpoints.md)

### JavaScript

TK

### Theme.json

Tangent uses `.jsonc` partials to store all of the theme's design settings. These smaller partials are automatically compiled into a `theme.json` file for your theme.

Read: [How to create a theme.json from partials](https://github.com/understrap/tangent/tree/develop/src/theme-json#readme)

## Block Template Parts

Block Template Parts are enabled in Tangent, allowing you to create and store HTML template parts in the `parts` folder. This allows users to edit the template parts in the WordPress Dashboard from WordPress > Template Parts. You can control the registration of the template part (specifically the name and what `area` it's associated with) from `theme.json`. See `src/theme-json/templateParts.jsonc` for more information.

### Custom Blocks

Because we're already using `@wordpress/scripts` to build our theme, we can also use it to build our custom blocks. TK

## Navigation Menu

Tangent's `header.php` uses a "classic" WordPress Menu but is enhanced with much of the same front-end updates in the Gutenberg navigation block. This includes a responsive full screen modal and solid accessibility. To accomplish this, Tangent combines a custom navwalker called `Tangent_Navwalker` with additional JavaScript to enable accessible dropdowns for submenus.

## Linting and WordPress Coding Standards

PHP linting is available by running `composer php-lint` from the command line.

Tangent follows the WordPress Coding Standards. You can check your code against the standards by running `composer phpcs` from the command line. You can also run `composer phpcs-fix` to automatically fix any errors that can be fixed automatically.


## File/Folder Structure

```
├── bin 			<-- Node scripts for building the theme
├── blocks 			<-- Custom blocks
├── css 			<-- Compiled CSS files
├── fonts			<-- Theme fonts
├── inc				<-- Theme includes and functions
│   ├── class-tangent-navwalker.php		<-- Custom navwalker
│   ├── enqueue.php						<-- Enqueue scripts and styles
│   ├── setup.php						<-- Theme setup
├── js				<-- Compiled JavaScript files
├── languages 		<-- Translations
├── parts 			<-- Custom block template parts
├── patterns 		<-- Custom block patterns
├── src				<-- Theme source files
│   ├── css 		<-- SCSS source files
│   ├── js			<-- JavaScript source files
│   ├── theme-json	<-- Theme.json partials
├── template-parts	<-- Template parts and other partials
```

## License

Tangent is licensed under the GNU General Public License v3.0 or later.

## Credits

- Underscores: https://github.com/Automattic/_s
- Micromodal: https://micromodal.vercel.app
- WordPress Scripts: https://developer.wordpress.org/block-editor/packages/packages-scripts/