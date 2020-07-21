define([
    'jquery'
], function ($) {
    'use strict';

    /**
     * Add easyflags to mobile.
     */
    return function () {
        $('.easyflags.switcher, .easyflags.modal-popup')
            .find('[data-store-code]')
            .each(function () {
                var code = $(this).data('storeCode');

                $('#store\\\.settings')
                    .find('.view-' + code)
                    .find('a, span')
                    .html($(this).html());
            });

        $('#store\\\.settings')
            .find('.switcher-language')
            .addClass('easyflags');
    };
});
