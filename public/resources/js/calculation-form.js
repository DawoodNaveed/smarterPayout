let gp = 'GP';
$(document).ready(function () {
    // init datepicker
    $(function () {
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
        }).datepicker('update', null);
    });

    $(document).on('click', '#termsAndConditions', function () {
        if ($('#termsAndConditions').is(':checked')) {
            $('#submitCalculation').attr('disabled', false);

        } else {
            $('#submitCalculation').attr('disabled', true);
        }
    });

    // submit button on the base of product type
    append_calculate_submit_button();
    $("#calculator_form_productType").on('change', function () {
        var productType = $(this).find(":selected").text();
        var paymentEndDate = $('#calculator_form_paymentEndDate');
        var paymentStartDate = $('#calculator_form_paymentStartDate');
        paymentEndDate.val(null);
        paymentEndDate.removeClass("filled");
        paymentEndDate.parents(".form-group").removeClass("focused");
        paymentStartDate.val(null);
        paymentStartDate.removeClass("filled");
        paymentStartDate.parents(".form-group").removeClass("focused");
        $('#endDate-alert .alert').remove();
        if (productType === gp) {
            $('.gp-hide').css('display', 'none');
            paymentEndDate.css('pointer-events', 'none');
            paymentEndDate.next('span').css('pointer-events', 'none');
        } else {
            $('.gp-hide').css('display', 'block');
            paymentEndDate.css('pointer-events', 'all');
        }
        append_calculate_submit_button();
    });

    //  function to append submit button
    function append_calculate_submit_button() {
        var element = `<div class="col-lg-12 pt-3 dynamic-buttons">
                                                        <div class="form-group mt-sm-0 d-flex d-inline">
                                                            <input type="checkbox" class="mt-1 mr-2"
                                                                   id="termsAndConditions">
                                                            <p><small> By clicking the button I Agree and Submit, you
                                                                    authorize us to contact you(including using
                                                                    autodialers,
                                                                    automated text and pre recorded messages) via your
                                                                    telephone, cellphone, mobile device (including SMS
                                                                    and
                                                                    MMS) and email, even if your telephone number is
                                                                    currently listed on any state, federal or company's
                                                                    Do
                                                                    Not Call list. Standard phone and data charges will
                                                                    apply. Your consent to the above terms is not
                                                                    required
                                                                    as a condition of purchasing or receiving our
                                                                    services.
                                                                    You also consent to the recording and monitoring of
                                                                    all
                                                                    calls to and from us, and you acknowledge and agree
                                                                    to
                                                                    the terms of our <a href="">Privacy Policy</a> and
                                                                    our
                                                                    Terms of Use.</small></p>
                                                        </div>
                                                        <button id="paymentInfoPrev"
                                                                data-toggle="collapse"
                                                                data-target="#collapseAccountInfo"
                                                                aria-expanded="true"
                                                                aria-controls="collapseAccountInfo"
                                                                type="button"
                                                                class="btn btn-outline-custom-default btn-default-custom  float-left pl-3 pr-3 pt-1 pb-1 mt-2 mb-2">
                                                            Prev
                                                        </button>
                                                        <button id="submitCalculation" class="btn btn-outline-custom-default btn-success-custom float-right pl-3 pr-3 pt-1 pb-1 mt-1 mb-2"
                                                                disabled="disabled">
                                                            Submit
                                                        </button>
                                                        <button id="hiddenSubmitButton" class="btn btn-outline-custom-default btn-success-custom float-right pl-3 pr-3 pt-1 pb-1 mt-1 mb-2"
                                                                disabled="disabled" type="submit" hidden>
                                                            Submit
                                                        </button>
                                                    </div>`;
        var productType = $('#calculator_form_productType').find(":selected").text();
        if (productType === gp) {
            $('.dynamic-buttons').remove();
            $('#calculate_submit_top').append(element);
            $('#paymentInfoNext').attr('hidden', true);
        } else {
            $('.dynamic-buttons').remove();
            $('#calculate_submit_bottom').append(element);
            $('#paymentInfoNext').attr('hidden', false);
        }
    }

    // set weight on the basis of manual weight and height
    $('#calculator_form_height, #manualWeight').on('focusout', function () {
        var height = $('#calculator_form_height').val();
        var weight = $('#manualWeight').val();
        if (height && weight) {
            var heightArray = height.split(".");
            var feet = heightArray[0];
            var decimal = heightArray[1];
            var value = ((703 * Number(weight)) / Math.pow((Number(feet * 12) + Number(decimal)), 2)).toFixed(2);
            if (value <= 17.50) {
                $('#calculator_form_weight').val(1);
            } else if (value >= 17.60 && value <= 21.00) {
                $('#calculator_form_weight').val(0);
            } else if (value >= 21.10 && value <= 26.00) {
                $('#calculator_form_weight').val(2);
            } else if (value >= 26.10 && value <= 31.00) {
                $('#calculator_form_weight').val(3);
            } else if (value >= 31.10) {
                $('#calculator_form_weight').val(4);
            }
        }
    });

    //  manual weight input field, if user select "Prefer To Put Manually"
    $('#calculator_form_weight').on('change', function () {
        if ($(this).find(':selected').text() === 'Prefer To Put Manually') {
            $('.manualWeight-hide').css('display', 'block')
        } else {
            $('.manualWeight-hide').css('display', 'none')
        }
    });

    // set End date on the basis of product type and start date
    $('#calculator_form_paymentStartDate').on('focusout blur keyup change', function () {
        var productType = $('#calculator_form_productType').find(":selected").text();
        if (productType && $(this).val()) {
            var nextDate = new Date($(this).val());
            nextDate.setFullYear(nextDate.getFullYear() + 10);
            var paymentEndDate = $('#calculator_form_paymentEndDate');
            paymentEndDate.datepicker({
                format: 'mm-dd-yyyy'
            }).datepicker('update', nextDate);
            paymentEndDate.attr('disabled', true);
            paymentEndDate.addClass("filled");
            paymentEndDate.parents(".form-group").addClass("focused");
            paymentEndDate.next('span').css('pointer-events', 'none');
        } else {
            var gender = $('#calculator_form_gender').find(":selected").text();
            if (!gender) {
                gender = "Male";
            }
            var age = $('#calculator_form_age').val();
            if (age && gender) {
                $.get(`/user/endDate/${gender}/${age}`, function (data) {
                    var paymentEndDate = $('#calculator_form_paymentEndDate');
                    paymentEndDate.datepicker({
                        dateFormat: 'mm/dd/yyyy'
                    }).datepicker('update', data['cutOffData']);
                    paymentEndDate.attr('disabled', true);
                    paymentEndDate.addClass("filled");
                    paymentEndDate.parents(".form-group").addClass("focused");
                    var alertData = '<div class="alert alert-info alert-dismissible fade show col-12" role="alert">' + 'You can select any date before ' + data['cutOffData'] + ' as End date ' + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + '<span aria-hidden="true">&times;</span>' + '</button>' + '</div>';
                    $('#endDate-alert .alert').remove();
                    $('#endDate-alert').append(alertData);
                });
            }
        }
    });

    //  accordion cards validations
    var allNextBtn = $('.btn-next');
    allNextBtn.click(function (e) {
        var curStep = $(this).closest(".accordion-card"),
            curInputs = curStep.find("input.form-input, select.form-input"),
            isValid = true;
        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid && curInputs[i].required) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }
        if (!isValid) {
            e.stopPropagation();
        } else {
            curStep.find('.card-header').removeClass('disabled');
            e.returnValue = true;
        }
    });


});