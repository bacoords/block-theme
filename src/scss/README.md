Using SCSS in Tangent
---------------------

Each folder should have an `index.scss` file that pulls in its partials. In the `editor.scss` and `global.scss` files you can import entire folders like so:

```scss
@use 'folderName';
```