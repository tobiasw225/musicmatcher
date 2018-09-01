<?php 
session_start();
?>
<?php
/**
 * constants for user points. could also be saved in db
 */
$tag_bonus = 10;
$ocr_bonus = 20;

/**--------------------------------------------------------------------------
 * Function to handle Database Access
-------------------------------------------------------------------------- */

// change this according to settings
$conn_string = "host=172.18.0.2 port=5432 dbname=musicmatcher user=postgres password=cs2018";

/**--------------------------------------------------------------------------
 * Helper functions
 --------------------------------------------------------------------------*/
function test_sql($res) {
		if (!$res) {
			echo "sql went wrong.";
			exit;
		} 
}
 
function check_conn($conn){
	$stat = pg_connection_status($conn);
	 if ($stat !== PGSQL_CONNECTION_OK) {
	      echo 'Bad connection status';
		 exit;
	 } 
}

function get_conn(){
	global $conn_string;
	$conn = pg_pconnect("$conn_string") or die("Could not connect");
	check_conn($conn);
	return $conn;
}

function exec_sql($sql) {
	$conn = get_conn();
	$res = pg_query($conn,$sql);
	pg_close($conn);
	test_sql($res);
	return $res;
}
/**
 * user functions
 */
 
 function register_user($username, $email, $password){
			$conn = get_conn();
			$query = pg_query($conn, "INSERT INTO tbl_users (u_name, u_psw, u_mail, u_points) VALUES ('$username', '$password', '$email', 0) RETURNING u_id;");
			$row = pg_fetch_row($query);
			// assign default-group
			$u_id = $row['0'];
			$sql = "INSERT INTO rel_user_in_group (u_id, g_id) VALUES ('$u_id', 1)";
			$res = exec_sql($sql);
			test_sql($res);
 }
 
 $c_uname = '';
 $c_points = 0;
 $c_uid = 0;
 function login_user($u_name, $u_psw){
 	$sql = "SELECT u_id, u_name, u_points FROM tbl_users WHERE u_name = '$u_name' AND u_psw='$u_psw'";
	$res = exec_sql($sql);
	$row = pg_fetch_row($res);
	global $c_uname, $c_points, $c_uid;
	$c_uname = $row['1'];
	$c_points = $row['2'];
	$c_uid = $row['0'];
 }
 
 function update_user_point($u_id, $u_points) {
 		$sql = "UPDATE tbl_users SET u_points ='$u_points' WHERE u_id=$u_id;";
		exec_sql($sql);

 }
 
/**--------------------------------------------------------------------------
 * Functions to load and save tags 
 --------------------------------------------------------------------------*/
function load_tags(){
		$sql = <<<EOF
      SELECT tag_name FROM tbl_tags;
EOF;
	$res = exec_sql($sql);
	//$tag_array = array();
	$tags_string = "";
	while ($row = pg_fetch_row($res)) {
		$tag = strtolower($row[0]);
		$tags_string .= "$tag ";
		//array_push($tag_array,"$tag");
  		//echo "<span class='tags'>$tag</span>";
  		//echo "<option value=$tag>";	
	}
	
	return $tags_string; 
}




function insert_tag_into_db($tag){
	// return
	$conn = get_conn();
	
	//$sql = "INSERT INTO tbl_tags (tag_name) VALUES ('$tag');";
	//$result = pg_query($conn, $sql);
	
	// @todo only insert if not existing.
	$sql = "SELECT tag_id FROM tbl_tags WHERE tag_name = '$tag'";
	$res = exec_sql($sql);

	$row = pg_fetch_row($res);
	$new_id = $row['0'];
	
	test_sql($res);
	pg_close($conn);
	return $new_id;
}

function update_has_sm($has_sm, $res_id){
	// not tested
	$sql = "UPDATE tbl_resources SET res_has_sheet_music = $has_sm WHERE res_id='$res_id';";
	exec_sql($sql);
}

