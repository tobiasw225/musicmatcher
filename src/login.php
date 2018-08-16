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
        <a class="navbar-brand" href="#">music matcher</a>
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
                        <li class="nav-item">
              <a class="nav-link" href="note_correction.php">note correction</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">contact</a>
            </li>

            <li class="nav-item active">
              <a class="nav-link" href="#">sign in</a>
                    <span class="sr-only">(current)</span>
            </li>
            
          </ul>
        </div>
      </div>
 
    </nav>
    
      <div class="container" style="margin-top: 10px">

    <div class="row" style="margin-top:20px">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <form th:action="@{/login}" method="post">
                <fieldset>
                    <h1>Please Sign In</h1>

                    <div th:if="${param.error}">
                        <div class="alert alert-danger">
                            Invalid username and password.
                        </div>
                    </div>
                    <div th:if="${param.logout}">
                        <div class="alert alert-info">
                            You have been logged out.
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" name="username" id="username" class="form-control input-lg"
                               placeholder="UserName" required="true" autofocus="true"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg"
                               placeholder="Password" required="true"/>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign In"/>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</div>

	<div class="navbar navbar-fixed-bottom">
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a>
	</div>
	</body>
</html>
