<!DOCTYPE html>
<html>
	<head>
		<title>music matcher</title>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		  		<link rel="stylesheet" href="css/bootstrap.min.css" type = "text/css"/>

		<!-- CropSelectJs files -->
		<link href="node_modules/crop-select-js/crop-select-js.min.css" rel="stylesheet" type="text/css" />
		<script src="node_modules/crop-select-js//crop-select-js.min.js"></script>
		
		<!-- Tooltips --> 
   		<link rel="stylesheet" type="text/css" href="css/tooltipster.bundle.min.css" />
    	<script type="text/javascript" src="js/tooltipster.bundle.min.js"></script>
    	
    	<!-- Custom javascript -->
		<script src="js/script.js" type="text/javascript"></script>

		<!-- Not required, used for page layout -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Custom styles -->
		<link rel="stylesheet" type="text/css" href="css/style.css" />
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
            
            <li class="nav-item ">
              <a class="nav-link" href="mark_image.php">detect</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="crop_notes.php">cropper</a>
            </li>
            
            <li class="nav-item active">
              <a class="nav-link" href="#">note correction</a>
                              <span class="sr-only">(current)</span>

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

				<div class="col-xs-12 col-md-6" class="tooltip" title="nothing to see here. move to the left." id="resdivwrapper" >
						<div id="myresponse" ><span class="helper">your note selection will appear here	</span></div>
				</div>

				<div class="col-xs-12 col-md-6" class="tooltip" title="nothing to see here. move to the left." id="resdivwrapper" >
						<div id="myresponse" ><span class="helper">the text parts will appear here	</span></div>
				</div>
				
				</div>
				
				<br/>
			  <div class="row">

				<div class="col-xs-12 col-md-6" class="tooltip" title="nothing to see here. move to the left." id="resdivwrapper" >
						<div id="myresponse" ><span class="helper">output of omr</span></div>
				</div>

				<div class="col-xs-12 col-md-6" class="tooltip" title="nothing to see here. move to the left." id="resdivwrapper" >
						<div id="myresponse" ><span class="helper">output of ocr: faded out for now.</span></div>
				</div>
				
				</div>
				
		</div>



	</body>
</html>
