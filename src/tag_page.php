<!DOCTYPE html>
<html>
	
	
	<head>
		<?php
			include('html_snippets/header.php');
			include 'db_funcs.php';
		?>
		<!-- Messages PLUGIN  -->

    	<script type="text/javascript" src="js/bootbox.min.js"></script>

		<!-- XZOOM PLUGIN  -->
		<link rel="stylesheet" type="text/css" href="css/xzoom.css" media="all" />
		<script type="text/javascript" src="js/xzoom.min.js"></script>
		<!-- PDF.js -->
				<script src="js/pdf.worker.js"></script>

		<script src="js/pdf.js"></script>
		
		<script src="js/marker.js" type="text/javascript"></script>

	</head>

	<body>

   		<?php
		include ('html_snippets/nav_bar.php');
		?>
    
		<div class="container" style="margin-top: 10px">
			  <div class="row">


					


				<div class="col-xs-12 col-md-6" class="tooltip" title=""  >
						
						<div class="custom-control form-control-lg custom-checkbox">
						    <input type="checkbox" class="custom-control-input" id="title_check">
						    <label class="custom-control-label" for="title_check">Titelseite oder ein Einband?</label>
						</div>
						
						<div class="custom-control form-control-lg custom-checkbox">
						    <input type="checkbox" class="custom-control-input" id="sm_check">
						    <label class="custom-control-label" for="sm_check">Sind Noten zu sehen?</label>
						</div>
						
					<div class="slidecontainer">
					  <input type="range" min="1" max="10" value="1" class="slider" id="sm_count" readonly>
					</div>
					
						<div class="custom-control form-control-lg custom-checkbox">
						    <input type="checkbox" class="custom-control-input" id="ad_check">
						    <label class="custom-control-label" for="ad_check">Ist Werbung zu sehen?</label>
						</div>
						
					<div class="slidecontainer">
					  <input type="range" min="1" max="10" value="1" class="slider" id="ad_count" readonly>
					</div>
										<br />
	
				  <div class="form-group">
				    <input type="text" class="form-control" id="taginput" placeholder="Gib ein paar Tags ein!">
				  </div>
				  		<div id="tagsearch">
						<?php
						load_tags();
						?>
						</div>
						<br />
						<div id="myselectedtags"></div>
							
							<p> 
								<br />

								Tag-Eingabe. Zunächst werden alle Tags (aus der Datenbank) angezeigt. Bei Eingabe wird gefiltert. 
								Bestätigen mit Enter-Taste. Die markierten Tags werden markiert. 
								Draufklicken soll auch möglich sein.
							</p>
							
							<p>
								Noch cooler wäre natürlich eine dynamische Listbox.
							</p>

							<p>
								Noch cooler wäre natürlich ein uniquer check.
							</p>
						
					<div class="col mybuttons" >
						<button class="btn btn-default" id="reset-marker-btn" class="tooltip" title="">
							Zurücksetzen
						</button>
						<button class="btn btn-default" id="submit_marker" class="tooltip" title="">
							Weiter
						</button>
						
						
					</div>
					

				</div>
				
				
				<div class="col-xs-12 col-md-6" class="tooltip xzoom-container" id="" title="">
					
						<img id="dbpic" class="xzoom" src="test_files/res/bub_gb_1UMvAAAAMAAJ_Page_0x1bdf_prev.png" <?php
						load_random_image();
						?>>
					
					
					<!--
					 <canvas id="the-canvas"></canvas>

						<div id="pdf-main-container">
						    <div id="pdf-loader"></div>
						    <div id="pdf-contents">	
						        <canvas id="pdf-canvas" width="400"></canvas>
						    </div>
						</div>		
					-->
				
				</div>
				

				
		</div>


		
		
	</body>
</html>
