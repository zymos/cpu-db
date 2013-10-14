<?php
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: functions that grab info from 
////    the DBs
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////


/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//// 
////      Generate list
////




function get_image_filename_list(){
	global $db_handle, $table_cpu_db_images;

	$images = array();

	$query = "SELECT filename FROM $table_cpu_db_images";
	
	$images = mysql_grab_array_1d($query);

	return $images;
}


function does_image_exist($filename){

	if( !( empty($filename) ) ){
		return in_array($filename, get_image_filename_list());
	}else{
		// ignore
		return true;
	}
}


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








//////////////////////////////////////////////
//  Get indivitual details
//


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











/////////////////////////////////////////////
// Image info
//



function get_image_details($image_filename){
	global $table_cpu_db_images, $upload_folder, $resize_folder, $db_handle;

	$query = "SELECT * FROM $table_cpu_db_images WHERE filename='$image_filename'";
	
	$return_array = array();
	$return_array = mysql_grab_assoc_1d($query);

	switch ($return_array['license']) {
		case "self|CC BY-3.0":
			$license_url = 'http://creativecommons.org/licenses/by/3.0';
			break;
		case "self|CC BY-SA-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-sa/3.0';
			break;
		case "self|CC BY-ND-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nd/3.0';
			break;
		case "self|CC BY-NC-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc/3.0';
			break;
		case "self|CC BY-NC-SA-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-sa/3.0';
			break;
		case "self|CC BY-NC-ND-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-nd/3.0';
			break;
		case "self|PD":
			$license_url = 'http://creativecommons.org/publicdomain/mark/1.0/';
			break;
		case "self|copyright":
			$license_url = '';
			break;
		case "CC BY-3.0":
			$license_url = 'http://creativecommons.org/licenses/by/3.0';
			break;
		case "CC BY-SA-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-sa/3.0';
			break;
		case "CC BY-ND-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nd/3.0';
			break;
		case "CC BY-NC-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc/3.0';
			break;
		case "CC BY-NC-SA-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-sa/3.0';
			break;
		case "CC BY-NC-ND-3.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-nd/3.0';
			break;
		case "PD":
			$license_url = 'http://creativecommons.org/publicdomain/mark/1.0/';
			break;
		case "CC BY-2.5":
			$license_url = 'http://creativecommons.org/licenses/by/2.5';
			break;
		case "CC BY-SA-2.5":
			$license_url = 'http://creativecommons.org/licenses/by-sa/2.5';
			break;
		case "CC BY-ND-2.5":
			$license_url = 'http://creativecommons.org/licenses/by-nd/2.5';
			break;
		case "CC BY-NC-2.5":
			$license_url = 'http://creativecommons.org/licenses/by-nc/2.5';
			break;
		case "CC BY-NC-SA-2.5":
			$license_url = 'http://creativecommons.org/licenses/by-nc-sa/2.5';
			break;
		case "CC BY-NC-ND-2.5":
			$license_url = 'http://creativecommons.org/licenses/by-nc-nd/2.5';
			break;
		case "CC BY-2.0":
			$license_url = 'http://creativecommons.org/licenses/by/2.0';
			break;
		case "CC BY-SA-2.0":
			$license_url = 'http://creativecommons.org/licenses/by-sa/2.0';
			break;
		case "CC BY-ND-2.0":
			$license_url = 'http://creativecommons.org/licenses/by-nd/2.0';
			break;
		case "CC BY-NC-2.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc/2.0';
			break;
		case "CC BY-NC-SA-2.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-sa/2.0';
			break;
		case "CC BY-NC-ND-2.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-nd/2.0';
			break;
		case "CC BY-1.0":
			$license_url = 'http://creativecommons.org/licenses/by/1.0';
			break;
		case "CC BY-SA-1.0":
			$license_url = 'http://creativecommons.org/licenses/by-sa/1.0';
			break;
		case "CC BY-ND-1.0":
			$license_url = 'http://creativecommons.org/licenses/by-nd/1.0';
			break;
		case "CC BY-NC-1.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc/1.0';
			break;
		case "CC BY-NC-SA-1.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-sa/1.0';
			break;
		case "CC BY-NC-ND-1.0":
			$license_url = 'http://creativecommons.org/licenses/by-nc-nd/1.0';
			break;
		case "BSD":
			$license_url = 'http://opensource.org/licenses/BSD-2-Clause';
			break;
		case "MIT":
			$license_url = 'http://opensource.org/licenses/MIT';
			break;
		case "Mozilla":
			$license_url = 'http://opensource.org/licenses/MPL-2.0';
			break;
		case "GPL":
			$license_url = 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html';
			break;
		case "GFDL":
			$license_url = 'http://www.gnu.org/licenses/fdl.html';
			break;
		case "cc-zero":
			$license_url = 'http://creativecommons.org/publicdomain/zero/1.0/';
			break;
		case "copyright":
			$license_url = '';
			break;

	}

	$image_details = array(
		"filename" => $return_array['filename'],
		"filename_url" => $upload_folder . $return_array['filename'],
		"thumb_filename" => $return_array['thumb_filename'],
		"thumb_filename_url" => $resize_folder . $return_array['thumb_filename'],
		"manuf" => $return_array['manuf'],
		"part" => $return_array['part'],
		"side" => $return_array['side'],
		"description" => $return_array['description'],
		"license" => $return_array['license'],
		"license_url" => $license_url,
		"author" => $return_array['author'],
		"source" => $return_array['source'],
		// "source_url" => $return_array['source'],
		"date_created" => $return_array['date_created'],
		"comments" => $return_array['comments'],
		"file_type" => $return_array['file_type'],
		"file_size" => $return_array['file_size'],
		"file_size_KiB" => round($return_array['file_size']/1024),
		"image_size" => $return_array['image_size'],
		"username" => $return_array['username'],
		"date_uploaded" => $return_array['date_uploaded'],
	);


	return $image_details;
}







?>
