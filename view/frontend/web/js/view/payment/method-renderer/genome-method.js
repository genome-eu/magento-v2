define(
    [
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/full-screen-loader',
        'mage/url',
    ],
    function (Component,fullScreenLoader,url) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Genome_Payment/genome'
            },
            redirectAfterPlaceOrder: false,
            redirectUrl: window.checkoutConfig.payment.genome.genomeRedirectUrl,

            /**
             * After place order callback
             */
            afterPlaceOrder: function () {
                fullScreenLoader.startLoader();
                window.location.replace(url.build(this.getRedirectUrl()));
            },

            /**
             * Return redirect URL
             *
             * @returns {String}
             * @private
             */
            getRedirectUrl: function () {
                return this.redirectUrl;
            },
        });
    },
);
