define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'genome',
            component: 'Genome_Payment/js/view/payment/method-renderer/genome-method'
        }
    );

    return Component.extend({});
});
