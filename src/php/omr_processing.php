<?php

/**
 * receives the path to the cropped image and calls audiveris
 */
$audiveris_path =  '../Audiveris/bin/Audiveris';
$audiveris_options = '-batch -print -export -output';
 
if( isset($_POST['proc_image'])){
	// tesseract not found
	// that's just for testing
	$input_file = "../". $_POST['proc_image'];
	$output_file = str_replace("res", "out", $input_file);
	$cmd = "$audiveris_path $audiveris_options $output_file $input_file";
	echo $cmd;
   $output = shell_exec("$cmd");
	echo "<pre>$output</pre>";
   exit;
}

?>