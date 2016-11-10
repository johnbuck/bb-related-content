jQuery(function($) {
    $('.fl-rc-module-dropdown').change(function() {
        var el = $(this), op = $(['option[value="',el.val(),'"]'].join(''), el), url = op.data('url');

        console.log( el );
        console.log( op );
        console.log( url );

        if ( url ) {
            window.location.replace( url );
        }
    });
});