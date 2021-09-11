
$(document).ready(function () {
    function setClasses(index, steps) {
        if (index < 0 || index > steps) return;
        if (index == 0) {
            $("#prev").prop("disabled", true);
        } else {
            $("#prev").prop("disabled", false);
        }
        if (index == steps) {
            $("#next").text("done");
        } else {
            $("#next").text("next");
        }
        $(".step-wizard ul li").each(function () {
            $(this).removeClass();
        });
        $(".step-wizard ul li:lt(" + index + ")").each(function () {
            $(this).addClass("done");
        });
        $(".step-wizard ul li:eq(" + index + ")").addClass("active");
        var p = index * (100 / steps);
        $('#done').attr('aria-valuenow', p);
        $('#done').css({'width': p + '%'});

        $('#active').attr('aria-valuenow', '25');
        $('#active').css({'width': '25%'});

        $('#active').attr('aria-valuenow', '25');
        $('#active').css({'width': '25%'});

        $('#empty').attr('aria-valuenow', 100 - (p + 25));
        $('#empty').css({'width': 100 - (p + 25) + '%'});
    }

    $(".step-wizard ul button").click(function () {
        var step = $(this).find("span.step")[0].innerText;
        var steps = $(".step-wizard ul li").length;
        setClasses(step - 1, steps);
    });
    $("#prev").click(function () {
        var step = $(".step-wizard ul li.active span.step")[0].innerText;
        var steps = $(".step-wizard ul li").length;
        setClasses(step - 2, steps);
    });
    $("#next").click(function () {
        if ($(this).text() == "done") {
            alert("submit the form?!?");
        } else {
            var step = $(".step-wizard ul li.active span.step")[0].innerText;
            var steps = $(".step-wizard ul li").length;
            setClasses(step, steps);
        }
    });

    // initial state setup
    setClasses(0, $(".step-wizard ul li").length);
});
