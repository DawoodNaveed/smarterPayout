let gp = 'GP';
let customerId = '';
let customerName = '';
let minValue = '';
let maxValue = '';
let beneficiaryProtection = '';
let averageLifeExpectancy = '';
let yourLifeExpectancy = '';
let currAccordionName = 'AccountInfo';
let prevAccordionName = 'paymentInfo';
$(document).ready(function() {
    font_size_responsive();
    $(window).resize(function() {
        animate_mobile();
        font_size_responsive();
    });
    $('#calculate_result_modal').on('show.bs.modal', function() {
        setTimeout(function() {
            animate_mobile();
        }, 100);
        setTimeout(function() {
            var resultSection = $('#calculation-result');
            var otpPhoneSection = $('#otp-phone-number');
            var otpCodeSection = $('#otp-code');
            if(resultSection.length > 0) {
                resultSection.remove();
                otpPhoneSection.attr('hidden', false);
                $('#inp-otp-phone').focus();
            }
        }, 3000);
    }).on('hide.bs.modal', function() {
        $('.calculate_result_mobile_container').addClass('calculate_result_mobile_right');
    });

    function animate_mobile() {
        $(".mobile-animation").animate({
            "right": ($(window).width() - $('.mobile-img').width()) / 2 + 'px'
        }, "slow");
    }

    function font_size_responsive() {
        if($(window).width() < 768) {
            $('.primary-heading').css('font-size', '2rem');
            $('.heading-primary-calculation').css('font-size', '1.2rem');
            $('.heading-secondary-tagline').css('font-size', '0.7rem');
        } else {
            $('.primary-heading').css('font-size', '3rem');
            $('.heading-primary-calculation').css('font-size', '1.5rem');
            $('.heading-secondary-tagline').css('font-size', '1rem');
        }
    }
    $('#calculate_result_modal').on('hidden.bs.modal', function() {
        location.reload();
    });
    // init datepicker
    $(function() {
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
        }).datepicker('update', null);
    });
    $(document).on('click', '#termsAndConditions', function() {
        if($('#termsAndConditions').is(':checked')) {
            $('#submitCalculation').attr('disabled', false);
        } else {
            $('#submitCalculation').attr('disabled', true);
        }
    });
    $.fn.serializeObject = function() {
        var formObject = {};
        var array = this.serializeArray();
        $.each(array, function() {
            if(formObject[this.name] !== undefined) {
                if(!formObject[this.name].push) {
                    formObject[this.name] = [formObject[this.name]];
                }
                formObject[this.name].push(this.value || '');
            } else {
                formObject[this.name] = this.value || '';
            }
            if (this.name === 'calculator_form[height]') {
                formObject[this.name] = $('.height').val();
            }
        });
        return formObject;
    };
    $(document).on('click', '#submitCalculation', function(e) {
        e.preventDefault();
        var curStep = $(this).closest(".accordion-card"),
            curInputs = curStep.find("input.form-input, select.form-input"),
            isValid = true;
        for(var i = 0; i < curInputs.length; i++) {
            if($(curInputs[i]).hasClass('inp-required') && !$(curInputs[i]).val()) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
                var spinner = $(this).find('.fa-spinner');
                if(spinner) {
                    spinner.remove();
                }
            } else if(!curInputs[i].validity.valid && curInputs[i].required) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
                var spinner = $(this).find('.fa-spinner');
                if(spinner) {
                    spinner.remove();
                }
            }
        }
        if(isValid) {
            var form = $('form[name="calculator_form"]');
            if(!form[0].checkValidity()) {
                $("#hiddenSubmitButton").click();
                return false;
            }
            var form_data = form.serializeObject();
            $.ajax({
                url: '/',
                type: 'POST',
                dataType: 'json',
                data: form_data,
                success: function(data) {
                    var spinner = $(this).find('.fa-spinner');
                    if(spinner) {
                        spinner.remove();
                    }
                    if(Number(data['status']) === 200) {
                        customerId = data['data']['customerId'];
                        $('#min-amount').text(data['data']['min'].toFixed(2));
                        $('#max-amount').text(data['data']['max'].toFixed(2));
                        $('#beneficiary-amount').text(data['data']['beneficiaryProtection'].toFixed(2));
                        $('#client-name').text($('#calculator_form_firstName').val());
                        minValue = data['data']['min'].toFixed(2);
                        maxValue = data['data']['max'].toFixed(2);
                        beneficiaryProtection = data['data']['beneficiaryProtection'].toFixed(0);
                        if('averageLifeExpectancy' in data['data'] && 'yourLifeExpectancy' in data['data']) {
                            $('#averageLifeExpectancy').text(data['data']['averageLifeExpectancy']);
                            $('#yourLifeExpectancy').text(data['data']['yourLifeExpectancy']);
                            averageLifeExpectancy = data['data']['averageLifeExpectancy'];
                            yourLifeExpectancy = data['data']['yourLifeExpectancy'];
                            $('.lifeExpectancy').show();
                        } else {
                            $('.lifeExpectancy').hide();
                        }
                        customerName = $('#calculator_form_firstName').val();
                        $("#calculate_result_modal").modal('show');
                    } else {
                        alert(data['message']);
                    }
                    // signal to user the action is done
                }
            });
            var spinner = $(this).find('.fa-spinner');
            if(spinner) {
                spinner.remove();
            }
        }
    });
    $('#otp-code-submit').click(function() {
        var contact = $('#inp-otp-code').val();
        if(contact) {
            $.ajax({
                url: '/verify-otp',
                type: 'POST',
                data: {
                    'id': customerId,
                    'code': contact
                },
                success: function(data) {
                    $(this).find('fa-spinner').remove();
                    if(Number(data['status']) === 200) {
                        $('#otp-code').attr('hidden', true);
                        var calculationResult = '';
                        var productType = $('#calculator_form_productType').find(":selected").text();
                        if(productType === gp) {
                            calculationResult = `<div id="calculation-result">
                                                    <button id="view-given-details"
                                                            class="btn btn-outline-custom-small mt-1 mb-1">
                                                        Given Information
                                                    </button>
                                                    <h4 class="text-center">Hello <span id="client-name">` + customerName + `</span>
                                                    </h4>
                                                    <p><b>Min: </b><span id="min-amount"> ` + minValue + `</span>$</p>
                                                    <p><b>Max: </b><span id="max-amount">` + maxValue + `</span>$</p>
                                                    <p><b>Beneficiary Protection:</b><span
                                                                id="beneficiary-amount">` + beneficiaryProtection + `</span>$</p>                                                   
                                                </div>`;
                        } else {
                            calculationResult = `<div id="calculation-result">
                                                    <button id="view-given-details"
                                                            class="btn btn-outline-custom-small mt-1 mb-1">
                                                        Given Information
                                                    </button>
                                                    <h4 class="text-center">Hello <span id="client-name">` + customerName + `</span>
                                                    </h4>
                                                    <p><b>Min: </b><span id="min-amount"> ` + minValue + `</span>$</p>
                                                    <p><b>Max: </b><span id="max-amount">` + maxValue + `</span>$</p>
                                                    <p><b>Beneficiary Protection:</b><span
                                                                id="beneficiary-amount">` + beneficiaryProtection + `</span>$</p>
                                                    <div class="lifeExpectancy">
                                                        <p>Average Life Expectancy:<span id="averageLifeExpectancy">` + averageLifeExpectancy + `</span></p>
                                                        <p>Your Life Expectancy:<span id="yourLifeExpectancy">` + yourLifeExpectancy + `</span></p>
                                                    </div>
                                                    
                                                </div>`;
                        }
                        $('#calculation-result-container').append(calculationResult);
                    } else {
                        alert(data['message']);
                    }
                    // signal to user the action is done
                }
            });
        } else {
            var spinner = $(this).find('.fa-spinner');
            if(spinner) {
                spinner.remove();
                alert('Please Enter a Phone Number');
                $(this).data('spinner', false);
            }
        }
    });
    $('#otp-phone-submit').click(function() {
        var contact = $('#inp-otp-phone').val();
        if(contact) {
            $.ajax({
                url: '/send-otp',
                type: 'POST',
                data: {
                    'id': customerId,
                    'contact': contact
                },
                success: function(data) {
                    $(this).find('fa-spinner').remove();
                    if(Number(data['status']) === 200) {
                        $('#otp-phone-number').attr('hidden', true);
                        $('#otp-code').attr('hidden', false);
                        $('#inp-otp-code').focus();
                    } else {
                        alert(data['message']);
                    }
                    // signal to user the action is done
                }
            });
        } else {
            var spinner = $(this).find('.fa-spinner');
            if(spinner) {
                spinner.remove();
                alert('Please Enter a Phone Number');
                $(this).data('spinner', 'false');
            }
        }
    });
    $(document).on('click', '#view-given-details', function(e) {
        $('#calculation-result').attr('hidden', true);
        $('#given-details').attr('hidden', false);
    });
    // submit button on the base of product type
    append_calculate_submit_button();
    $("#calculator_form_productType, #calculator_form_age,  #calculator_form_gender").on('change', function() {
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
        if(productType === gp) {
            prevAccordionName = 'collapseAccountInfo';
            currAccordionName = 'paymentInfoPrev';
            $('.gp-hide').css('display', 'none');
        } else {
            prevAccordionName = 'collapseBasicInfo';
            currAccordionName = 'customInfoPrev';
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
                                                            <p><small>I have read and agree to the <a href="` + $('#termsAndConditionsUrl').data('url') + `" target="_blank">Terms and conditions</a>.</small></p>
                                                        </div>
                                                        <button id="` + currAccordionName + `"
                                                                data-toggle="collapse"
                                                                data-target="#` + prevAccordionName + `"
                                                                aria-expanded="true"
                                                                aria-controls="` + prevAccordionName + `"
                                                                type="button"
                                                                class="btn btn-prev btn-outline-custom-default btn-default-custom  float-left pl-3 pr-3 pt-1 pb-1 mt-2 mb-2">
                                                            Prev
                                                        </button>
                                                        <button type="button" id="submitCalculation" data-spinner="true" class="btn btn-next btn-outline-custom-default btn-spinner btn-success-custom float-right pl-3 pr-3 pt-1 pb-1 mt-1 mb-2"
                                                                disabled="disabled">
                                                            Submit
                                                        </button>
                                                        <button id="hiddenSubmitButton" class="btn btn-outline-custom-default btn-success-custom float-right pl-3 pr-3 pt-1 pb-1 mt-1 mb-2"
                                                                disabled="disabled" type="submit" hidden>
                                                            Submit
                                                        </button>
                                                    </div>`;
        var productType = $('#calculator_form_productType').find(":selected").text();
        if(productType === gp) {
            $('.dynamic-buttons').remove();
            prevAccordionName = 'collapseAccountInfo';
            currAccordionName = 'paymentInfoPrev';
            $('#calculate_submit_top').append(element);
            $('#paymentInfobtns').attr('hidden', true);
        } else {
            $('.dynamic-buttons').remove();
            prevAccordionName = 'collapseBasicInfo';
            currAccordionName = 'customInfoPrev';
            $('#calculate_submit_bottom').append(element);
            $('#paymentInfobtns').attr('hidden', false);
        }
    }
    // set weight on the basis of manual weight and height
    $('#calculator_form_height, #manualWeight').on('focusout', function() {
        var height = $('#calculator_form_height').val();
        var weight = $('#manualWeight').val();
        if(height && weight) {
            var heightArray = height.split(".");
            var feet = heightArray[0];
            var decimal = heightArray[1];
            var value = ((703 * Number(weight)) / Math.pow((Number(feet * 12) + Number(decimal)), 2)).toFixed(2);
            if(value <= 17.50) {
                $('#calculator_form_weight').val('underWeight');
            } else if(value > 17.50 && value <= 21.00) {
                $('#calculator_form_weight').val('idealWeight');
            } else if(value > 21.00 && value <= 26.00) {
                $('#calculator_form_weight').val('averageWeight');
            } else if(value > 26.00 && value <= 31.00) {
                $('#calculator_form_weight').val('overWeight');
            } else if(value > 31.00) {
                $('#calculator_form_weight').val('obese');
            }
        }
    });
    $('#manualWeight').focus(function() {
        $('.invalid-manual-weight').remove();
    })
    $('#manualWeight').on('focusout', function() {
        var manualWeight = $('#manualWeight');
        if(manualWeight.val()) {
            if(manualWeight.val() && (manualWeight.val() < 121 || manualWeight.val() > 1550)) {
                manualWeight.parent().append(`<p class="text-danger invalid-manual-weight"><small>Weight must be between 121 and 1550 lbs</small> </p>`);
                manualWeight.parent().addClass('has-error');
            }
        }
    });
    //  manual weight input field, if user select "Prefer To Put Manually"
    $('#calculator_form_weight').on('change', function() {
        if($(this).find(':selected').text() === 'Prefer To Put Manually') {
            $('.manualWeight-hide').css('display', 'block')
        } else {
            $('.manualWeight-hide').css('display', 'none')
        }
    });
    // set End date on the basis of product type and start date
    $('#calculator_form_paymentStartDate').on('focusout blur keyup change', function() {
        if($(this).val()) {
            var productType = $('#calculator_form_productType').find(":selected").text();
            if(productType && productType === gp) {
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
                if(gender !== 'Female') {
                    gender = "Male";
                }
                var age = $('#calculator_form_age').val();
                if(age && gender) {
                    $.get(`/user/endDate/${gender}/${age}`, function(data) {
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
    $('#calculator_form_firstName').on('focusout', function() {
        if($(this).val()) {
            $('#result_name').val($(this).val());
            $('#details_name').val($(this).val());
        }
    });
    $('#calculator_form_age').on('focusout', function() {
        if($(this).val()) {
            $('#result_age').val($(this).val());
            $('#details_age').val($(this).val());
        }
    });
    $('#calculator_form_paymentStartDate').on('change', function() {
        if($(this).val()) {
            $('#result_startDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
            $('#details_startDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
        }
    });
    $('#calculator_form_paymentEndDate').on('change', function() {
        if($(this).val()) {
            $('#result_endDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
            $('#details_endDate').datepicker({
                format: 'mm/dd/yyyy'
            }).datepicker('update', $(this).val());
        }
    });
    $('#calculator_form_healthStatus').on('change', function() {
        if($(this).find(":selected").text()) {
            $('#result_health').val($(this).find(":selected").text());
            $('#details_health').val($(this).find(":selected").text());
        }
    });
    //  accordion cards validations
    var allNextBtn = $('.btn-next');
    allNextBtn.click(function(e) {
        var curStep = $(this).closest(".accordion-card"),
            curInputs = curStep.find("input.form-input, select.form-input"),
            isValid = true;
        $(".form-group").removeClass("has-error");
        for(var i = 0; i < curInputs.length; i++) {
            if(!curInputs[i].validity.valid && curInputs[i].required) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            } else if($(curInputs[i]).hasClass('inp-required') && !$(curInputs[i]).val()) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }
        var ageField = curStep.find('#calculator_form_age');
        if(ageField.length) {
            var gender = $('#calculator_form_gender').find(":selected").text();
            if(gender !== 'Female') {
                gender = 'Male';
            }
            $('.invalid-age').remove();
            if(gender && ageField.val()) {
                var ageElement = $('#calculator_form_age');
                if(gender === 'Female' && (ageField.val() < 20 || ageField.val() >= 80)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 20 and 80</small> </p>`);
                    ageElement.parent().addClass('has-error');
                    isValid = false;
                } else if(gender !== 'Female' && (ageField.val() < 20 || ageField.val() >= 75)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 20 and 75</small> </p>`);
                    ageElement.parent().addClass('has-error');
                    isValid = false;
                }
            }
        }
        if(!isValid) {
            e.stopPropagation();
        } else {
            e.returnValue = true;
            increase_progress_bar(curStep);
        }
    });
    var allPrevBtn = $('.btn-prev');
    allPrevBtn.click(function() {
        decrease_progress_bar($(this));
    });
    $(document).on('click', '.btn-prev', function() {
        decrease_progress_bar($(this));
    });

    function increase_progress_bar(curStep) {
        var productType = $('#calculator_form_productType').find(":selected").text();
        var progressBar = $('#calculator-progress-bar');
        if(productType === gp) {
            progressBar.css('width', (Number(curStep.data('progress')) + Number(curStep.data('progress'))) + '%');
            progressBar.text((Number(curStep.data('progress')) + Number(curStep.data('progress'))) + '%');
        } else {
            progressBar.css('width', curStep.data('progress') + '%');
            progressBar.text(curStep.data('progress') + '%');
        }
    }

    function decrease_progress_bar(element) {
        var curStep = element.closest(".accordion-card");
        var productType = $('#calculator_form_productType').find(":selected").text();
        var progressBar = $('#calculator-progress-bar');
        if(productType === gp) {
            progressBar.css('width', ((Number(curStep.data('progress')) + (Number(curStep.data('progress')))) - 100) + '%');
            progressBar.text(((Number(curStep.data('progress')) + (Number(curStep.data('progress')))) - 100) + '%');
        } else {
            progressBar.css('width', (Number(curStep.data('progress')) - 50) + '%');
            progressBar.text((Number(curStep.data('progress')) - 50) + '%');
        }
    }
    $('.number-input').bind('keyup mouseup', function() {
        var inpValue = $(this).val();
        if(inpValue !== "" && inpValue !== "0") {
            if(inpValue < 0) {
                $(this).val("");
            }
        } else {
            $(this).val("");
        }
    });
    $('#calculator_form_age').bind('focusout', function() {
        var gender = $('#calculator_form_gender').find(":selected").text();
        if(gender !== 'Female') {
            gender = 'Male';
        }
        if(gender) {
            var ageElement = $('#calculator_form_age');
            if($(this).val()) {
                if(gender === 'Female' && ($(this).val() < 20 || $(this).val() >= 80)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 19 and 80</small> </p>`);
                    ageElement.parent().addClass('has-error');
                } else if(gender !== 'Female' && ($(this).val() < 20 || $(this).val() >= 75)) {
                    ageElement.parent().append(`<p class="text-danger invalid-age"><small>Age must be between 19 and 75</small> </p>`);
                    ageElement.parent().addClass('has-error');
                }
            }
        }
    });
    $('#calculator_form_age').focus(function() {
        $('.invalid-age').remove();
    });
});