let href = '';
$(document).ready(function() {
    //  in case of page scroll
    $(window).scroll(function() {
        var distance = $(window).scrollTop();
        $('.page-section').each(function(i) {
            if($(this).position().top <= distance + 150) {
                var navBarItem = $('.navbar-nav .nav-item');
                $('.navbar-nav .nav-item.active').removeClass('active');
                navBarItem.eq(i).addClass('active');
                href = navBarItem.eq(i).children().attr('href');
            }
        });
        var origin = window.location.origin;
        window.location = origin + '/#main' + href;
    }).scroll();
    //  in case of navigation link click
    var navigationLinks = $(".navbar .navbar-collapse .navbar-nav .nav-item");
    for(var i = 0; i < navigationLinks.length; i++) {
        navigationLinks[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            if(typeof current[0] != "undefined") {
                current[0].className.replace(" active", "");
            }
            var origin = window.location.origin;
            window.location = origin + '/#' + $(this).find('a').data('url');
            this.className += " active";
        });
    }
});