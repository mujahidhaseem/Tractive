define([
    "jquery",
    'mage/url',
    "jquery/ui"
], function($, urlBuilder){
    "use strict";
    function main(config, element) {

        var customurl = config.AjaxUrl;
        $(document).ready(function(){
                $.ajax({
                    context: '#product_slider',
                    url: customurl,
                    type: "POST",
                }).done(function (data) {
                    $('#product_slider').html(data.result);
                    $('#product_slider').trigger('contentUpdated');
                    return true;
                });
        });
    }
    return main;
});