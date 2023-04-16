# Using the function found in the `props.scss` file
The `ref` function help you generate the correct CSS Custom Properties for design tokens set in `theme.json`.

## Usage
Here's how you use the `ref` funciton.

You `@use "../utils";` in the file you want to use these function in, or you can pull in the `props.scss` file in specifically with `@use "../utils/props"`, adjusting the relative path as needed.

The function takes a single argument in dot notation that reflects where that design token is found in `theme.json`.

For example, to reference the design token for the `primary` colour in `theme.json` settings, we know that anything in `settings` (that isn't inside `custom`) is referenced to as a `preset`, and then within the `color` set, we find the `primary` color defined:

```scss
@use "../utils";
.my-class {
	font-size: ref("preset.fontSize.small");
}
```

### Example 1

Let's say you want to access the `wide` property inside the `custom` section under `contentSizes`, you would call it like this:

```scss
@use "../utils";

.my-class {
    width: utils.ref("custom.contentSizes.wide");
}
```

### Example 2

Let's say you wanted to access the `blockGap` property inside the `custom` section:

```scss
@use "../utils";

.my-class {
    gap: utils.ref("custom.blockGap");
}
```

### Example 4

Let's say you wanted to access the `root` `padding-right` property from the styles set in `theme.json`. We know that all the root padding settings in in `theme.json`'s `styles` section start with `wp--style--root--`, so this makes our first `key` be `style`, the second `key` be `root`, and the last key is `paddingRight`.

```scss
@use "../utils";

.my-class {
    padding-right: utils.ref("style.root.paddingRight");
}
```