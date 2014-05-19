(function() {
CHART = {
    chart_data: null,

    init : function( data ) {
    	chart_data = data;
    	// line chart
    	google.load("visualization", "1", {packages:["corechart"]});
    	google.setOnLoadCallback(CHART.drawChart);
    },

	drawChart : function () {

		console.log(chart_data);

    	var data = google.visualization.arrayToDataTable([
    	  ["Date", "Taux d'utilisation"],
    	  ['17/04/2004',  24],
    	  ['18/04/2004',  14],
    	  ['19/04/2004',  6],
    	  ['20/04/2004',  1]
    	]);

    	var options = {
    	  title: 'Company Performance'
    	};

    	var chart = new google.visualization.LineChart(document.getElementById('linechart'));
    	chart.draw(data, options);
    },

    render : function( sPassword ) {
        return true;
    }
};
})();
