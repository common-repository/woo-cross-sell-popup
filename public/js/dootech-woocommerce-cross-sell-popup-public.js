(function( $ ) {
	'use strict';

    $('.woocommerce .cross-sells .close, .woocommerce .cross-sells .continue').on('click', function () {

        $('.woocommerce .cross-sells').css('display', 'none');
        $('.dt-loading-overlay').fadeOut();
        $(this).remove();
    });

})( jQuery );


