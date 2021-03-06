$(document).ready(function() {
    google.charts.load('current', {
        'packages': ['gauge']
    }).then(function() {
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Messages', 80],
            ['Calls', 55],
            ['Letters', 68]
        ]);
        var options = {
            width: 450,
            height: 150,
            greenFrom: 150,
            greenTo: 200,
            yellowFrom:50,
            yellowTo:150,
            redFrom:0,
            redTo:50,
            minorTicks: 5,
            max: 200
        };
        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
        $('#chart_div').find('table').addClass('col-12 p-0');
        $('#chart_div').find('tr').addClass('d-flex justify-content-around flex-md-wrap');
    }
});