<?php
/*
Plugin Name: Block editor customize
Version: 0.0.3
Author: shokun
License: GPL2
*/
/*  Copyright 2022 shokun

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
        published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// ブロックエディタ用のスクリプトを登録
function block_editor_enqueue() {
        $plugin_path = plugin_dir_path( __FILE__ );
        $plugin_url = plugin_dir_url( __FILE__ );
        wp_enqueue_script( 'block-style-script', $plugin_url . 'js/style-blocks.js', array( 'wp-blocks' ) );
        $filetime = date( "YmdHi", filemtime( $plugin_path . 'css/block-editor.css' ) );
        wp_enqueue_style( 'block-editor-css', $plugin_url . 'css/block-editor.css', array(), $filetime );
}
add_action( 'enqueue_block_editor_assets', 'block_editor_enqueue' );

// ユーザー表示用の CSS を登録
function block_list_style_css() {
        $plugin_path = plugin_dir_path( __FILE__ );
        $plugin_url = plugin_dir_url( __FILE__ );
        $filetime = date( "YmdHi", filemtime( $plugin_path . 'css/block-style.css' ) );
        wp_enqueue_style( 'block-style-css', $plugin_url . 'css/block-style.css', array(), $filetime );
}
add_action( 'wp_enqueue_scripts', 'block_list_style_css' );

// 定義リスト（dl / dt / dd / div）ブロックを登録
// Simple Definition List Blocks と同じブロック名で登録し、既存のコンテンツを引き継ぐ。
// 同プラグインが有効な間は、そちらの登録を優先して何もしない。
function block_editor_customize_register_definition_list_blocks() {
	$registry = WP_Block_Type_Registry::get_instance();
	if ( $registry->is_registered( 'simple-definition-list-blocks/list' ) ) {
		return;
	}

	$plugin_path = plugin_dir_path( __FILE__ );
	$plugin_url = plugin_dir_url( __FILE__ );

	wp_register_script(
		'block-editor-customize-definition-list',
		$plugin_url . 'js/definition-list-blocks.js',
		array( 'wp-blocks', 'wp-block-editor', 'wp-element' ),
		filemtime( $plugin_path . 'js/definition-list-blocks.js' )
	);
	wp_register_style(
		'block-editor-customize-definition-list-editor',
		$plugin_url . 'css/definition-list-editor.css',
		array(),
		filemtime( $plugin_path . 'css/definition-list-editor.css' )
	);

	$blocks = array( 'definition-list', 'definition-div', 'definition-term', 'definition-details', 'definition-details-html' );
	foreach ( $blocks as $block ) {
		register_block_type( $plugin_path . 'blocks/' . $block );
	}
}
add_action( 'init', 'block_editor_customize_register_definition_list_blocks', 20 );
