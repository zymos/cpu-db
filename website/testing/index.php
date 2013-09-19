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
include 'db_connect.php'; //connect to the dbs
include 'login_functions.php'; // login functions
include 'display_cpu_db_pages.php'; // display page functions

sec_session_start(); // login function




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







/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
////
////       debug functiuons
////

function print_array($array){
	echo "<pre>\n";
	print_r($array);
	echo "</pre>\n<br />\n";
}









///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
////
////     DB Access
////

// function connect_db() {
	// global $host, $user, $pass, $db;
	
	// $db_handle = mysql_connect($host, $user, $pass);

	// if (!$db_handle) {
        // echo "Could not connect to server\n";
		// trigger_error(mysql_error(), E_USER_ERROR);
	// } 

	// $r2 = mysql_select_db($db);

	// if (!$r2) {
        // echo "Cannot select database\n";
		// trigger_error(mysql_error(), E_USER_ERROR); 
	// }
	// return $db_handle;
// }


function get_chip_count() {
	global $table_cpu_db;
	$col = 'part';
	$chip_count_array = array();
	$statement = "SELECT $col FROM $table_cpu_db";
	$chip_count_array = mysql_grab_array_1d($statement);
    $chip_count = count($chip_count_array);
	return $chip_count;
}



function get_update_date() {
	$statement = "SHOW TABLE STATUS FROM cpu_db WHERE Name = 'cpu_db_table'";
	// my $sth = $dbh->prepare($statement);
	// $sth->execute;
	// my $table_cpu_db = $sth->fetchall_arrayref;
	// my ($date, $time) = split(/ /,$table_cpu_db->[0][11]);
	// return $date;
	return;
}


function parse_db_query ( $query ) {
	global $db_handle;
	
	// $query = "SELECT DISTINCT manufacturer,chip_type,family FROM cpu_db_table";
	$results = array();

	$results = mysql_query( $query, $db_handle);
	if (!$results) {
    	echo "Could not execute query: $query\n";
	    trigger_error(mysql_error(), E_USER_ERROR);
	}
	return $results;
}

function mysql_fetch_all($res) {
   while($row=mysql_fetch_array($res)) {
       $return[] = $row;
   }
   return $return;
}


function mysql_fetch_array_1d($res) {
	while($row=mysql_fetch_array($res)) {
		if (!(empty($row[0]))){
			$return[] = $row[0];
		}
   }
   return $return;
}

function mysql_grab_array_1d($query) {
	$result_array = array();

	$result = parse_db_query( $query );
	$result_array = mysql_fetch_array_1d($result);
	return $result_array;
}


function mysql_grab_array_all($query) {
	$result_array = array();

	$result = parse_db_query( $query );
	$result_array = mysql_fetch_all($result);
	return $result_array;
}








/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//// 
////      Generate list
////


function get_manuf_family_chip_list($manuf, $family) {# page=mf
	global $table_cpu_db;

	$query = "SELECT part,chip_type,frequency_max_typ FROM $table_cpu_db WHERE manufacturer='$manuf' AND family='$family'";
	// $array_ref = $dbh->selectall_arrayref($statement);
	$result = mysql_grab_array_all( $query );

	// print_array($result);

	return $result;
}



function get_manuf_type_family_hash() { // 
	global $table_cpu_db;

	$man = '';
	$type = '';
	$fam = '';
	
	// %hashish = ();

	$hash_table = array();
	
	// echo "restuts";

	$query = "SELECT DISTINCT manufacturer,chip_type,family FROM $table_cpu_db";
	// $sth = $dbh->prepare($query);
	// $sth->execute();
	
	$results = parse_db_query( $query );
	// $results = mysql_query( $query );
// if (!$results) {
    // echo "Could not execute query: $query\n";
    // trigger_error(mysql_error(), E_USER_ERROR);
// } 

// while ($row = mysql_fetch_assoc($results)) {
		// printf("ID: %s  Name: %s", $row["manufacturer"], $row["chip_type"]);
		// echo $row["manufacturer"] .  $row["chip_type"] ;
	// }
	
	while($record = mysql_fetch_assoc($results)){ 
		// foreach ($record as $i) { echo "$i"; }
		if( !( empty($record["family"]) || empty($record["manufacturer"]))){
			
			// $hash_table = array( $record["manufacturer"] => array( $record["chip_type"] => array( $record["family"] => 1 )));
			$hash_table[$record["manufacturer"]][$record["chip_type"]][$record["family"]] = 1;
			// echo $record["manufacturer"] . " => " . $record["chip_type"] . " => " . $record["family"] . " <br />\n";
			// echo ">>> " . $hash_table[$record["manufacturer"]][$record["chip_type"]][$record["family"]] . "<br />\n";
		}

			
	}
	// print_array($hash_table);
	// while (($man, $type, $fam) = $sth->fetchrow()) {
		// $hashish{$man}{$type}{$fam} = 1;
		//# print "$man $type $fam\n";
	// } 
	// return %hashish;
	return 	$hash_table;
}




