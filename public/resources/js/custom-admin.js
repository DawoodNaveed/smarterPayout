$(document).ready(function () {

    $("#close-sidebar").click(function () {
        if ($(".page-wrapper").hasClass("toggled")) {
            $(".page-wrapper").removeClass("toggled");
        } else {
            $(".page-wrapper").addClass("toggled");
        }
    });

    $('#data_table').DataTable();
});