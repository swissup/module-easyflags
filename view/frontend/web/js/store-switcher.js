define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, Modal) {
    'use strict';

    $.widget('swissup.easyflagsStoreSwitcher', {

        component: 'Swissup_Easyflags/js/store-switcher',

        _create: function () {
            this._super();

            this.$storeSettings = $('#store\\\.settings');
            this._initMobileDrawer();

            this._on({
                'click .switcher-trigger': () => $('.easyflags .switcher-popup').trigger('openModal')
            })

            // Use global listener on body because popup rendered outside of element
            $('body').on(
                'click',
                '.easyflags a[data-store-code]',
                this._switchStoreEvent.bind(this)
            );
        },

        _switchStoreEvent: function (event) {
            const store = $(event.currentTarget).data('storeCode');
            const url = this.getStoreUrl(store);

            if (url) {
                event.preventDefault();
                window.location = url;
            }
        },

        _initMobileDrawer: function () {
            const $el = $(this.element);
            const me = this;

            $el.find('[data-store-code]').each((index, item) => {
                const $item = $(item);

                me.$storeSettings
                    .find('.view-' + $item.data('storeCode'))
                    .find('a, span')
                    .html($item.html());
            });

            me.$storeSettings
                .find('.switcher-language')
                .addClass('easyflags');
        },

        getStoreUrl: function (storeCode) {
            // Find redirect url in mobile drawer.
            // Or in script with ID "easyflags-urls".
            return (
                this.$storeSettings.find(`.view-${storeCode} a`).attr('href') ||
                JSON.parse($('#easyflags-urls').html() || '{}')[storeCode]
            );
        },

        _destroy: function () {
            $('body').off('click', '.easyflags a[data-store-code]');

            this._super();
        }
    });

    return $.swissup.easyflagsStoreSwitcher;
});
