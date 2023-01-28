# How to create a theme.json from partials

## Why?

A complex `theme.json` file can be intimidating and difficult to work with. Instead, following in the footsteps of `SASS`, we use `.json` partials to split up the different sections of `theme.json` and add helpful inline comments and documentation to them.

 There are also other concrete advantages to approaching the `theme.json` file in this way, for development purposes:

- It is much easier to understand and process `theme.json` in small sections.
- Editing any `theme.json` partial leads to cleaner individual git history and more helpful commits.

## Example

Let's take a look at a simple `theme.json` file:

### theme.json
```json
{
  "version": "2",
  "settings": {
    "color": {
      "palette": [
        {
          "name": "Primary",
          "slug": "primary",
          "color": "#f28400"
        },
        {
          "name": "Secondary",
          "slug": "secondary",
          "color": "#619237"
        },
        {
          "name": "Dark",
          "slug": "dark",
          "color": "#222222"
        },
        {
          "name": "Light",
          "slug": "light",
          "color": "#fff6ed"
        }
      ]
    }
  }
}
```

This file can be broken up by each `key` (version, settings, color, palette):

### themejson/version.jsonc

```jsonc
/* This is the theme.json API version. */
"2"
```
### themejson/settings/color/palette.jsonc

```jsonc
/* This is the custom palette for the theme. */
[
	{
		"name": "Primary",
		"slug": "primary",
		"color": "#f28400"
	},
	{
		"name": "Secondary",
		"slug": "secondary",
		"color": "#619237"
	},
	{
		"name": "Dark",
		"slug": "dark",
		"color": "#222222"
	},
	{
		"name": "Light",
		"slug": "light",
		"color": "#fff6ed"
	}
]
```