function get_manuf_list_alphabetical() { // page=cat&type=manuf
	global $table_cpu_db;


	$col = 'manufacturer';
	$query = "SELECT DISTINCT $col FROM $table_cpu_db";
	// $result = parse_db_query( $query );

	$result_array = array();
	$sorted_array = array();
	// $result_array = mysql_fetch_array_1d($result);
	
	$result_array = mysql_grab_array_1d($query);
	// while($row = mysql_fetch_row($result)){
		// if (!(empty($row[0]))){
			// $result_array[] = $row[0];
			// echo "$row[0] \n<br />";
		// }
	// print_r($result_array);

	// }
	// $ref = $dbh->selectcol_arrayref($statement);
	// @array = sort @{$ref};
	// print_array($result_array);
	natcasesort($result_array);
	// print_array($result_array);
	return $result_array;
}



function get_manufs_of_family_list($family) {// page=f&family=$family
	global $table_cpu_db;

	$family_list = array();

	$col_sel = 'manufacturer';
	$col_sort = 'family';

	$query = "SELECT DISTINCT $col_sel FROM $table_cpu_db WHERE $col_sort = '$family' ";

	$family_list = mysql_grab_array_1d($query);
	// my $statement = "SELECT DISTINCT $col_sel FROM $table_cpu_db WHERE $col_sort = \'$family\' ";
	// my $ref = $dbh->selectcol_arrayref($statement);
	// my @family_list = sort @{$ref};
	// return @family_list;
	return $family_list;
}



function get_family_list_by_type($type) { // page=cat&type=families (CPU)
	global $table_cpu_db;
	
	$col = 'family';

	$result_array = array();
	
	$query = "SELECT DISTINCT $col FROM $table_cpu_db WHERE chip_type = '$type'";

	$result_array = mysql_grab_array_1d($query);

	return $result_array;
}






function display_families_list() { // page=cat&type=families
	global $html_title_g, $html_keywords_g;

	$html_code = '';
	$fam_list_cpu = array();
	$fam_list_mcu = array();
	$fam_list_dsp = array();
	$fam_list_bsp = array();
	
	$html_title_g = 'cpu-db.info - CPU Family List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, family';

	$fam_list_cpu = get_family_list_by_type("CPU");
	$fam_list_mcu = get_family_list_by_type("MCU");
	$fam_list_dsp = get_family_list_by_type("DSP");
	$fam_list_bsp = get_family_list_by_type("BSP");

	$alphabet = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	$text_tmp = '';
	$set = 0;



	#my $ref = $sth->fetchall_arrayref;
	$html_code .= <<<Endhtml
	<h1>Processor Families</h1>
	<table>
		<tr>
			<td class="family_table_td">
Endhtml;

	// CPU
	$html_code .= "				<h1>CPU</h1>\n";
	
	foreach ( $alphabet as $letter ) {
		$set = 0;
		$text_tmp = '';
		// foreach $row ( sort @fam_list_cpu ) {
		foreach ( $fam_list_cpu as $row ){
			if( preg_match("/^$letter/i", $row) ) {
				$text_tmp .= "			<span style=\"padding-left: 10px;\"><a href=\"$script_name_g?page=f&amp;family=$row\">$row</a></span><br />\n";
				$set = 1;
			}
		}
		if( $set == 1 ){
			$html_code .= "\t<b>$letter:</b><br />\n";
			$html_code .= $text_tmp;
			$html_code .= "\t<br />\n";
		}
	}	

	// MCU
	$html_code .= "			</td><td class=\"family_table_td\">\n";
	$html_code .= "			<h1>MCU</h1>\n";

	foreach ( $alphabet as $letter ) {
		$set = 0;
		$text_tmp = '';
		// foreach $row ( sort @fam_list_cpu ) {
		foreach ( $fam_list_mcu as $row ){
			if( preg_match("/^$letter/i", $row) ) {
				$text_tmp .= "			<span style=\"padding-left: 10px;\"><a href=\"$script_name_g?page=f&amp;family=$row\">$row</a></span><br />\n";
				$set = 1;
			}
		}
		if( $set == 1 ){
			$html_code .= "\t<b>$letter:</b><br />\n";
			$html_code .= $text_tmp;
			$html_code .= "\t<br />\n";
		}
	}	


	// DSP
		// $html_code .= "			</td></tr><tr><td class=\"family_table_td\">\n";
		//
	$html_code .= "			<br /><br /><br /><br />\n";
	$html_code .= "			<h1>DSP</h1>\n";

	foreach ( $alphabet as $letter ) {
		$set = 0;
		$text_tmp = '';
		// foreach $row ( sort @fam_list_cpu ) {
		foreach ( $fam_list_dsp as $row ){
			if( preg_match("/^$letter/i", $row) ) {
				$text_tmp .= "			<span style=\"padding-left: 10px;\"><a href=\"$script_name_g?page=f&amp;family=$row\">$row</a></span><br />\n";
				$set = 1;
			}
		}
		if( $set == 1 ){
			$html_code .= "\t<b>$letter:</b><br />\n";
			$html_code .= $text_tmp;
			$html_code .= "\t<br />\n";
		}
	}	

	// BSP
	// $html_code .= "			</td><td class=\"family_table_td\">\n";
	$html_code .= "			<br /><br /><br /><br />\n";

	$html_code .= "			<h1>BSP</h1>\n";


	foreach ( $alphabet as $letter ) {
		$set = 0;
		$text_tmp = '';
		// foreach $row ( sort @fam_list_cpu ) {
		foreach ( $fam_list_bsp as $row ){
			if( preg_match("/^$letter/i", $row) ) {
				$text_tmp .= "			<span style=\"padding-left: 10px;\"><a href=\"$script_name_g?page=f&amp;family=$row\">$row</a></span><br />\n";
				$set = 1;
			}
		}
		if( $set == 1 ){
			$html_code .= "\t<b>$letter:</b><br />\n";
			$html_code .= $text_tmp;
			$html_code .= "\t<br />\n";
		}
	}	


	$html_code .= <<<Endhtml
			</td>
		</tr>
	</table>
Endhtml;

	return $html_code;
}




