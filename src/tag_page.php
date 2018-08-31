<?php session_start();
if (!isset($_SESSION['user_name'])) {
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
		include ('php/db_funcs.php');
		?>
		<!-- Messages PLUGIN  -->
		<script type="text/javascript" src="http://localhost:8000/js/bootbox/bootbox.min.js"></script>

		<script src="http://localhost:8000/js/marker.js" type="text/javascript"></script>

		<!-- for autocompletition -->
		<link rel="stylesheet" type="text/css" href="http://localhost:8000/node_modules/selectize/css/selectize.default.css" media="all" />
		<script src="http://localhost:8000/node_modules/selectize/js/standalone/selectize.min.js"></script>

		<!-- for img-zooming -->
		<link rel="stylesheet" type="text/css" href="http://localhost:8000/css/pavel_zoom.css"/>

		<style type="text/css">
			#image_element {

				width: 500px;
				height: 600px;
				left: -5em;
				top: -0px;
			}

		</style>
	</head>

	<body>

		<?php
		include ('html_snippets/nav_bar.php');
		include ('html_snippets/user_info.php');
		?>

		<div class="container" style="margin-top: 10px" id="tag_correction_container">

			<div class="row">

				<div class="col-xs-12 col-md-6">


					<div class="control-group">
						<label for="select-tags" title="Sobald du anfängst Wörter zu schreiben, werden Tags geladen!">Tags:</label>
						<select id="select-tags" placeholder="Beginne, Tags einzugeben..."></select>
					</div>

					<br />
					

					<div id="myselectedtags"></div>
					<div id="res_has_tags" >
						Bisher wurden noch keine Tags damit verbunden. Fang einfach an!
					</div>
					
					<div class="custom-control form-control-lg custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="title_check">
						<label class="custom-control-label" for="title_check">
							Titelseite oder ein Einband?
						</label>
					</div>


					<div class="slidecontainer">
						<label  for="sm_count">Wie viele Notenabschnitte siehst du?</label>
						<input type="range" min="0" max="10" value="0" class="slider" id="sm_count">
						<span id="sm_count_display">0</span>
					</div>

					<div class="slidecontainer">
						<label  for="ad_count">Wie viele Werbeanzeigen siehst du?</label>
						<input type="range" min="0" max="10" value="0" class="slider" id="ad_count" >
						<span id="ad_count_display">0</span>
					</div>
					<br />

					<div class="col mybuttons" >
						<button class="btn btn-default" id="reset-marker-btn" class="tooltip" title="alles doof?" >
							Zurücksetzen
						</button>

						<button class="btn btn-default" id="stay_on_marker_page_btn" class="tooltip" title="Noch so eine Seite!">
							Mit Tagging weitermachen
						</button>

						<button class="btn btn-default" id="continue_with_ocr_btn" class="tooltip" title="Lust auf was Anderes?">
							Weiter mit OCR
						</button>

					</div>

				</div>

				<div class="col-xs-12 col-md-6" class="tooltip" title="">

					<button id="button_zoom_in" class="button">
						+
					</button>
					<button id="button_zoom_out" class="button">
						-
					</button>

					<div id="image_header">
						<div id="image_header_tag">
							<img id="image_element" alt="wochenblatt_image" <?php load_random_png_image(); ?>>
						</div>
					</div>

				</div>

			</div>

	</body>

	<script src="http://localhost:8000/js/mouse_zoom.js"></script>
	<script src="http://localhost:8000/js/draggable_element.js"></script>

</html>
