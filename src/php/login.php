<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>

		<title>music matcher</title>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  		<link rel="stylesheet" href="http://localhost:8000/css/bootstrap.min.css" type = "text/css"/>

		<!-- Tooltips --> 
    	<script type="text/javascript" src="http://localhost:8000/js/tooltipster/tooltipster.bundle.min.js"></script>
    	
    	<!-- Custom javascript -->

		<!-- Not required, used for page layout -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Custom styles -->
		<link rel="stylesheet" type="text/css" href="http://localhost:8000/css/style.css" />


		<link rel="stylesheet" type="text/css" href="http://localhost:8000/css/login_style.css" media="all" />
		<script src="http://localhost:8000/js/login.js" type="text/javascript"></script>
	</head>
	

	<body>

		<?php 
		include ('../html_snippets/nav_bar.php');
		include ('../html_snippets/user_info.php');
		?>
		
      <div class="container" style="margin-top: 10px">

    <div class="row" style="margin-top:20px">
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="#" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="log_username" id="log_username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="log_password" id="log_password" tabindex="2" class="form-control" placeholder="Password">
									</div>
	
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>

								</form>
								<form id="register-form" action="#" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="reg_username" id="sgn_username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="reg_email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="reg_password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="reg_confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<?php 
	include('db_funcs.php');
	// register users
	if (isset($_POST["reg_username"]) && isset($_POST["reg_email"]) 
		&& isset($_POST["reg_password"]) &&  isset($_POST["reg_confirm_password"])){
			
			if (($_POST["reg_password"] == $_POST["reg_confirm_password"])
			&& strlen($_POST["reg_password"])){
				// @todo catch already existing
				register_user($_POST["reg_username"], $_POST["reg_email"], $_POST["reg_password"]);
			} else {
				echo "Passwörter stimmen nicht überein.";
			}
 	}
 	if (isset($_POST["log_username"]) && isset($_POST["log_password"])) {
 		if (strlen($_POST["log_username"]) && strlen($_POST["log_password"])){
 			login_user($_POST["log_username"], $_POST["log_password"]);
			//Session registrieren
			$_SESSION['user_name'] = $c_uname;
 			$_SESSION['user_points'] = $c_points;
			$_SESSION['user_id'] = $c_uid;
 		} 
	}
 	
 	
 
 ?>


	<div class="navbar navbar-fixed-bottom">
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a>
	</div>
	</body>
</html>
