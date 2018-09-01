/**
 * @author Tobias Wenzel
 */

$(function() {
	var touched;
	var untouched;
	var ocr_corrected;
	var tagged;
	
	function drawTagChart() {

		var my_ar = [['Task', 'State'], ['unbearbeitet', untouched], ['angesehen', touched], ['getagged', tagged]];
		var data = google.visualization.arrayToDataTable(my_ar);
		var options = {
			title : 'Tagging Fortschritt'
		};
		var tag_chart = new google.visualization.PieChart(document.getElementById('tagpiechart'));
		tag_chart.draw(data, options);
	}




	function init_tag_counts(n_total, n_touched, n_untouched, n_tagged){

		total = parseInt(n_total);
		touched= parseInt(n_touched);
		untouched = parseInt(n_untouched);
		tagged = parseInt(n_tagged);
		google.charts.load('current', {
			'packages' : ['corechart']
		});
		google.charts.setOnLoadCallback(drawTagChart);
	}
	
	
	

	
	
	function load_project_status() {

		$.post("http://localhost:8000/php/db_funcs.php", {
			get_project_status : 1
		}).done(function(data, textStatus, jqXHR) {

			var counts = data.trim().split(',');
			init_tag_counts(counts[0], counts[1], counts[2], counts[4]);

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	}



	if ((window.location.href == 'http://localhost:8000/index.php') || (window.location.href == 'http://localhost:8000/')){
		load_project_status();
	}
	
	
	

	// init tooltips
	$('.tooltip').tooltipster({
		theme : 'tooltipster-punk'
	});

});
