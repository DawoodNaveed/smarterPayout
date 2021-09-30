let gp = 'GP';
let customerId = '';
let customerName = '';
let minValue = '';
let maxValue = '';
let beneficiaryProtection = '';

$(document).ready(function () {
    $('#calculate_result_modal').on('show.bs.modal', function () {
        setTimeout(function () {
            var resultSection = $('#calculation-result');
            var otpPhoneSection = $('#otp-phone-number');
            var otpCodeSection = $('#otp-code');
            if (resultSection.length > 0) {
                resultSection.remove();
                otpPhoneSection.attr('hidden', false);
            }
        }, 3000)

        $('.calculate_result_mobile_container').addClass('calculate_result_mobile_center');
    }).on('hide.bs.modal', function () {
        $('.calculate_result_mobile_container').addClass('calculate_result_mobile_right');

    });

    $('#calculate_result_modal').on('hidden.bs.modal', function () {
        location.reload();
    });

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

    $.fn.serializeObject = function () {
        var formObject = {};
        var array = this.serializeArray();
        $.each(array, function () {
            if (formObject[this.name] !== undefined) {
                if (!formObject[this.name].push) {
                    formObject[this.name] = [formObject[this.name]];
                }
                formObject[this.name].push(this.value || '');
            } else {
                formObject[this.name] = this.value || '';
            }
        });
        return formObject;
    };

    $(document).on('click', '#submitCalculation', function (e) {
        e.preventDefault();
        var curStep = $(this).closest(".accordion-card"),
            curInputs = curStep.find("input.form-input, select.form-input"),
            isValid = true;

        for (var i = 0; i < curInputs.length; i++) {
            if ($(curInputs[i]).hasClass('inp-required') && !$(curInputs[i]).val()) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            } else if (!curInputs[i].validity.valid && curInputs[i].required) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) {
            var form = $('form[name="calculator_form"]');
            if (!form[0].checkValidity()) {
                $("#hiddenSubmitButton").click();
                return false;
            }
            var form_data = form.serializeObject();

            $.ajax({
                url: '/',
                type: 'POST',
                dataType: 'json',
                data: form_data,
                success: function (data) {
                    if (Number(data['status']) === 200) {
                        customerId = data['data']['customerId'];
                        $('#min-amount').text(data['data']['min'].toFixed(2));
                        $('#max-amount').text(data['data']['max'].toFixed(2));
                        $('#beneficiary-amount').text(data['data']['beneficiaryProtection'].toFixed(2));
                        $('#client-name').text($('#calculator_form_firstName').val());
                        minValue = data['data']['min'].toFixed(2);
                        maxValue = data['data']['max'].toFixed(2);
                        beneficiaryProtection = data['data']['beneficiaryProtection'].toFixed(2);
                        customerName = $('#calculator_form_firstName').val();
                        $("#calculate_result_modal").modal('show');
                    } else {
                        alert(data['message']);
                    }

                    // signal to user the action is done
                }
            });
        }
    });

    $('#otp-code-submit').click(function () {
        var contact = $('#inp-otp-code').val();
        if (contact) {
            $.ajax({
                url: '/verify-otp',
                type: 'POST',
                data: {'id': customerId, 'code': contact},
                success: function (data) {
                    if (Number(data['status']) === 200) {
                        $('#otp-code').attr('hidden', true);

                        $('#calculation-result-container').append(` <div id="calculation-result">
                                                    <h4 class="text-center">Hello <span id="client-name">` + customerName + `</span>
                                                    </h4>
                                                    <p><b>Min: </b><span id="min-amount"> ` + minValue + `</span>$</p>
                                                    <p><b>Max: </b><span id="max-amount">` + maxValue + `</span>$</p>
                                                    <p><b>Beneficiary Protection:</b><span
                                                                id="beneficiary-amount">` + beneficiaryProtection + `</span>$</p>
                                                </div>`);
                    } else {
                        alert(data['message']);
                    }

                    // signal to user the action is done
                }
            });
        } else {
            alert('Please Enter a Phone Number');
        }
    });

    $('#otp-phone-submit').click(function () {
        var contact = $('#inp-otp-phone').val();
        if (contact) {
            $.ajax({
                url: '/send-otp',
                type: 'POST',
                data: {'id': customerId, 'contact': contact},
                success: function (data) {
                    if (Number(data['status']) === 200) {
                        $('#otp-phone-number').attr('hidden', true);
                        $('#otp-code').attr('hidden', false);
                    } else {
                        alert(data['message']);
                    }

                    // signal to user the action is done
                }
            });
        } else {
            alert('Please Enter a Phone Number');
        }
    });

    // submit button on the base of product type
    append_calculate_submit_button();
    $("#calculator_form_productType, #calculator_form_age,  #calculator_form_gender").on('change', function () {
        var productType = $('#calculator_form_productType').find(":selected").text();
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
        } else {
            $('.gp-hide').css('display', 'flex');
        }
        append_calculate_submit_button();
    });

    //  function to append submit button
    function append_calculate_submit_button() {
        var element = `<div class="col-lg-12 pt-3 dynamic-buttons">
                                                        <div class="form-group mt-sm-0 d-flex d-inline">
                                                            <input type="checkbox" class="mt-1 mr-2"
                                                                   id="termsAndConditions">
                                                            <p><small>I have read and agree to the <a href="">Terms and conditions</a>.</small></p>
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
                                                        <button type="button" id="submitCalculation" class="btn btn-next btn-outline-custom-default btn-success-custom float-right pl-3 pr-3 pt-1 pb-1 mt-1 mb-2"
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
            $('#paymentInfobtns').attr('hidden', true);
        } else {
            $('.dynamic-buttons').remove();
            $('#calculate_submit_bottom').append(element);
            $('#paymentInfobtns').attr('hidden', false);
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
        if ($(this).val()) {
            var productType = $('#calculator_form_productType').find(":selected").text();
            if (productType && productType === gp) {
                var nextDate = new Date($(this).val());
                nextDate.setFullYear(nextDate.getFullYear() + 10);
                var paymentEndDate = $('#calculator_form_paymentEndDate');
                paymentEndDate.datepicker({
                    format: 'mm/dd/yyyy'
                }).datepicker('update', nextDate);
                paymentEndDate.addClass("filled");
                paymentEndDate.parents(".form-group").addClass("focused");
            } else {
                var gender = $('#calculator_form_gender').find(":selected").text();
                if (!gender && gender !== 'Female') {
                    gender = "Male";
                }
                var age = $('#calculator_form_age').val();
                if (age && gender) {
                    $.get(`/user/endDate/${gender}/${age}`, function (data) {
                        var paymentEndDate = $('#calculator_form_paymentEndDate');
                        paymentEndDate.datepicker({
                            dateFormat: 'mm/dd/yyyy'
                        }).datepicker('update', data['beneficiaryBenefit']);
                        paymentEndDate.addClass("filled");
                        paymentEndDate.parents(".form-group").addClass("focused");
                        var alertData = '<div class="alert alert-info alert-dismissible fade show col-12" role="alert">' + 'You can select any date before ' + data['cutOffData'] + ' as End date ' + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + '<span aria-hidden="true">&times;</span>' + '</button>' + '</div>';
                        $('#endDate-alert .alert').remove();
                        $('#endDate-alert').append(alertData);
                    });
                }
            }
        }
    });

    //  replace mobile content with user's data
    $('#calculator_form_firstName').on('focusout', function () {
        if ($(this).val()) {
            $('#result_name').val($(this).val());
        }
    });

    $('#calculator_form_age').on('focusout', function () {
        if ($(this).val()) {
            $('#result_age').val($(this).val());
        }
    });

    $('#calculator_form_paymentStartDate').on('change', function () {
        if ($(this).val()) {
            $('#result_startDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
        }
    });

    $('#calculator_form_paymentEndDate').on('change', function () {
        if ($(this).val()) {
            $('#result_endDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
        }
    });

    $('#calculator_form_healthStatus').on('change', function () {
        if ($(this).find(":selected").text()) {
            $('#result_health').val($(this).find(":selected").text());
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
            } else if ($(curInputs[i]).hasClass('inp-required') && !$(curInputs[i]).val()) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        var ageField = curStep.find('#calculator_form_age');
        if (ageField.length) {
            var gender = $('#calculator_form_gender').find(":selected").text();
            if (gender !== 'Female') {
                gender = 'Male';
            }
            $('.invalid-age').remove();
            if (gender && ageField.val()) {
                var ageElement = $('#calculator_form_age');
                if (gender === 'Female' && (ageField.val() < 20 || ageField.val() >= 80)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 20 and 80</small> </p>`);
                    ageElement.parent().addClass('has-error');
                    isValid = false;
                } else if (gender !== 'Female' && (ageField.val() < 20 || ageField.val() >= 75)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 20 and 75</small> </p>`);
                    ageElement.parent().addClass('has-error');
                    isValid = false;
                }
            }
        }

        if (!isValid) {
            e.stopPropagation();
        } else {
            e.returnValue = true;
        }
    });
});