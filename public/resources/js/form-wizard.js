$(document).ready(function () {
    $(".nav-tabs > li a[title]").tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        var target = $(e.target);

        if (target.parent().hasClass("disabled")) {
            return false;
        }
    });

    $(".skip-btn").click(function (e) {
        var active = $(".wizard .nav-tabs li.active");
        nextTab(active);
    });
    $(document).on('click', '.prev-step', function () {
        var active = $(".wizard .nav-tabs li.active");
        prevTab(active);
    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
    var active = $(".wizard .nav-tabs li.active");
    active.removeClass('active').addClass('done');
    active.next().addClass('active');
}

function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
    var active = $(".wizard .nav-tabs li.active");
    active.removeClass('active');
    active.prev().addClass('active');
}