function get_single_chip_info($manuf, $part) {# page=c
	global $table_cpu_db;
	$query = "SELECT manufacturer,family,part,alternative_label_1,alternative_label_2,alternative_label_3,alternative_label_4,alternative_label_5,alternative_label_6,chip_type,sub_family,model_number,core,core_designer,microarchitecture,threads,cpuid,core_count,pipeline,multiprocessing,architecture,data_bus_ext,address_bus,bus_comments,frequency_ext,frequency_min,frequency_max_typ,actual_bus_frequency,effective_bus_frequency,bus_bandwidth,clock_multiplier,core_stepping,l1_data_cache,l1_data_associativity,l1_instruction_cache,l1_instruction_associativity,l1_unified_cache,l1_unified_associativity,l2_cache,l2_associativity,l3_cache,l3_associativity,boot_rom,rom_internal,rom_type,ram_internal,ram_max,ram_type,virtual_memory_max,package,package_size,package_weight,socket,transistor_count,process_size,metal_layers,metal_type,process_technology,die_size,rohs,vcc_core_range,vcc_core_typ,vcc_secondary,vcc_tertiary,vcc_i_o,i_o_compatibillity,power_min,power_typ,power_max,power_thermal_design,temperature_range,temperature_grade,low_power_features,instruction_set,instruction_set_extensions,additional_instructions,computer_architecture,isa,fpu,on_chip_peripherals,features,production_type,clone,release_date,initial_price,applications,military_spec,comments,reference_1,reference_2,reference_3,reference_4,reference_5,reference_6,reference_7,reference_8,photo_front_filename_1,photo_front_creator_1,photo_front_source_1,photo_front_copyright_1,photo_front_comment_1,photo_back_filename_1,photo_back_source_1,photo_back_creator_1,photo_back_copyright_1,photo_back_comment_1,photo_front_filename_2,photo_front_creator_2,photo_front_source_2,photo_front_copyright_2,photo_front_comment_2,photo_back_filename_2,photo_back_creator_2,photo_back_source_2,photo_back_copyright_2,photo_back_comment_2,photo_front_filename_3,photo_front_creator_3,photo_front_source_3,photo_front_copyright_3,photo_front_comment_3,photo_back_filename_3,photo_back_creator_3,photo_back_source_3,photo_back_copyright_3,photo_back_comment_3,photo_front_filename_4,photo_front_creator_4,photo_front_source_4,photo_front_copyright_4,photo_front_comment_4,photo_back_filename_4,photo_back_creator_4,photo_back_source_4,photo_back_copyright_4,photo_back_comment_4,die_photo_filename_1,die_photo_creator_1,die_photo_source_1,die_photo_copyright_1,die_photo_comment_1 FROM $table_cpu_db WHERE manufacturer='$manuf' AND part='$part'";
	// my $chip_hash_ref = $dbh->selectrow_hashref($statement);
	$return_array = array();
	$return_array = mysql_grab_array_all($query);
	// echo "rat";
	$return_array = $return_array[0];
	// print_array($return_array );
	return $return_array;
}






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
			$html_code .= "error?<br />";
		}
	}else{
		$html_code .= "error?<br />";
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
