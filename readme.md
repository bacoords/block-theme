# BlockTheme

BlockTheme is a block-based starter theme built for modern WordPress developers. 

Built by [@aurooba](https://github.com/aurooba) and [@bacoords](https://github.com/bacoords).

## Theme Setup

Most of the theme setup is handled in the `inc/*.php` files. This includes:

- Theme supports
- Enqueueing scripts and styles, including block-specific styles
- Any custom theme options

## Build Process

As of now, this repository does _not_ include the final built assets or blocks. You'll need to build them once you've cloned the repo. (You may also want to exclude them from your `.gitignore` file, depending on your workflow.)

`npm run build` will build the theme's CSS and JavaScript files.

`npm run watch` will watch for changes to the theme's SCSS and JavaScript files partials and rebuild them automatically.

### CSS & SCSS

BlockTheme does enqueue global stylesheets for the frontend and the block editor, `global.css` and `editor.css`.

However, BlockTheme's superpowers include the ability to generate _block-specific CSS files_ and enqueue them automatically to their specific blocks.

To add a block-specific file, create a new SCSS file in the `src/scss/blocks` directory. The directory should match the block's namespace, and the file should be named after the block's slug. For example, a block like `core/paragraph` would get a corresponding SCSS file named `src/scss/blocks/core/paragraph.scss`.

The theme will compile the block-specific SCSS files into CSS files and enqueue them on the frontend and block editor.

### JavaScript

There are two separate JavaScript files

- `scripts.js` is the main JavaScript file for the theme. It is enqueued on the frontend, but is currently empty. Feel free to remove it if you don't need it.
- `editor.js` is the main JavaScript file for the block and site editor. It includes code scaffolding for actions like registering block variations and styles or unregistering specific block types.

### Custom Blocks

Because we're already using `@wordpress/scripts` to build our theme, we can also use it to build our custom blocks. The `blocks` directory contains all of the custom blocks for the theme.

## Linting and WordPress Coding Standards

PHP linting is available by running `composer php-lint` from the command line.

BlockTheme follows the WordPress Coding Standards. You can check your code against the standards by running `composer phpcs` from the command line. You can also run `composer phpcs-fix` to automatically fix any errors that can be fixed automatically.

## File/Folder Structure

```
├── bin 			<-- Node scripts for building the theme
├── blocks 			<-- Custom blocks
├── css 			<-- Compiled CSS files
├── fonts			<-- Theme fonts
├── inc				<-- Theme includes and functions
│   ├── enqueue-blocks.php				<-- Enqueue block-specific styles
│   ├── enqueue.php						<-- Enqueue scripts and styles
│   ├── setup.php						<-- Theme setup
├── js				<-- Compiled JavaScript files
├── languages 		<-- Translations
├── parts 			<-- Custom block template parts
├── patterns 		<-- Custom block patterns
├── src				<-- Theme source files
│   ├── blocks 		<-- Block source files
│   ├── css 		<-- SCSS source files
│   ├── js			<-- JavaScript source files
├── templates    	<-- Templates for the site editor
```

## License

BlockTheme is licensed under the GNU General Public License v3.0 or later.

## Credits

- TwentyTwentyThree: https://wordpress.org/themes/twentytwentythree
- TwentyTwentyFour: https://wordpress.org/themes/twentytwentyfour
- WordPress Scripts: https://developer.wordpress.org/block-editor/packages/packages-scripts/
- Aurooba Ahmed: https://github.com/aurooba (Much of the work and thoughtfulness behind this theme is completely Aurooba)
