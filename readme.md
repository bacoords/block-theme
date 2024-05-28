# BlockTheme

BlockTheme is a block-based starter theme built for modern WordPress developers. 

Built by [@aurooba](https://github.com/aurooba) and [@bacoords](https://github.com/bacoords).

## Theme Setup

Most of the theme setup is handled in the `inc/*.php` files. This includes:

- Theme supports
- Enqueueing scripts and styles, including block-specific styles
- Any custom theme options
- Replacing the WordPress Logo and colors on the login screen with the site logo and colors

## Theme.json

### Spacing

The naming convention for spacing presets are the same 20 - 80 scale that core uses, but the values are overridden to be fluid. These spacing values be also used as CSS variables, example: `var(--wp--preset--spacing--50)`.

### Colors

The theme.json file includes a color palette with a very small selection of color variables:

- Background
- Foreground
- Primary
- Secondary

This leaves colors in general pretty wide open for developers to follow their own naming conventions.

## Build Process

The build process uses `@wordpress/scripts` to compile SCSS and JavaScript files. There is a `webpack.config.js` file in the root of the theme that extends the default configuration. 

As of now, this repository does _not_ include the final built assets or blocks. You'll need to build them once you've cloned the repo. (You may also want to exclude them from your `.gitignore` file, depending on your workflow.)

Run `npm install` to install all of the dependencies.

`npm run build` will build the theme's CSS and JavaScript files.

`npm run start` will watch for changes to the theme's SCSS and JavaScript files partials and rebuild them automatically.

One note is that `@wordpress/scripts` is not great at recognizing _new_ files in the `src` directory. If you add a new file, you may need to restart the build process.

### CSS & SCSS

BlockTheme does enqueue two global stylesheets, one for the frontend (`global.css`) and one for the block editor (`editor.css`).

#### Utils/Mixins

There are a few mixins and functions in the `src/scss/utils` directory that you can use in any of your SCSS files by importing them. This includes any `style.scss`, `editor.scss`, or `view.scss` file in a custom block. 

An example:

```scss
@use '../utils';

.my-class {
	@include utils.breakpoint('md') {
		color: red;
	}
}
```


#### Block CSS

BlockTheme's superpowers include the ability to generate _block-specific CSS files_ and enqueue them automatically to their specific blocks, meaning they're only loaded if the block is present on the page.

To add a block-specific stylesheet, create a new directory and file in the `src/scss/blocks` directory. The directory should match the block's namespace, and the file should be named after the block's slug. For example, a block like `core/paragraph` would get a corresponding SCSS file named `src/scss/blocks/core/paragraph.scss`, while a stylesheet for the Gravity Forms block would be named `src/scss/blocks/gravityforms/form.scss`.

The theme will compile the block-specific SCSS files into CSS files and automatically enqueue them to that specific block on the frontend and in the editor. 

You can also import block SCSS files into `src/scss/blocks/index.scss` which will add them to the editor stylesheet. The reasoning here is that while the block stylesheet already gets loaded into the block editor, importing it to the editor stylesheet ensures that it _also_ gets loaded with the `.editor-styles-wrapper` class for sites loading the [non-iframed block editor](https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/). If this isn't an issue, you can skip this step.


### JavaScript

There are two separate JavaScript files available:

- `scripts.js` is the main JavaScript file for the theme. It is enqueued on the frontend, but is currently empty. Feel free to remove it if you don't need it.
- `editor.js` is the main JavaScript file for both the block and site editor. It includes code scaffolding for actions like registering block variations and styles or unregistering specific block types.

You can do all sorts of block editor modifications in `editor.js`, including importing additional packages from `@wordpress/*` or custom scripts.

### Custom Blocks

Because we're already using `@wordpress/scripts` to build our theme, we can also use it to build our custom blocks. 

To scaffold a new custom block, run `npm run create-block [block-name]` from the root directory to create a new block in the `./src/blocks` directory. The block will be namespaced to the theme: `block-theme`. 

For a dynamic block, run the command `npm run create-block:dynamic [block-name]`. You can also pass additional arguments to `@wordpress/create-block` using the extra `--` flag.

The `./blocks` directory contains all of compiled blocks, and new blocks that appear there are automatically registered in the theme.

## Linting, Prettier, and WordPress Coding Standards

PHP linting is available by running `composer php-lint` from the command line.

BlockTheme follows the WordPress Coding Standards. You can check your code against the standards by running `composer phpcs` from the command line. You can also run `composer phpcs-fix` to automatically fix any errors that can be fixed automatically.

The WordPress Prettier config is also included for JavaScript and SCSS files, but can be removed by deleting the `.prettierrc` file.

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
