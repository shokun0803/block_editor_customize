=== Block editor customize ===
Contributors: shokun
Tags: block editor, list, list style, definition list
Requires at least: 6.3
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 0.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds extra styles to the List block and definition list (dl / dt / dd) blocks to the block editor.

== Description ==

This plugin extends the WordPress block editor.

= List block styles =

Adds the following styles to the core List block. They are applied both in the editor and on the front end.

* No marker
* Open circle
* Large open circle
* Numbers with reference mark
* Numbers in parentheses
* Circled numbers
* Sub-numbers (hyphen)

A style applies only to the items of the list it is set on. Nested lists keep their own style.

= Definition list blocks =

Adds blocks for `dl`, `dt`, `dd` and `div` elements.

* DL Tag
* DT Tag
* DD Tag
* DD Tag (Use HTML) - a `dd` element that can contain other blocks
* DIV Tag - groups `dt` / `dd` elements inside a `dl` element

These blocks use the same block names and markup as the Simple Definition List Blocks plugin, so content created with that plugin keeps working after it is deactivated. While that plugin is active, its blocks are used and these blocks are not registered.

== Frequently Asked Questions ==

= Where can I choose a list style? =

Select the List block (not a list item), open the block settings sidebar and choose a style in the Styles tab.

== Changelog ==

= 0.0.4 =
* Add definition list blocks.
* Apply list styles only to the direct items of the selected list.
* Make the plugin translatable and add Japanese translation.
