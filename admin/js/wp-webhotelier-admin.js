jQuery(document).ready(function ($) {
    "use strict";

    const checkout_date = $(document).find('select[id*="checkout-date"]');
    $(document).on('change', 'select[id*="checkout-date"]', showNightsOrCheckout);
    $(checkout_date).trigger("change"); //Initialize maximumn number nights in correct state

    $(document).on(
        "click",
        "div[data-dismissible].wp-webhotelier-notice button.notice-dismiss",
        function (event) {
            event.preventDefault();
            let $this = $(this);

            let attr_value, option_name, dismissible_length, data;

            attr_value = $this
                .parent()
                .attr("data-dismissible")
                .split("-");

            dismissible_length = attr_value.pop();

            option_name = attr_value.join("-");

            data = {
                action: "dismiss_admin_notice_wp-webhotelier",
                option_name: option_name,
                dismissible_length: dismissible_length,
                nonce: dismissible_notice.nonce
            };

            $.post(ajaxurl, data);
        }
    );
    function showNightsOrCheckout(el) {
        var nightSelectElements = el.target.closest('.widget-content').querySelectorAll("[for$='max-nights'], [for$='default-nights']");
        for (let index = 0; index < nightSelectElements.length; index++) {
            const element = nightSelectElements[index];
            if ($(el.target).find(":checked").val() == "1") {
                $(element.parentElement).hide(500);
            } else {
                $(element.parentElement).show(500);
            }
        }
    }
});
