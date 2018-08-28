<?php 
session_start();
if (!isset($_SESSION['user_name'])){
	$_SESSION['user_name'] = 'guest';
	$_SESSION['user_id'] = 2;
	$_SESSION['user_points'] = 0;
}
?>
<!DOCTYPE html>
<html>

	<head>

		<?php
			include ('html_snippets/header.php');
		?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    
    


      function drawChart() {
		// not able to add ars directly!
		var my_ar = [
          ['Task', 'Hours per Day'],
          ['untouched',     untouched],
          ['touched',      touched],
          ['tagged',      tagged],
          ['ocr-corrected',      ocr_corrected]

        ];
 
        var data = google.visualization.arrayToDataTable(my_ar);

        var options = {
          title: 'Projekt Fortschritt'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
      // todo fetch numbers from db
       google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	var touched = 5;
	var untouched = 4;
	var ocr_corrected = 10;
	var tagged = 5;      
	
	
    </script>
	</head>

	<body>

		<?php
		include ('html_snippets/nav_bar.php');
		include ('html_snippets/user_info.php');
		?>

		<div class="container" style="margin-top: 10px">
			<h1>music matcher</h1>
			The Musikalisches Wochenblatt - Organ für Musiker und Musikfreunde (short: MWb), was a music journal in the time of the german empire. It was founded in 1870 by Oscal Paul and published until 1910 in Leipzig. Henceforward it was published by Ernst Wilhelm Fritsch as the Neue Zeitschrift für Musik (short: NZFM). It discusses developments in music, concerts and features critics from all over Germany with a focus led on Leipzig. In this project we chose to use these documents as our research corpus because of the regional connection to our univerisity and it's rich information about the 19th as well as the beginning of the 20th century.
			<h2>...yet another OCR-correction project?</h2>
			
			
			<h2>How to get started</h2>
			<p>
				...
			</p>

			<h2>Contribute</h2>
			<p>
				...
			</p>
			<a href="https://github.com/tobiasw225/musicmatcher">on github</a>

    <div id="piechart" style="width: 900px; height: 500px;"></div>


		</div>

		<?php

		Include ('html_snippets/cc_licence.php');
		?>
	</body>
</html>
