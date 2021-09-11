$(document).ready(function() {
    // Initialize data table
    $('#data_table').DataTable();

    // Initialize searchable select
    $(".select2").select2();

    // toggle left sidebar
    $("#close-sidebar").click(function() {
        var pageWrapper = '.page-wrapper';
        if($(pageWrapper).hasClass("toggled")) {
            $(pageWrapper).removeClass("toggled");
        } else {
            $(pageWrapper).addClass("toggled");
        }
    });

    // toggle right sidebar
    $("#close-right-sidebar").click(function() {
        var sidebarWrapperRight = '.sidebar-wrapper-right';
        if($(sidebarWrapperRight).hasClass("collapsed")) {
            $(this).removeClass("animate-open");
            $(this).addClass("animate-close");
            $(sidebarWrapperRight).removeClass("collapsed");
            $(sidebarWrapperRight).addClass("open-right-sidebar ");
            $(sidebarWrapperRight).find('i').removeClass("fa-angle-double-left");
            $(sidebarWrapperRight).find('i').addClass("fa-angle-double-right");
        } else {
            $(this).removeClass("animate-close");
            $(this).addClass("animate-open");
            $(sidebarWrapperRight).addClass("collapsed");
            $(sidebarWrapperRight).removeClass("open-right-sidebar ");
            $(sidebarWrapperRight).find('i').removeClass("fa-angle-double-right");
            $(sidebarWrapperRight).find('i').addClass("fa-angle-double-left");
        }
    });

    // delete record using generic pop-up modal
    $('.deleteRecord').click(function() {
        let recordUrl = $(this).data('url');
        $("#deletebtn").attr("href", recordUrl);
    });
    $('.customer-details').click(function() {
        var uri = $(this).data('uri');
        $.get(uri, function(data) {
            // needs to implement functionality
        });
    });

    //  in case of load/reload sidebar active
    var setDefaultActive = function() {
        var path = window.location.pathname;
        console.log(path);
        var element = $(".sidebar-content .sidebar-menu ul li a[href='" + path + "']");
        element.parent('li').addClass("active-li");
        element.addClass("active-a");
        element.find('i').addClass("active-i");
    }
    setDefaultActive();

    //  in case of navigation link click sidebar active
    var navigationLinks = $(".sidebar-content .sidebar-menu ul li");
    for(var i = 0; i < navigationLinks.length; i++) {
        navigationLinks[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active-li");
            console.log(current);
            current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
});