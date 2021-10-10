$(document).ready(function () {
    $("#contact_us_form_contact, #calculator_form_phoneNo, #inp-otp-phone").inputmask({"mask": "+1 (999) 999-9999"});

    $(document).on('click', '.btn-spinner', function () {
        var spinner = $(this).find('.fa-spinner');
        if (spinner) {
            spinner.remove();
        }

        spinnerBtn = $(this);
        $(this).append(`<i class="fas fa-spinner fa-spin"></i>`);

        var form = $(this).parent('form');
        if (form && !form.valid) {
            var spinner = spinnerBtn.find('.fa-spinner');
            if (spinner) {
                setTimeout(function () {
                    spinner.remove();
                }, 300);
            }
        }

    });

    resize_carousel();
    // Set height of page sections according to screen size
    $('#about-us, #calculate, #career').css('min-height', $(window).height());
    // Smart scroll for navigation bar
    if ($('.smart-scroll').length > 0 && $(window).width() >= 992) {
        var last_scroll_top = 0;
        $(window).on('scroll', function () {
            scroll_top = $(this).scrollTop();
            if (scroll_top < last_scroll_top || scroll_top > last_scroll_top) {
                $('.smart-scroll').removeClass('scrolled-down').addClass('scrolled-up');
            } else {
                $('.smart-scroll').removeClass('scrolled-up').addClass('scrolled-down');
            }
            last_scroll_top = scroll_top;
        });
    }
    //  handling navbar for mobile/tab screens
    $('.navbar-toggler').click(function () {
        var navbarTogglerIcon = $('.navbar-toggler span');
        var navbarCollapse = $('.navbar-collapse');
        if (navbarCollapse.hasClass('show')) {
            navbarCollapse.toggleClass('show');
            navbarTogglerIcon.removeClass('fa fa-times');
            navbarTogglerIcon.addClass('fa fa-bars');
            $('#overlay').hide();
        } else {
            navbarCollapse.toggleClass('show');
            $('.navbar-brand').addClass('img-overlay');
            navbarTogglerIcon.removeClass('fa fa-bars');
            navbarTogglerIcon.addClass('fa fa-times');
            $('#overlay').show();
        }
    });
    //  custom animated input fields
    $("input, textarea, select").focus(function () {
        $(this).parents(".form-group").addClass("focused");
        $(this).parents(".form-group").removeClass("has-error");
    });
    $("input, textarea, select").on('blur keyup focusout change', function () {
        if (!$(this).val()) {
            $(this).removeClass("filled");
            if (!$(this).is(":focus")) {
                $(this).parents(".form-group").removeClass("focused");
            }
        } else {
            $(this).addClass("filled");
            $(this).parents(".form-group").addClass("focused");
        }
    });

    //  custom animated input fields
    $("#calculator_form_phoneNo, #contact_us_form_contact, #inp-otp-phone").hover(function () {
        $(this).parents(".form-group").addClass("focused");
        $(this).parents(".form-group").removeClass("has-error");
    }, function () {
        if (!$(this).focus()) {
            $(this).parents(".form-group").removeClass("focused");
        }
    });

    // about us image animation
    var $animation_elements = $('.animation-element');
    var $window = $(window);

    function check_if_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);
        $.each($animation_elements, function () {
            var $element = $('.animation-element');
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);
            if ((element_bottom_position >= window_top_position) && (element_top_position <= window_bottom_position)) {
                $element.removeClass('about-us-animated-img-block');
                $element.addClass('about-us-animated-img-animate');
            } else {
                $element.removeClass('about-us-animated-img-animate');
                $element.addClass('about-us-animated-img-block');
            }
        });
    }

    function resize_carousel() {
        // Set height of carousel image according to screen size
        $('.carousel-item img').css('height', $(window).height() - $('.navbar').outerHeight());
    }

    $window.on('scroll resize', check_if_in_view);
    $window.trigger('scroll');
    $window.on('resize', resize_carousel)
});