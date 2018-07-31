<?php

function get_all_file_names_of_folder($path){
	/*$files = scandir($path);
	$files = array_diff(scandir($path), array('.', '..'));
	if (count($files) != 0){
		foreach (files as $value) {
    echo "$value <br>";
	}
		return $files;
	}
	*/
	$files = array();
	foreach(glob($path.'/*.png') as $file) {
		array_push($files, $file);
	}
	return $files;
}

function crop_my_jpg_image($x,$y,$width,$heigth,$src){

	$jpeg_quality = 90;
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $width, $heigth );

	imagecopyresampled($dst_r,$img_r,0,0,$x,$y,
	$width,$heigth,$width,$height);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
}


function crop_my_png_image($x,$y,$width,$heigth,$src){
	/**
	* crops picture and saves it
	**/
	$src = '../'.$src;
	$img_r = imagecreatefrompng($src);
	list($src_w, $src_h) = getimagesize($src);
	$dst_r = ImageCreateTrueColor( $width, $heigth );
	imagecopyresampled($dst_r,$img_r,0,0, $x,$y,
		$src_w,$src_h,$src_w,$src_h);
	header('Content-type: image/png');
	$output_file = "../out/".basename($src);
	imagepng($dst_r, $output_file);
//	echo "<p>you deserve a cookie. but just one!</p>";
//	echo $output_file;
	echo "<img class='changed_img' src='$output_file?=". filemtime($output_file)."'/>";
	imagedestroy($dst_r);
	

}

if( isset($_POST['x']) && isset($_POST['y'])&&
	isset($_POST['width']) && isset($_POST['height'])){
   crop_my_png_image($_POST['x'],$_POST['y'],
   	$_POST['width'],$_POST['height'],
    $_POST['src']);
   exit;
}
	
if (isset($_POST['path'])){
	$res= get_all_file_names_of_folder($_POST['path']);
	echo $res;
	exit;
}

?>
