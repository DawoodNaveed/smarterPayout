$(document).ready(function() {
    var calculator_form_phoneNo = document.querySelector("#calculator_form_phoneNo_manual");
    var iti_calculator_form_phoneNo = window.intlTelInput(calculator_form_phoneNo, ({
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        autoHideDialCode: false,
        initialCountry: "auto",
        formatOnDisplay: true,
        separateDialCode: true,
        autoPlaceholder:"polite",
        geoIpLookup: function(success, failure) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js",
    }));
    $('#calculator_form_phoneNo_manual').on('focusout', function() {
        $('#phoneNo-error-msg').remove();
        if(iti_calculator_form_phoneNo.getNumber()) {
            if(!iti_calculator_form_phoneNo.isValidNumber()) {
                $(this).closest('.form-group').append(`<span id="phoneNo-error-msg" class="text-danger">Invalid phone number</span>`);
                $(this).closest('.form-group').addClass('has-error');
            } else {
                $('#calculator_form_phoneNo').val(iti_calculator_form_phoneNo.getNumber());
                $(this).closest('.form-group').removeClass('has-error');
            }
        }
    });
    var contact_us_form_contact = document.querySelector("#contact_us_form_contact_manual");
    var iti_contact_us_form_contact = window.intlTelInput(contact_us_form_contact, ({
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        autoHideDialCode: false,
        initialCountry: "auto",
        formatOnDisplay: true,
        hiddenInput: "full_number",
        separateDialCode: true,
        geoIpLookup: function(success, failure) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js",
    }));
    $('#contact_us_form_contact_manual').on('focusout', function() {
        $('#phoneNo-error-msg').remove();
        if(iti_contact_us_form_contact.getNumber()) {
            if(!iti_contact_us_form_contact.isValidNumber()) {
                $(this).closest('.form-group').append(`<span id="phoneNo-error-msg" class="text-danger">Invalid phone number</span>`);
                $(this).closest('.form-group').addClass('has-error');
            } else {
                $('#contact_us_form_contact').val(iti_contact_us_form_contact.getNumber());
                $(this).closest('.form-group').removeClass('has-error');
            }
        }
    });
    var inp_otp_phone = document.querySelector("#inp-otp-phone-manual");
    var iti_inp_otp_phone = window.intlTelInput(inp_otp_phone, ({
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        autoHideDialCode: false,
        initialCountry: "auto",
        formatOnDisplay: true,
        hiddenInput: "full_number",
        separateDialCode: true,
        geoIpLookup: function(success, failure) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js",
    }));
    $('#inp-otp-phone-manual').on('focusout', function() {
        $('#phoneNo-error-msg').remove();
        if(iti_inp_otp_phone.getNumber()) {
            if(!iti_inp_otp_phone.isValidNumber()) {
                $(this).closest('.form-group').append(`<span id="phoneNo-error-msg" class="text-danger">Invalid phone number</span>`);
                $(this).closest('.form-group').addClass('has-error');
            } else {
                $('#inp-otp-phone').val(iti_inp_otp_phone.getNumber());
                $(this).closest('.form-group').removeClass('has-error');
            }
        }
    });
    $('.phone-input').on('focusin', function() {
        $('#phoneNo-error-msg').remove();
        $(this).closest('.form-group').removeClass('has-error');
    });
    $(".phone-input").on("countrychange", function(e, countryData) {
        $(this).val('');
        var mask = $(this).attr('placeholder').replace(/[0-9]/g, 0);
        $(this).mask(mask);
    });
})