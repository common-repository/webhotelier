(function ($) {
    "use strict";

    $(document).ready(function () {
        const forms = document.querySelectorAll(".wp-webhotelier form");
        for (let index = 0; index < forms.length; index++) {
            const form = forms[index];
            const checkIn = form.querySelector('input[name="checkin"]');
            const checkOut = form.querySelector('input[name="checkout"]');
            const defaultDate = getDefaultDate(form);
            const openingDate = new Date(form.dataset.openingDate);
            const closingDate = new Date(form.dataset.closingDate);
            flatpickr(checkIn, {
                enable: [
                    function (date) {
                        if (date.getMonth() > openingDate.getMonth() && date.getMonth() < closingDate.getMonth()) {
                            return true;
                        }
                        if (date.getMonth() == openingDate.getMonth() && date.getDate() >= openingDate.getDate()) {
                            return true;
                        }
                        if (date.getMonth() == closingDate.getMonth() && date.getDate() <= closingDate.getDate()) {
                            return true;
                        }
                        return;
                    }
                ],
                locale: wp_webhotelier_js_settings.flatpickr_l10n,
                disableMobile: "true",
                minDate: defaultDate,
                defaultDate: defaultDate,
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: wp_webhotelier_js_settings.calendar_date_format,
                onChange: function (selectedDate) {
                    if (checkOut) {
                        selectedDate[0].setDate(selectedDate[0].getDate() + 1);
                        checkOut._flatpickr.set("minDate", selectedDate[0]);
                        checkOut._flatpickr.setDate(selectedDate[0]);
                    }
                },
                onReady: function (selectedDates, dateStr, instance) {
                    if (instance.altInput.title) {
                        return;
                    }
                    instance.altInput.title = instance.input.id;
                }
            });

            if (checkOut) {
                flatpickr(checkOut, {
                    enable: [
                        function (date) {
                            if (date.getMonth() > openingDate.getMonth() && date.getMonth() < closingDate.getMonth()) {
                                return true;
                            }
                            if (date.getMonth() == openingDate.getMonth() && date.getDate() >= openingDate.getDate()) {
                                return true;
                            }
                            if (date.getMonth() == closingDate.getMonth() && date.getDate() <= closingDate.getDate()) {
                                return true;
                            }
                            return;
                        }
                    ],
                    locale: wp_webhotelier_js_settings.flatpickr_l10n,
                    disableMobile: "true",
                    defaultDate: incrementDate("+1d", new Date(defaultDate)),
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: wp_webhotelier_js_settings.calendar_date_format,
                    onReady: function (selectedDates, dateStr, instance) {
                        if (instance.altInput.title) {
                            return;
                        }
                        instance.altInput.title = instance.input.id;
                    }
                });

            }
        }
    });
})(jQuery);

function incrementDate(incString, dateString) {
    if (!dateString) {
        dateString = new Date();
    }
    const dateChar = incString.slice(-1);
    let multiplier = 1;
    const inc = parseInt(incString.slice(1, -1));
    switch (dateChar) {
        case "d":
            multiplier = 1;
            break;
        case "w":
            multiplier = 7;
            break;
    }

    dateString.setDate(dateString.getDate() + inc * multiplier);
    return dateString;
}

function getDefaultDate(form) {
    let defaultDate = incrementDate("+1d", new Date());
    if (form.dataset.defaultDate) {
        defaultDate = form.dataset.defaultDate
    }
    return defaultDate;
}