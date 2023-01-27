# Tangent

Tangent is a new starter theme (currently in development) from Understrap. Tangent combines the core values of Understrap, but is also a radical departure from the Understrap toolset.

A few similarities:

- Sensible defaults.
- A fast scaffold for custom development.
- A modern build process.
- A "hybrid" (non-FSE) WordPress theme that still uses PHP but embraces the Block Editor.
- Reusable components that are _extremely_ well documented.

And some differences:

- Gutenberg/block-first from the ground up
- No more Underscores or Bootstrap 😮 
- Works _with_ the design language of Gutenberg, instead of against it
- Approachable, but modern, PHP best practices

## Build Process

Probably something with webpack and @wordpress/scripts...

## File/Folder Structure

```
├── blocks
├── includes
│   ├── enqueue.php
│   ├── setup.php
├── parts
├── src
│   ├── css
│   ├── js
├── templates
├── functions.php
├── index.php
├── node_modules
├── package.json
├── package-lock.json 
├── style.css
└── .gitignore
```
