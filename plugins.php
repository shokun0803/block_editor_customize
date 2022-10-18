<?php
/*
Plugin Name: Block editor customize
Version: 0.0.1
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
