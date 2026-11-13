( function ( wp ) {
	var __ = wp.i18n.__;
	var registerBlockStyle = wp.blocks.registerBlockStyle;

	registerBlockStyle( 'core/list', {
		name: 'none-style',
		label: __( 'No marker', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'white-circle-mark-list-style',
		label: __( 'Open circle', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'large-white-circle-mark-list-style',
		label: __( 'Large open circle', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'asterisk-list-style',
		label: __( 'Numbers with reference mark', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'brackets-list-style',
		label: __( 'Numbers in parentheses', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'numbered-circle-mark-list-style',
		label: __( 'Circled numbers', 'block-editor-customize' ),
	} );

	registerBlockStyle( 'core/list', {
		name: 'subnumbered-hyphen-mark-list-style',
		label: __( 'Sub-numbers (hyphen)', 'block-editor-customize' ),
	} );
} )( window.wp );
