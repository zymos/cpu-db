<!DOCTYPE html>
<?php

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: list images
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: Sept 2013
////    


/////////////
// Config


////////////
// code
include 'globals.php';
// include 'login_functions.php'; // login functions
include 'db_connect2.php';
include 'db_query_functions.php'; //c
include 'display_cpu_db_page_functions.php'; // display page functions
include 'get_info_functions.php'; // grabs lists and chip info
include 'log_functions.php'; //append log



function display_login_attempts_list(){
	global $mysqli;

	$html_code = '';

	if( $results = $mysqli->query("SELECT user_id, time FROM login_attempts") ) { 
		$html_code .= "<table border=\"1\">\n";
		$html_code .= "  <tr>\n";
		$html_code .= "    <td><b>user_id</b></td>\n";
		$html_code .= "    <td><b>username</b></td>\n";
		$html_code .= "    <td><b>time</b></td>\n";
		$html_code .= "    <td><b>readable time</b></td>\n";
		$html_code .= "  </tr>\n";
		while ( $row = $results->fetch_assoc() ) {
			$html_code .= "  <tr>\n";
			$html_code .= "    <td>" . $row['user_id'] . "</td>\n";
			$html_code .= "    <td>" . $row['username'] . "</td>\n";
			$html_code .= "    <td>" . $row['time'] . "</td>\n";
			$html_code .= "    <td>" . date("Y-m-d H:i:s",$row['time']) . "</td>\n";
			$html_code .= "  </tr>\n";
		}
		$html_code .= "</table>\n";
	}
	return $html_code;
}







function display_user_list(){
	global $mysqli;

	$html_code = '';

	if( $results = $mysqli->query("SELECT id, username, email FROM members") ) { 
		$html_code .= "<table border=\"1\">\n";
		$html_code .= "  <tr>\n";
		$html_code .= "    <td><b>id</b></td>\n";
		$html_code .= "    <td><b>username</b></td>\n";
		$html_code .= "    <td><b>email</b></td>\n";
		$html_code .= "  </tr>\n";
		while ( $row = $results->fetch_assoc() ) {
			$html_code .= "  <tr>\n";
			$html_code .= "    <td>" . $row['id'] . "</td>\n";
			$html_code .= "    <td>" . $row['username'] . "</td>\n";
			$html_code .= "    <td>" . $row['email'] . "</td>\n";
			$html_code .= "  </tr>\n";
		}
		$html_code .= "</table>\n";
	}
	return $html_code;
}




function print_image_list(){
	global $upload_folder, $resize_folder, $db_handle, $table_cpu_db_images;

	$html_code = '';

	$query = "SELECT * FROM $table_cpu_db_images";

	$results = array();
	$results = mysql_query( $query, $db_handle);

	if (!$results) {
    	$html_code .= "Could not execute query: $query\n";
	    trigger_error(mysql_error(), E_USER_ERROR);
	}else{
	}

	$html_code .= "<table border=\"1\">\n";
	$html_code .= "  <tr>\n";
	$html_code .= "    <td><b>manuf</b></td>\n";
	$html_code .= "    <td><b>part</b></td>\n";
	$html_code .= "    <td><b>filename</b></td>\n";
	$html_code .= "    <td><b>thumb_filename</b></td>\n";
	$html_code .= "    <td><b>side</b></td>\n";
	$html_code .= "    <td><b>description</b></td>\n";
	$html_code .= "    <td><b>license</b></td>\n";
	$html_code .= "    <td><b>author</b></td>\n";
	$html_code .= "    <td><b>source</b></td>\n";
	$html_code .= "    <td><b>date_created</b></td>\n";
	$html_code .= "    <td><b>comments</b></td>\n";
	$html_code .= "    <td><b>file_type</b></td>\n";
	$html_code .= "    <td><b>file_size</b></td>\n";
	$html_code .= "    <td><b>image_size</b></td>\n";
	$html_code .= "    <td><b>username</b></td>\n";
	$html_code .= "    <td><b>date_uploaded</b></td>\n";
	$html_code .= "  </tr>\n";
	
	while ($row = mysql_fetch_assoc($results)) {
		$html_code .= "  <tr>\n";
		$html_code .= "    <td>" . $row['manuf'] . "</td>\n";
		$html_code .= "    <td>" . $row['part'] . "</td>\n";
		$html_code .= "    <td><a href=\"$upload_folder" . $row['filename'] . "\">" . $row['filename'] . "</td>\n";
		$html_code .= "    <td><a href=\"$resize_folder" . $row['thumb_filename'] . "\">[Thumb]</td>\n";
		$html_code .= "    <td>" . $row['side'] . "</td>\n";
		$html_code .= "    <td>" . $row['description'] . "</td>\n";
		$html_code .= "    <td>" . $row['license'] . "</td>\n";
		$html_code .= "    <td>" . $row['author'] . "</td>\n";
		$html_code .= "    <td>" . $row['source'] . "</td>\n";
		$html_code .= "    <td>" . $row['date_created'] . "</td>\n";
		$html_code .= "    <td>" . $row['comments'] . "</td>\n";
		$html_code .= "    <td>" . $row['file_type'] . "</td>\n";
		$html_code .= "    <td>" . $row['file_size'] . "</td>\n";
		$html_code .= "    <td>" . $row['image_size'] . "</td>\n";
		$html_code .= "    <td>" . $row['username'] . "</td>\n";
		$html_code .= "    <td>" . $row['date_uploaded'] . "</td>\n";
		$html_code .= "  </tr>\n";
	}
	$html_code .= "</table>\n";
	return $html_code;	
}







function admin_main_page(){
	global $mysqli, $admin_username;
	$html_code = '';

	$html_code .= "<h1>Administrative page</h1>\n";
	$html_code .= "<div style=\"border-width: 3px; border-style: solid; padding: 15px;\">\n";

	if(login_check($mysqli) == true) {
		if( $_SESSION['username'] === $admin_username ){
			$html_code .= <<<Endhtml
<div><a href="admin.php?p=chip">chip list</a> | <a href="admin.php?p=image">image list</a> | <a href="admin.php?p=user">users list</a> | <a href="admin.php?p=login_attempts">login_attempts list</a> | <a href="admin.php?p=change">change list</a> | <a href="cpu-db.log">log</a> | <a href="php-tail-read-only/Log.php">apache log</a></div><br /><br />
Endhtml;

			if( empty($_GET["p"]) ){
				
			}elseif( $_GET["p"] === 'image' ){
				$html_code .=print_image_list();
			}elseif( $_GET["p"] === 'user' ){
				$html_code .= display_user_list();
			}elseif( $_GET["p"] === 'change' ){
		
			}elseif( $_GET["p"] === 'login_attempts' ){
				$html_code .= display_login_attempts_list();
			}
	
		}else{
			$html_code .= "not an admin<br />\n";
		}
	}else{
		$html_code .= "not logged in, <a href=\"login.php\">Login/Register</a>";
	}
	$html_code .= "</div>\n";
	return $html_code;
}







############################################
# Main code
#

$html_code_g = '';
$html_title_g = 'cpu-db.info - Admin';
$html_keywords_g = 'CPU, MCU, DSP, BSP, database';
$script_name_g = 'admin.php'; //#$ENV{'SCRIPT_NAME'};


$html_code_g .= display_header();

$html_code_g .= admin_main_page();

$html_code_g .= display_footer();



echo $html_code_g;	
mysql_close($db_handle);

?>
</body>
</html>
