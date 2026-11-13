/**
 * 定義リスト（dl / dt / dd / div）ブロック
 *
 * Simple Definition List Blocks プラグインと同じブロック名・保存 HTML で登録し、
 * 既存のコンテンツをそのまま編集・表示できるようにする。
 * 属性や supports は PHP 側で block.json から登録される。
 */
( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var registerBlockType = wp.blocks.registerBlockType;
	var blockEditor = wp.blockEditor;
	var RichText = blockEditor.RichText;
	var InnerBlocks = blockEditor.InnerBlocks;
	var useBlockProps = blockEditor.useBlockProps;
	var useInnerBlocksProps = blockEditor.useInnerBlocksProps;

	var NS = 'simple-definition-list-blocks/';

	function icon( paths ) {
		return el(
			'svg',
			{ xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24' },
			paths.map( function ( d, i ) {
				return el( 'path', { key: i, d: d } );
			} )
		);
	}

	var icons = {
		list: icon( [
			'M4 16h10v1.5H4V16Zm0-4.5h16V13H4v-1.5ZM10 7h10v1.5H10V7Z',
			'm4 5.25 4 2.5-4 2.5v-5Z',
		] ),
		term: icon( [
			'm4 5.5h2v6.5h1.5v-6.5h2v-1.5h-5.5zm16 10.5h-16v-1.5h16zm-7 4h-9v-1.5h9z',
		] ),
		details: icon( [
			'M6.08 10.103h2.914L9.657 12h1.417L8.23 4H6.846L4 12h1.417l.663-1.897Zm1.463-4.137.994 2.857h-2l1.006-2.857ZM11 16H4v-1.5h7V16Zm1 0h8v-1.5h-8V16Zm-4 4H4v-1.5h4V20Zm7-1.5V20H9v-1.5h6Z',
		] ),
		div: icon( [
			'M18 4h-7c-1.1 0-2 .9-2 2v3H6c-1.1 0-2 .9-2 2v7c0 1.1.9 2 2 2h7c1.1 0 2-.9 2-2v-3h3c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-4.5 14c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5v-7c0-.3.2-.5.5-.5h3V13c0 1.1.9 2 2 2h2.5v3zm0-4.5H11c-.3 0-.5-.2-.5-.5v-2.5H13c.3 0 .5.2.5.5v2.5zm5-.5c0 .3-.2.5-.5.5h-3V11c0-1.1-.9-2-2-2h-2.5V6c0-.3.2-.5.5-.5h7c.3 0 .5.2.5.5v7z',
		] ),
	};

	// 子ブロックを持つコンテナ（dl / div / HTML 用 dd）
	function containerBlock( tagName, blockIcon, allowedBlocks ) {
		var innerOptions = {};
		if ( allowedBlocks ) {
			innerOptions.allowedBlocks = allowedBlocks;
			innerOptions.renderAppender = InnerBlocks.ButtonBlockAppender;
		}
		return {
			icon: blockIcon,
			edit: function () {
				return el(
					tagName,
					useInnerBlocksProps( useBlockProps(), innerOptions )
				);
			},
			save: function () {
				return el(
					tagName,
					useInnerBlocksProps.save( useBlockProps.save() )
				);
			},
		};
	}

	// テキストを直接入力する要素（dt / dd）
	function textBlock( tagName, blockIcon, placeholder ) {
		return {
			icon: blockIcon,
			edit: function ( props ) {
				return el(
					RichText,
					Object.assign( {}, useBlockProps(), {
						tagName: tagName,
						value: props.attributes.content,
						onChange: function ( content ) {
							props.setAttributes( { content: content } );
						},
						placeholder: placeholder,
					} )
				);
			},
			save: function ( props ) {
				return el(
					RichText.Content,
					Object.assign( {}, useBlockProps.save(), {
						tagName: tagName,
						value: props.attributes.content,
					} )
				);
			},
		};
	}

	var items = [ NS + 'term', NS + 'details', NS + 'details-html' ];

	var blocks = {
		list: containerBlock( 'dl', icons.list, items.concat( [ NS + 'div' ] ) ),
		div: containerBlock( 'div', icons.div, items ),
		'details-html': containerBlock( 'dd', icons.details ),
		term: textBlock( 'dt', icons.term, __( 'Enter the term (dt).', 'block-editor-customize' ) ),
		details: textBlock( 'dd', icons.details, __( 'Enter the description (dd).', 'block-editor-customize' ) ),
	};

	Object.keys( blocks ).forEach( function ( key ) {
		var name = NS + key;
		// 他のスクリプトで登録済みなら二重登録しない
		if ( wp.blocks.getBlockType( name ) ) {
			return;
		}
		registerBlockType( name, blocks[ key ] );
	} );
} )( window.wp );
