<?php
/**--------------------------------------------------------------------------
 * Function to handle Database Access
-------------------------------------------------------------------------- */

// change this according to settings
$conn_string = "host=localhost port=5432 dbname=test user=tobias password=test123";

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

/**--------------------------------------------------------------------------
 * Functions to load and save tags 
 --------------------------------------------------------------------------*/
function load_tags(){
		$sql = <<<EOF
      SELECT tag_name FROM tbl_tags LIMIT 15;
EOF;
	$res = exec_sql($sql);
	while ($row = pg_fetch_row($res)) {
		$tag = strtolower($row[0]);
  		echo "<span class='tags'>$tag</span>";
	}
	
}

function load_tags_like($tag){
		$tag_search_sql = <<<SQL
	      SELECT tag_name FROM tbl_tags WHERE tag_name LIKE '%$tag%' LIMIT 15;
SQL;
		$res = exec_sql($tag_search_sql);
		while ($row = pg_fetch_row($res)) {
			$tag = strtolower($row[0]);
	  		echo "<span class='tags'>$tag</span>";
		}
}

function insert_tag_into_db($tag){
	// return
	$conn = get_conn();
	$sql = "INSERT INTO tbl_tags (tag_name) VALUES ('$tag');";
	$result = pg_query($conn, $sql);
	test_sql($result);
	pg_close($conn);
}

function update_has_sm($has_sm, $res_id){
	// not tested
	$sql = "UPDATE tbl_resources SET res_has_sheet_music = $has_sm WHERE res_id='$res_id';";
	exec_sql($sql);
}

function update_pic_status($edit_status, $res_id){
	$sql = "UPDATE tbl_images_txt SET img_status ='$edit_status' WHERE img_id=$res_id;";
	exec_sql($sql);
}

function insert_res_has_tag($tag_id, $res_id){
	// not tested
	$sql = "INSERT INTO rel_res_has_tags (tag_id, res_id) VALUES ('$tag_id','$res_id');";
	exec_sql($sql);
}


/**--------------------------------------------------------------------------
 * Load Images from database
 * 
 --------------------------------------------------------------------------*/
function get_random_img_res_id(){

	$sql = <<<EOF
      SELECT img_id FROM tbl_images_txt ORDER BY img_id DESC LIMIT 1;
EOF;
	$res = exec_sql($sql);
	$max = pg_fetch_result($res, 'img_id');	
	
	$sql = <<<EOF
      SELECT img_id FROM tbl_images_txt ORDER BY img_id LIMIT 1;
EOF;
	$res = exec_sql($sql);
	$min = pg_fetch_result($res, 'img_id');	
	
	return rand($min,$max);;
}

function load_img_from_db($img_id){
	$sql = <<<EOF
      SELECT * FROM tbl_images_txt WHERE img_id = '$img_id';
EOF;
	$res = exec_sql($sql);
	$raw = pg_fetch_result($res, 'img_obj_txt');
	$id = pg_fetch_result($res, 'img_id');	
	// Convert to binary and send to the browser
	echo "key=$id src='data:image;base64, $raw' ";
}

function insert_img_into_db($file_path){
	$binary = file_get_contents("../".$file_path);
	$base64 = base64_encode($binary);
	$sql = "INSERT INTO tbl_images_txt (img_obj_txt) VALUES ('$base64');";
	exec_sql($sql);
}

function load_random_image() {
	$img_id = get_random_img_res_id();
	load_img_from_db($img_id);
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
	$res= load_random_image();
	echo $res;
	exit;
}

if( isset($_POST['is_title_page']) &&
 isset($_POST['is_sheet_music']) 
 && isset($_POST['res_id'])){

		//update_has_sm($_POST['is_sheet_music'], $res_id){
		update_pic_status('touched', $_POST['res_id']);
		if (isset($_POST['tags'])){
			foreach ($_POST['tags'] as $tag) {
           		insert_tag_into_db($tag);
				//insert_res_has_tag($tag_id, $res_id);
       		}
		}
		if (!$_POST['is_sheet_music']) {
		// should never come here, but just in case
		header( 'Location: php/mark_image.php' );
		} 

	

}



/*
class MMDatabase {
	function __construct(){
		$this->note_limit = 20;
		$this->db = pg_connect("host=localhost port=5432 dbname=test user=tobias password=test123");
 		if(!$this->db){
        	echo 'there has been an error connecting';
    	} 
	} // end-of-constructor
	
	
	function insert_img_into_db($file_path){
		
		 //saves the image as txt in a postgres-database
		 

		$binary = file_get_contents("../".$file_path);
		$base64 = base64_encode($binary);
		$sql = "INSERT INTO tbl_images_txt (img_obj_txt) VALUES ('$base64');";
		$result = pg_query($this->db, $sql);
		if (!$result) {
		  echo "Es gab einen Fehler beim Einfügen in die Datenbank.\n";
		  exit;
		}
	}
}

function initDB() {
	global $db;
	$db = new MMDatabase();
	if (!$db) {
		echo $db -> lastErrorMsg();
	}
}
*/


?>