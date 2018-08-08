<?php

/**
 * receives the path to the cropped image and calls audiveris
 */
$audiveris_path =  '/home/Audiveris/bin/Audiveris';
$audiveris_options = '-batch -print -export -output';
 
if( isset($_POST['proc_image'])){

	// that's just for testing => move to db
	$input_file = str_replace("../res","../out",$_POST['proc_image']);
	
	$output_folder = '../out';
	$cmd = "$audiveris_path $audiveris_options $output_folder $input_file  > /tmp/a.txt 2>&1";


	if(is_file($input_file)) { echo "<b>Works:" . $input_file . "</b></br>"; } else {
		echo $input_file;
	}
	$cmd = "/home/docker/Audiveris/bin/Audiveris -batch -print -export -output ../out ../out/bub_gb_1UMvAAAAMAAJ_Page_0x131df.png ";
	echo $cmd;
	$output = system($cmd);

//	$output = exec($cmd);
	//exec("sh speech.sh ".escapeshellarg("hello this is a test"));
	

	echo "<pre>$output</pre>";
   exit;
}

?>
