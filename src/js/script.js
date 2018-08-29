/**
 * @author Tobias Wenzel
 */

$(function() {
	var touched;
	var untouched;
	var ocr_corrected;
	var tagged;
	
	function drawChart() {

		var my_ar = [['Task', 'State'], ['unbearbeitet', untouched], ['angesehen', touched], ['getagged', tagged], ['ocr-corrected', ocr_corrected]];

		var data = google.visualization.arrayToDataTable(my_ar);

		var options = {
			title : 'Projekt Fortschritt'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	}

	function init_me(n_total, n_touched, n_untouched, n_ocr_corrected, n_tagged){
		// todo fetch numbers from db
		total = parseInt(n_total);
		touched= parseInt(n_touched);
		ocr_corrected = parseInt(n_ocr_corrected);
		untouched = parseInt(n_untouched);
		tagged = parseInt(n_tagged);
		
		
		google.charts.load('current', {
			'packages' : ['corechart']
		});
		google.charts.setOnLoadCallback(drawChart);


	}
	
	
	
	function load_project_status() {

		$.post("http://localhost:8000/php/db_funcs.php", {
			get_project_status : 1
		}).done(function(data, textStatus, jqXHR) {

			var counts = data.trim().split(',');
			init_me(counts[0], counts[1], counts[2], counts[3], counts[4]);

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	}
	if (window.location.href == 'http://localhost:8000/index.php'){
			load_project_status();

	}
	
	
	

	// init tooltips
	$('.tooltip').tooltipster({
		theme : 'tooltipster-punk'
	});

});
