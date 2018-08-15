<?php

function get_all_file_names_of_folder($path){
	$files = array();
	foreach(glob($path.'/*.png') as $file) {
		array_push($files, $file);
	}
	echo json_encode($files);
;
}


	// currently not used. could be reused for cropping advertisement.
	// js in cropper.js
/*
function crop_my_png_image($x,$y,$width,$heigth,$src){

	// crops picture and saves it

	$src = $src;
	
	$img_r = imagecreatefrompng($src);
	list($src_w, $src_h) = getimagesize($src);
	$dst_r = ImageCreateTrueColor( $width, $heigth );
	imagecopyresampled($dst_r,$img_r,0,0, $x,$y,
		$src_w,$src_h,$src_w,$src_h);
	header('Content-type: image/png');
	$output_file = basename($src);
	imagepng($dst_r, $output_file);
//	echo "<p>you deserve a cookie. but just one!</p>";
	echo "<img class='changed_img' src='$output_file?=". filemtime($output_file)."'/>";
	
	$conn = pg_pconnect("dbname=music_matcher user=postgres password=cs2018");
	$query = "insert into tbl_images values ('$dst_r', 'now')";
	$result = pg_query($query);

	if($result)
	{
	    echo "File is valid, and was successfully uploaded.\n";
	    unlink($uploadfile);
	}
	else
	{
	    echo "Filename already exists. Use another filename. Enter all the values.";
	    unlink($uploadfile);
	}
	pg_close($conn);
	
	imagedestroy($dst_r);
}

 

if( isset($_POST['x']) && isset($_POST['y'])&&
	isset($_POST['width']) && isset($_POST['height'])){
   crop_my_png_image($_POST['x'],$_POST['y'],
   	$_POST['width'],$_POST['height'],
    $_POST['src']);
   exit;
}
	*/
	
if (isset($_POST['path'])){
	$res= get_all_file_names_of_folder($_POST['path']);
	echo $res;
	exit;
}

?>
