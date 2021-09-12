$(document).ready(function () {
//  in case of page scroll
    $(window).scroll(function () {
        var distance = $(window).scrollTop();
        $('.page-section').each(function (i) {
            if ($(this).position().top <= distance + 150) {
                $('.navbar-nav .nav-item.active').removeClass('active');
                $('.navbar-nav .nav-item').eq(i).addClass('active');
            }
        });
    }).scroll();

    //  in case of navigation link click
    var navigationLinks = $(".navbar .navbar-collapse .navbar-nav .nav-item");
    for (var i = 0; i < navigationLinks.length; i++) {
        navigationLinks[i].addEventListener("click", function () {
            var current = document.getElementsByClassName("active");
            console.log(current);
            if (typeof current[0] != "undefined") {
                current[0].className.replace(" active", "");
            }
            var origin = window.location.origin;
            console.log(origin + '/#' + $(this).find('a').data('url'));
            window.location = origin + '/#' + $(this).find('a').data('url');
            this.className += " active";
        });
    }
});