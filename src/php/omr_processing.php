<?php

/**
 * receives the path to the cropped image and calls audiveris
 */
$audiveris_path =  '/home/Audiveris/bin/Audiveris';
$audiveris_options = '-batch -print -export -output';
 
if( isset($_POST['proc_image'])){

	// that's just for testing => move to db
	$input_file = str_replace("res","out",$_POST['proc_image']);
	
	$output_folder = '../out';
	$cmd = "$audiveris_path $audiveris_options $output_folder $input_file 2>/dev/null >/dev/null &";
	// 2>/dev/null >/dev/null &";
	echo $cmd;

	$output = shell_exec($cmd);

	echo "<pre>$output</pre>";
   exit;
}

?>
