define([
    'jquery'
], function ($) {
    'use strict';

    return function (options, element) {
        const $el = $(element);

        /**
         * Add easyflags to mobile switcher in drawer.
         */
        $el.find('[data-store-code]').each(function () {
            var code = $(this).data('storeCode');

            $('#store\\\.settings')
                .find('.view-' + code)
                .find('a, span')
                .html($(this).html());
        });

        $('#store\\\.settings')
            .find('.switcher-language')
            .addClass('easyflags');

        /**
         * Initialize click on store switcher for desktop.
         * Use data from mobile switcher to redirect to proper store view.
         *
         * This solution should work for all Magento stores with
         * store switcher in mobile drawer. But is case it doesn't work then
         * uncomment block in layout with post data. And implement store switch
         * with `mage/dataPost`.
         */
        $el.on('click', '[data-store-code]', (event) => {
            const storeCode = $(event.currentTarget).data('storeCode');
            const url = $('#store\\\.settings').find(`.view-${storeCode} a`).attr('href');

            if (url) {
                event.preventDefault();
                window.location = url;
            }
        });
    };
});
