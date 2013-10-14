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
////	File discription: Main code
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////



// include 'db_connect_chips.php';


// Source files
include 'globals.php'; // global variables
include 'db_connect2.php'; //connect to the dbs
include 'db_query_functions.php'; //c

// include 'login_functions.php'; // login functions
include 'display_cpu_db_page_functions.php'; // display page functions
include 'get_info_functions.php'; // grabs lists and chip info
include 'debug_functions.php';
// sec_session_start(); // login function




/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//// 
////   Config
////


// $database_location='cpu-db.csv';
// $todo_file_loc_g='TODO.txt';
// $table_cpu_db ="cpu_db_table";







/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
////
////   Functions
////


















//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
////
////  Page selector
////

function main_page() {
	$html_code = '';

	$html_code .= display_header();
	// $html_code .= "+" .  $_GET["page"] ."-" . $_SERVER["QUERY_STRING"] . "+";
	if( empty($_GET["page"]) ){
		// $html_code .= "main_page";
		$html_code .= display_home_page();
	}elseif( $_GET["page"] === 'm' ){
		$html_code .= display_manuf_page($_GET["manuf"]);
	}elseif( $_GET["page"] === 'f' ){
		$html_code .= display_family_page($_GET["family"]);
	}elseif( $_GET["page"] === 'mf' ){
		$html_code .= display_manuf_family_page($_GET["manuf"],$_GET["family"]);
	}elseif( $_GET["page"] === 'c' ){
		$html_code .= display_single_chip_info_g($_GET["manuf"],$_GET["part"]);
	}elseif( $_GET["page"] === 'db' ){
		$html_code .= display_db_page();
	}elseif( $_GET["page"] === 'about' ){
		$html_code .= display_about_page();
	}elseif( $_GET["page"] === 'contrib' ){
		$html_code .= display_contrib_page();
	}elseif( $_GET["page"] === 'contrib_upload' ){
		$html_code .= display_contrib_upload_page();
	}elseif( $_GET["page"] === 'GIT_howto' ){
		// $html_code .= display_GIT_page();
	}elseif( $_GET["page"] === 'contact' ){
		$html_code .= display_contact_page();
	}elseif( $_GET["page"] === 'contact_confirm' ){
		$html_code .= display_contact_confirm_page();
	}elseif( $_GET["page"] === 'upload' ){
		$html_code .= display_upload_page();
	}elseif( $_GET["page"] === 'TODO' ){
		// $html_code .= display_todo_page();
	}elseif( $_GET["page"] === 'login' ){
		$html_code .= display_login_page();
	}elseif( $_GET["page"] === 'edit' ){
		// $html_code .= display_todo_page();
	}elseif( $_GET["page"] === 'add_chip' ){
		$html_code .= display_add_edit_chip_page("", "", "add");
	}elseif( $_GET["page"] === 'edit_chip' ){
		$html_code .= display_add_edit_chip_page($_GET["manuf"],$_GET["part"], "edit");
	}elseif( $_GET["page"] === 'cat' ){
		if( $_GET["type"] === 'chips' ){
			$html_code .= display_chips_page();
		}elseif( $_GET["type"] === 'manuf' ){
			$html_code .= display_manuf_list();
		}elseif( $_GET["type"] === 'families' ){
			$html_code .= display_families_list();
		}else{
			$html_code .= "Error: page category type invalid<br />";
		}
	}else{
		$html_code .= "Error: Page type invalid<br />";
	}

	$html_code .= display_footer();
	
	return $html_code;
}











////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////
////      main code
////


$html_code_g = '';
$html_title_g = 'cpu-db.info - a database for information on CPU, MCU, DSP, and BSP';
$html_keywords_g = 'CPU, MCU, DSP, BSP, database';
$script_name_g = ''; //#$ENV{'SCRIPT_NAME'};

// Connect to DB
// $db_handle = connect_db();

// sec_session_start();

// Run the code
$html_code_g .= main_page();

// Set the title, keywords
$html_code_g = preg_replace("/HTML_HEAD_TITLE/", $html_title_g, $html_code_g);
$html_code_g = preg_replace("/HTML_HEAD_KEYWORDS/", $html_keywords_g, $html_code_g);

// Print out the html
echo $html_code_g;	
echo "\n";

// Close the DB
mysql_close($db_handle);

?>
