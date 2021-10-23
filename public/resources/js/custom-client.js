$(document).ready(function () {
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

    $('select').focus(function () {
        $("" + '#' + $(this).attr("id") + " option[value='']").remove();
    })
    // Set height of page sections according to screen size
    $('#home, #about-us, #calculate, #career').css('min-height', $(window).height());
    // Smart scroll for navigation bar
    if ($('.smart-scroll').length > 0 && $(window).width() >= 992) {
        $(window).on('scroll', function () {
            scroll_top = $(this).scrollTop();
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
        if (!$(this).val() && !$(this).hasClass('static')) {
            $(this).removeClass("filled");
            if (!$(this).is(":focus")) {
                $(this).parents(".form-group").removeClass("focused");
            }
        } else {
            $(this).addClass("filled");
            $(this).parents(".form-group").addClass("focused");
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
    $window.on('scroll resize', check_if_in_view);
    $window.trigger('scroll');
});