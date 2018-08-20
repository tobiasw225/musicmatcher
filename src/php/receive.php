<?php

function get_all_file_names_of_folder($path){
	$files = array();
	foreach(glob($path.'/*.png') as $file) {
		array_push($files, $file);
	}
	echo json_encode($files);
;
}
if (isset($_POST['path'])){
	$res= get_all_file_names_of_folder($_POST['path']);
	echo $res;
	exit;
}




?>
