# Block editor customize plugin

A plugin to customize the WordPress block editor.

## Features

This plugin adds custom styles to the WordPress core List block and loads matching front-end styles so the selected appearance is reflected on published pages.

### List block styles

- no style
- simple open circle
- large open circle
- number style with asterisk
- number style with brackets
- number style with open circle
- subnumber style with hyphen

### Definition list blocks

Adds `dl` / `dt` / `dd` / `div` blocks that are compatible with the
[Simple Definition List Blocks](https://wordpress.org/plugins/simple-definition-list-blocks/) plugin.
The blocks use the same block names and saved markup, so existing content keeps working
after that plugin is deactivated.

- DL tag (`simple-definition-list-blocks/list`)
- DT tag (`simple-definition-list-blocks/term`)
- DD tag (`simple-definition-list-blocks/details`)
- DD tag that can contain blocks (`simple-definition-list-blocks/details-html`)
- DIV tag (`simple-definition-list-blocks/div`)

While Simple Definition List Blocks is active, its own blocks are used and these are not registered.

## Files

- `js/style-blocks.js`: registers custom List block styles in the block editor
- `css/block-editor.css`: applies the styles inside the block editor
- `css/block-style.css`: applies the styles on the front end
- `blocks/definition-*/block.json`: metadata for the definition list blocks
- `js/definition-list-blocks.js`: editor implementation of the definition list blocks
- `css/definition-list-editor.css`: editor-only styles for the definition list blocks
