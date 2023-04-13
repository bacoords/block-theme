# Using the functions found in the `props.scss` file
These functions help you generate the correct CSS Custom Properties for design tokens set in `theme.json`.

## Usage
All functions work as follows:

You `@use "../abstracts/props.scss";` in the file you want to use these functions.

Both functions take the following arguments:

- `$type`: this is the type of property you want to access, typically the name of the file inside `theme-json` folder.
- `$key` (optional): this is the name of the property you want to access, typically inside the `.jsonc` file in `theme-json` folder.
- `$default` (optional): an optional default you can provide if the variable isn't set.

### Example 1

Let's say you want to access the `wide` property inside the `custom` section under `contentSizes`, you would call it like this:

```scss
@use "../abstracts/props.scss";

.my-class {
    width: props.custom("content-sizes", "wide");
}
```
(All camelCase names are transformed into kebab-case within CSS.)

If you wanted to provide a default in case the variable wasn't defined you would do it like this:

```scss
@use "../abstracts/props.scss";

.my-class {
    width: props.custom("content-sizes", "wide", 1200px);
}
```

### Example 2

Let's say you wanted to access the `blockGap` property inside the `custom` section:

```scss
@use "../abstracts/props.scss";

.my-class {
    gap: props.custom("block-gap");
}
```
If you wanted to provide a default in case the variable wasn't defined you would do it like this:

```scss
@use "../abstracts/props.scss";

.my-class {
    gap: props.custom("block-gap", null, 1rem);
}
```

### Example 3

Let's say you wanted to access the `primary` colour from the palette set in `theme.json`. We know that all colours in `theme.json`'s palette section start with `wp--preset--color--`, so this makes our `$key` be `color`, and any CSS Custom Property set from the `settings` section (other than the `custom` section) is called a `preset`:

```scss
@use "../abstracts/props.scss";

.my-class {
    background-color: props.preset("color", "primary");
}
```

### Example 4

Let's say you wanted to access the `root` `padding-right` property from the styles set in `theme.json`. We know that all the root padding settings in in `theme.json`'s `styles` section start with `wp--style--root--`, so this makes our `$key` be `root`, and any CSS Custom Property set from the `styles` section (other than the `custom` section) is called a `style`:

```scss
@use "../abstracts/props.scss";

.my-class {
    padding-right: props.style("root", "padding-right");
}
```