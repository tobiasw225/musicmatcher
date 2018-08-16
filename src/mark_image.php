<!DOCTYPE html>
<html>
	<head>
		<title>music matcher</title>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		  <link rel="stylesheet" href="css/bootstrap.min.css" type = "text/css"/>


		
		<!-- Tooltips --> 
   		<link rel="stylesheet" type="text/css" href="css/tooltipster.bundle.min.css" />
    	<script type="text/javascript" src="js/tooltipster.bundle.min.js"></script>
    	<!-- pop-ups -->
		<script src="js/bootbox.min.js"></script>
    	
    	<!-- Custom javascript -->
		<script src="js/marker.js" type="text/javascript"></script>

		<!-- Not required, used for page layout -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Custom styles -->
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		


		
		<?php
			include 'db_funcs.php';
		?>
	</head>

	<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">music matcher</a>
        <!-- responsive menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
              <a class="nav-link" href="index.php">home
              </a>
            </li>

            <li class="nav-item active">
              <a class="nav-link" href="#">detect</a>
                     <span class="sr-only">(current)</span>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="crop_notes.php">cropper</a>
            </li>
            
            <li class="nav-item ">
              <a class="nav-link" href="note_correction.php">note correction</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">contact</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="login.php">sign in</a>
            </li>
            
          </ul>
        </div>
      </div>
 
    </nav>
    
		<div class="container" style="margin-top: 10px">
			  <div class="row">


					


				<div class="col-xs-12 col-md-6" class="tooltip" title="" id="resdivwrapper" >
						
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
							reset
						</button>
						<button class="btn btn-default" id="submit_marker" class="tooltip" title="">
							i'm sure
						</button>
						
						
					</div>
					

				</div>
				
				
				<div class="col-xs-12 col-md-6" class="tooltip" id="" title="">
						<img id="dbpic" <?php
						load_random_image();
						?>>
				</div>
				
				


				
		</div>


		
		
	</body>
</html>
