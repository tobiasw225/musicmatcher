<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

	<head>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>  	
		<script type="text/javascript" src="http://localhost:8000/js/bootbox/bootbox.min.js"></script>
	</head>

	<body>

       <script>
		$(function() {
       		bootbox.alert({
				message : "du bist ausgeloggt",
				backdrop : true
			});
		});
        window.setTimeout(function(){ window.location = "http://localhost:8000/php/login.php"; },2000);
       </script>
        
        
     </body>
     </html>