jQuery(document).ready(function ($) {
// Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);


// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
    function drawChart() {

        $.ajax({
            url: riff_vars_25.ajaxurl,
            type: 'POST',
            datatype: 'json',
            data: {
                action: 'riffchart_get_data',
            },
            success: function (ret) {
                var dataarray = Array();
                dataarray = eval(ret);

                var data = google.visualization.arrayToDataTable(dataarray);

                var options = {
                    width: 560,
                    height: 400,
                    legend: {position: 'top', maxLines: 3},
                    bar: {groupWidth: '75%'},
                    isStacked: true
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);

            }
        });

    }

});



