(function() {
CHART = {
    global_chart_data: null,

    TYPE_LINE: 1,
    TYPE_PIE: 2,

    init : function(data) {
    	global_chart_data = data;
        // line chart
    	google.load("visualization", "1", {packages:["corechart"]});
    	google.setOnLoadCallback(CHART.loadCharts);
    },

    loadCharts : function () {
        var options;
        // display line chart
        options = { title: "Evolution du taux d'utilisation" };
        CHART.drawChart(global_chart_data.line, CHART.TYPE_LINE, "line", options);
        // display first pie chart
        options = {
        	title: "Echantillonage par heure",
        	is3D: true
        };

        CHART.drawChart(global_chart_data.pie_heure, CHART.TYPE_PIE, "pie_heure", options);
        // display second pie chart
        options = {
        	title: 'Echantillonage par jour de la semaine',
        	pieHole: 0.3
        };

        CHART.drawChart(global_chart_data.pie_semaine, CHART.TYPE_PIE, "pie_semaine", options);
    },

	drawChart : function (chart_data, chart_type, container_id, options) {
		var data = new google.visualization.DataTable(chart_data);

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
