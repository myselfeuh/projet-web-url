(function() {
CHART = {
    chart_data: null,

    TYPE_LINE: 1,
    TYPE_PIE: 2,

    init : function(data) {
    	chart_data = data;
        // line chart
    	google.load("visualization", "1", {packages:["corechart"]});
    	google.setOnLoadCallback(CHART.loadCharts);
    },

    loadCharts : function () {
        var options;
        // display line chart
        options = { title: 'line' };
        CHART.drawChart(chart_data.line, CHART.TYPE_LINE, "line", options);
        // display first pie chart
        options = { title: 'pie_heure' };
        CHART.drawChart(chart_data.pie_heure, CHART.TYPE_PIE, "pie_heure", options);
        // display second pie chart
        options = { title: 'pie_semaine' };
        CHART.drawChart(chart_data.pie_semaine, CHART.TYPE_PIE, "pie_semaine", options);
    },

	drawChart : function (chart_data, chart_type, container_id, options) {
		console.log(chart_data);

        var data = google.visualization.DataTable();

        // data.addColumn('string', 'Task');
        // data.addColumn('number', 'Hours per Day');
        data.addRows(chart_data);

    	// var data = google.visualization.arrayToDataTable([
    	//   ["Date", "Taux d'utilisation"],
    	//   ['17/04/2004',  24],
    	//   ['18/04/2004',  14],
    	//   ['19/04/2004',  6],
    	//   ['20/04/2004',  1]
    	// ]);

        var elt = document.getElementById(container_id);
        var chart;

        switch (chart_type) {
            case CHART.TYPE_LINE:
                chart = new google.visualization.LineChart(elt);
            break;
     
            case CHART.TYPE_PIE:
                chart = new google.visualization.PieChart(elt);
               break;
         
            default:  
               break;
        }

    	chart.draw(data, options);
    },

    render : function( sPassword ) {
        return true;
    }
};
})();
