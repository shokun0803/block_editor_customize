(function () {
    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'none-style',
        label: 'リストスタイルなし',
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
})();
