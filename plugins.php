<?php
/**
 * Plugin Name:       Block editor customize
 * Description:       Adds extra styles to the List block and definition list (dl / dt / dd) blocks to the block editor.
 * Version:           0.0.5
 * Requires at least: 6.3
 * Requires PHP:      7.4
 * Author:            shokun
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       block-editor-customize
 * Domain Path:       /languages
 *
 * @package block-editor-customize
 */

/*  Copyright 2022 shokun

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 翻訳ファイルを読み込む。
 */
function block_editor_customize_load_textdomain() {
	load_plugin_textdomain( 'block-editor-customize', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'block_editor_customize_load_textdomain' );

/**
 * アセットの URL を返す。
 *
 * @param string $file プラグインディレクトリからの相対パス。
 * @return string
 */
function block_editor_customize_asset_url( $file ) {
	return plugin_dir_url( __FILE__ ) . $file;
}

/**
 * アセットのバージョン（ファイルの更新日時）を返す。
 *
 * @param string $file プラグインディレクトリからの相対パス。
 * @return string
 */
function block_editor_customize_asset_version( $file ) {
	return (string) filemtime( plugin_dir_path( __FILE__ ) . $file );
}

/**
 * スタイルを登録する。
 */
function block_editor_customize_register_assets() {
	wp_register_style(
		'block-editor-customize-list-style',
		block_editor_customize_asset_url( 'css/block-style.css' ),
		array(),
		block_editor_customize_asset_version( 'css/block-style.css' )
	);
	wp_register_style(
		'block-editor-customize-list-style-editor',
		block_editor_customize_asset_url( 'css/block-editor.css' ),
		array(),
		block_editor_customize_asset_version( 'css/block-editor.css' )
	);
}
add_action( 'init', 'block_editor_customize_register_assets' );

/**
 * リストブロックのスタイル選択肢を追加するスクリプトを読み込む（エディター画面）。
 */
function block_editor_customize_enqueue_editor_scripts() {
	wp_enqueue_script(
		'block-editor-customize-list-styles',
		block_editor_customize_asset_url( 'js/style-blocks.js' ),
		array( 'wp-blocks', 'wp-i18n' ),
		block_editor_customize_asset_version( 'js/style-blocks.js' ),
		true
	);
	wp_set_script_translations( 'block-editor-customize-list-styles', 'block-editor-customize', plugin_dir_path( __FILE__ ) . 'languages' );
}
add_action( 'enqueue_block_editor_assets', 'block_editor_customize_enqueue_editor_scripts' );

/**
 * エディターのコンテンツ用 CSS を読み込む。
 *
 * enqueue_block_assets はエディターの iframe 内でも実行されるため、
 * ここで読み込むとエディターのコンテンツにスタイルが適用される。
 */
function block_editor_customize_enqueue_editor_content_styles() {
	if ( is_admin() ) {
		wp_enqueue_style( 'block-editor-customize-list-style-editor' );
	}
}
add_action( 'enqueue_block_assets', 'block_editor_customize_enqueue_editor_content_styles' );

/**
 * 前面用 CSS を読み込む。
 *
 * ブロックのアセットを必要なときだけ読み込むテーマでは、リストブロックの表示時に読み込む
 * （block_editor_customize_enqueue_list_style_on_render()）。
 */
function block_editor_customize_enqueue_front_styles() {
	// wp_should_load_block_assets_on_demand() は WordPress 6.8 以降。
	$on_demand = function_exists( 'wp_should_load_block_assets_on_demand' )
		? wp_should_load_block_assets_on_demand()
		: wp_should_load_separate_core_block_assets();
	if ( ! $on_demand ) {
		wp_enqueue_style( 'block-editor-customize-list-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'block_editor_customize_enqueue_front_styles' );

/**
 * スタイルを指定したリストブロックの表示時に前面用 CSS を読み込む。
 *
 * @param string $block_content ブロックの HTML。
 * @return string
 */
function block_editor_customize_enqueue_list_style_on_render( $block_content ) {
	if ( ! is_admin() && false !== strpos( $block_content, 'is-style-' ) ) {
		wp_enqueue_style( 'block-editor-customize-list-style' );
	}
	return $block_content;
}
add_filter( 'render_block_core/list', 'block_editor_customize_enqueue_list_style_on_render' );

/**
 * 定義リスト（dl / dt / dd / div）ブロックを登録する。
 *
 * Simple Definition List Blocks と同じブロック名で登録し、既存のコンテンツを引き継ぐ。
 * 同プラグインが有効な間は、そちらの登録を優先して何もしない。
 */
function block_editor_customize_register_definition_list_blocks() {
	$registry = WP_Block_Type_Registry::get_instance();
	if ( $registry->is_registered( 'simple-definition-list-blocks/list' ) ) {
		return;
	}

	wp_register_script(
		'block-editor-customize-definition-list',
		block_editor_customize_asset_url( 'js/definition-list-blocks.js' ),
		array( 'wp-blocks', 'wp-block-editor', 'wp-element', 'wp-i18n' ),
		block_editor_customize_asset_version( 'js/definition-list-blocks.js' ),
		true
	);
	wp_set_script_translations( 'block-editor-customize-definition-list', 'block-editor-customize', plugin_dir_path( __FILE__ ) . 'languages' );

	wp_register_style(
		'block-editor-customize-definition-list-editor',
		block_editor_customize_asset_url( 'css/definition-list-editor.css' ),
		array(),
		block_editor_customize_asset_version( 'css/definition-list-editor.css' )
	);

	$blocks = array( 'definition-list', 'definition-div', 'definition-term', 'definition-details', 'definition-details-html' );
	foreach ( $blocks as $block ) {
		register_block_type( plugin_dir_path( __FILE__ ) . 'blocks/' . $block );
	}
}
add_action( 'init', 'block_editor_customize_register_definition_list_blocks', 20 );
