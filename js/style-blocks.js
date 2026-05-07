(function () {
    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'none-style',
        label: 'リストスタイルなし',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'white-circle-mark-list-style',
        label: '単純白丸',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'large-white-circle-mark-list-style',
        label: '大きい白丸',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'asterisk-list-style',
        label: '米印付数字',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'brackets-list-style',
        label: '括弧付き数字',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'numbered-circle-mark-list-style',
        label: '白丸付き数字',
    } );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'subnumbered-hyphen-mark-list-style',
        label: 'サブ番号（ハイフン）',
    } );
})();
