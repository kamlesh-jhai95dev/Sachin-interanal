define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-rates-validation-rules',
        'I95Dev_CustomShipping/js/model/shipping-rates-validator',
        'I95Dev_CustomShipping/js/model/shipping-rates-validation-rules'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        upsShippingRatesValidator,
        upsShippingRatesValidationRules
    ) {
        'use strict';
        defaultShippingRatesValidator.registerValidator('ups', upsShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('ups', upsShippingRatesValidationRules);

        return Component;
    }
);