function update_pic_status($edit_status, $res_id){
	$sql = "UPDATE tbl_res SET res_status ='$edit_status' WHERE res_id=$res_id;";
	exec_sql($sql);
}

function insert_res_has_tag($tag_id, $res_id, $u_id){
	$sql = "INSERT INTO rel_res_has_tags (tag_id, res_id) VALUES ('$tag_id','$res_id');";
	exec_sql($sql);
}

function insert_res_info($res_id, $is_title_page,
		$sm_count, $ad_count,$u_id){
			
		$sql = "INSERT INTO tbl_res_info (res_id, u_id, res_ad_count, res_sm_count, res_is_title_page) VALUES ('$res_id','$u_id', '$ad_count', '$sm_count', '$is_title_page');";
	echo "$sql";
	exec_sql($sql);
}


/**--------------------------------------------------------------------------
 * Load Images from database
 * 
 --------------------------------------------------------------------------*/
function get_random_res_res_id(){

	$sql = <<<EOF
      SELECT res_id FROM tbl_res ORDER BY res_id DESC LIMIT 1;
EOF;
	$res = exec_sql($sql);
	$max = pg_fetch_result($res, 'res_id');	
	
	$sql = <<<EOF
      SELECT res_id FROM tbl_res ORDER BY res_id LIMIT 1;
EOF;
	$res = exec_sql($sql);
	$min = pg_fetch_result($res, 'res_id');	
	
	return rand($min,$max);;
}

function load_png_from_db($res_id){
	/**
	 * 
	 */
	$sql = <<<EOF
      SELECT res_img_path, res_img_thumb_path FROM tbl_res WHERE res_id = '$res_id';
EOF;
	$res = exec_sql($sql);
	$row = pg_fetch_row($res);		
	$img_path = "http://localhost:8000/" . $row[0];
	$thumb_path = $row[1];
	echo "key=$res_id src='$img_path'";
}

function load_pdf_from_db($res_id){
	/**
	 * 
	 */
	$sql = <<<EOF
      SELECT res_pdf_path FROM tbl_res WHERE res_id = '$res_id';
EOF;
	$res = exec_sql($sql);

	$row = pg_fetch_row($res);		
	$pdf_path = $row[0];
	echo "$res_id, $pdf_path";
}


function load_random_png_image() {
	$res_id = get_random_res_res_id();
	load_png_from_db($res_id);
}

function load_random_pdf_image() {
	$res_id = get_random_res_res_id();
	load_pdf_from_db($res_id);
	
}


/**--------------------------------------------------------------------------
 * Handle POST-Variables
 --------------------------------------------------------------------------*/
if (isset($_POST['tag_like'])){
	$res= load_tags_like($_POST['tag_like']);
	echo $res;
	exit;
}

if (isset($_POST['init_image'])){
	echo load_random_pdf_image();
	exit;
}

if (isset($_POST['get_all_tags'])){
	echo load_tags();
}


/**
 * call functions to insert tags + meta information
 */
if( isset($_POST['insert_meta'])){
		$res_id = $_POST['res_id'];
		// save res_id for possible reuse in ocr
		$_SESSION['last_res_id'] = $res_id;
		// get user-id from session
		$u_id = $_SESSION['user_id'];
		// mark the res. as being 'touched'
		update_pic_status('touched',$res_id);

		insert_res_info($res_id, $_POST['is_title_page'],
		$_POST['sm_count'], $_POST['ad_count'],$u_id);
		
		// connect tags and res
		if (isset($_POST['tags'])){
			foreach ($_POST['tags'] as $tag) {
           		$tag_id = insert_tag_into_db($tag);
				insert_res_has_tag($tag_id, $res_id, $u_id);
       		}
		}
		$_SESSION['user_points'] = $_SESSION['user_points']+$tag_bonus;
		update_user_point($u_id, $_SESSION['user_points']);
}




?>
