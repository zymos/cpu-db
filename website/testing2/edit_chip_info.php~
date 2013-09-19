<?php 

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: Adding or editing the CPU_db
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////


include 'globals.php';
include 'db_connect.php';

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



/////////////////////////////////////////////////////////////
// Grabbing the variabls
//


	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$chip_type = $_POST["chip_type"];
	$family = $_POST["family"];
	$sub_family = $_POST["sub_family"];
	$model_number = $_POST["model_number"];
	$alt_lable1 = $_POST["alt_lable1"];
	$alt_lable2 = $_POST["alt_lable2"];
	$alt_lable3 = $_POST["alt_lable3"];
	$alt_lable4 = $_POST["alt_lable4"];
	$alt_lable5 = $_POST["alt_lable5"];
	$core = $_POST["core"];
	$core_designer = $_POST["core_designer"];
	$core_count = $_POST["core_count"];
	$threads = $_POST["threads"];
	$cpuid = $_POST["cpuid"];
	$core_stepping = $_POST["core_stepping"];
	$pipeline = $_POST["pipeline"];
	$multiprocessing = $_POST["multiprocessing"];
	$architecture = $_POST["architecture"];
	$data_bus_ext = $_POST["data_bus_ext"];
	$address_bus = $_POST["address_bus"];
	$bus_comments = $_POST["bus_comments"];
	$frequency_min = $_POST["frequency_min"];
	$frequency_max_typ = $_POST["frequency_max_typ"];
	$frequency_ext = $_POST["frequency_ext"];
	$clock_multiplier = $_POST["clock_multiplier"];
	$actual_bus_frequency = $_POST["actual_bus_frequency"];
	$effective_bus_frequency = $_POST["effective_bus_frequency"];
	$bus_bandwidth = $_POST["bus_bandwidth"];
	$ram_max = $_POST["ram_max"];
	$ram_type = $_POST["ram_type"];
	$ram_internal = $_POST["ram_internal"];
	$virtual_memory_max = $_POST["virtual_memory_max"];
	$rom_internal = $_POST["rom_internal"];
	$rom_type = $_POST["rom_type"];
	$l1_data_cache = $_POST["l1_data_cache"];
	$l1_data_associativity = $_POST["l1_data_associativity"];
	$l1_instruction_cache = $_POST["l1_instruction_cache"];
	$l1_instruction_associativity = $_POST["l1_instruction_associativity"];
	$l1_unified_cache = $_POST["l1_unified_cache"];
	$l1_unified_associativity = $_POST["l1_unified_associativity"];
	$l2_cache = $_POST["l2_cache"];
	$l2_associativity = $_POST["l2_associativity"];
	$l3_cache = $_POST["l3_cache"];
	$l3_associativity = $_POST["l3_associativity"];
	$package = $_POST["package"];
	$socket = $_POST["socket"];
	$package_size = $_POST["package_size"];
	$package_weight = $_POST["package_weight"];
	$vcc_core_typ = $_POST["vcc_core_typ"];
	$vcc_core_range = $_POST["vcc_core_range"];
	$vcc_i_o = $_POST["vcc_i_o"];
	$i_o_compatibillity = $_POST["i_o_compatibillity"];
	$vcc_secondary = $_POST["vcc_secondary"];
	$vcc_tertiary = $_POST["vcc_tertiary"];
	$power_min = $_POST["power_min"];
	$power_typ = $_POST["power_typ"];
	$power_max = $_POST["power_max"];
	$power_thermal_design = $_POST["power_thermal_design"];
	$temperature_range = $_POST["temperature_range"];
	$temperature_grade = $_POST["temperature_grade"];
	$low_power_features = $_POST["low_power_features"];
	$isa = $_POST["isa"];
	$instruction_set = $_POST["instruction_set"];
	$instruction_set_extensions = $_POST["instruction_set_extensions"];
	$additional_instructions = $_POST["additional_instructions"];
	$process_technology = $_POST["process_technology"];
	$metal_layers = $_POST["metal_layers"];
	$metal_type = $_POST["metal_type"];
	$transistor_count = $_POST["transistor_count"];
	$die_size = $_POST["die_size"];
	$fpu = $_POST["fpu"];
	$on_chip_peripherals = $_POST["on_chip_peripherals"];
	$release_date = $_POST["release_date"];
	$initial_price = $_POST["initial_price"];
	$production_type = $_POST["production_type"];
	$clone = $_POST["clone"];
	$applications = $_POST["applications"];
	$military_spec = $_POST["military_spec"];
	$features = $_POST["features"];
	$comments = $_POST["comments"];
	$reference_1 = $_POST["reference_1"];
	$reference_2 = $_POST["reference_2"];
	$reference_3 = $_POST["reference_3"];
	$reference_4 = $_POST["reference_4"];
	$reference_5 = $_POST["reference_5"];
	$reference_6 = $_POST["reference_6"];
	$reference_7 = $_POST["reference_7"];
	$reference_8 = $_POST["reference_8"];
	$submission_comments = $_POST["submission_comments"];

	$photo_front_filename_1 = $_POST["photo_front_filename_1"];
	$photo_front_creator_1 = $_POST["photo_front_creator_1"];
	$photo_front_source_1 = $_POST["photo_front_source_1"];
	$photo_front_copyright_1 = $_POST["photo_front_copyright_1"];
	$photo_front_comment_1 = $_POST["photo_front_comment_1"];
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_back_creator_1 = $_POST["photo_back_creator_1"];
	$photo_back_source_1 = $_POST["photo_back_source_1"];
	$photo_back_copyright_1 = $_POST["photo_back_copyright_1"];
	$photo_back_comment_1 = $_POST["photo_back_comment_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_front_creator_2 = $_POST["photo_front_creator_2"];
	$photo_front_source_2 = $_POST["photo_front_source_2"];
	$photo_front_copyright_2 = $_POST["photo_front_copyright_2"];
	$photo_front_comment_2 = $_POST["photo_front_comment_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_back_creator_2 = $_POST["photo_back_creator_2"];
	$photo_back_source_2 = $_POST["photo_back_source_2"];
	$photo_back_copyright_2 = $_POST["photo_back_copyright_2"];
	$photo_back_comment_2 = $_POST["photo_back_comment_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_front_creator_3 = $_POST["photo_front_creator_3"];
	$photo_front_source_3 = $_POST["photo_front_source_3"];
	$photo_front_copyright_3 = $_POST["photo_front_copyright_3"];
	$photo_front_comment_3 = $_POST["photo_front_comment_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_back_creator_3 = $_POST["photo_back_creator_3"];
	$photo_back_source_3 = $_POST["photo_back_source_3"];
	$photo_back_copyright_3 = $_POST["photo_back_copyright_3"];
	$photo_back_comment_3 = $_POST["photo_back_comment_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_front_creator_4 = $_POST["photo_front_creator_4"];
	$photo_front_source_4 = $_POST["photo_front_source_4"];
	$photo_front_copyright_4 = $_POST["photo_front_copyright_4"];
	$photo_front_comment_4 = $_POST["photo_front_comment_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$photo_back_creator_4 = $_POST["photo_back_creator_4"];
	$photo_back_source_4 = $_POST["photo_back_source_4"];
	$photo_back_copyright_4 = $_POST["photo_back_copyright_4"];
	$photo_back_comment_4 = $_POST["photo_back_comment_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];
	$die_photo_creator_1 = $_POST["die_photo_creator_1"];
	$die_photo_source_1 = $_POST["die_photo_source_1"];
	$die_photo_copyright_1 = $_POST["die_photo_copyright_1"];
	$die_photo_comment_1 = $_POST["die_photo_comment_1"];



	$add_or_edit = $_POST["add_or_edit"];



//////////////////////////////////////////////////////////
//  Create query statement
//

$params = "manuf, part, chip_type, family, sub_family, model_number, alt_lable1, alt_lable2, alt_lable3, alt_lable4, alt_lable5, core, core_designer, core_count, threads, cpuid, core_stepping, pipeline, multiprocessing, architecture, data_bus_ext, address_bus, bus_comments, frequency_min, frequency_max_typ, frequency_ext, clock_multiplier, actual_bus_frequency, effective_bus_frequency, bus_bandwidth, ram_max, ram_type, ram_internal, virtual_memory_max, rom_internal, rom_type, l1_data_cache, l1_data_associativity, l1_instruction_cache, l1_instruction_associativity, l1_unified_cache, l1_unified_associativity, l2_cache, l2_associativity, l3_cache, l3_associativity, package, socket, package_size, package_weight, vcc_core_typ, vcc_core_range, vcc_i_o, i_o_compatibillity, vcc_secondary, vcc_tertiary, power_min, power_typ, power_max, power_thermal_design, temperature_range, temperature_grade, low_power_features, isa, instruction_set, instruction_set_extensions, additional_instructions, process_technology, metal_layers, metal_type, transistor_count, die_size, fpu, on_chip_peripherals, release_date, initial_price, production_type, clone, applications, military_spec, features, comments, reference_1, reference_2, reference_3, reference_4, reference_5, reference_6, reference_7, reference_8";


		$params .= ", photo_front_filename_1, photo_front_creator_1, photo_front_source_1, photo_front_copyright_1, photo_front_comment_1, photo_back_filename_1, photo_back_creator_1, photo_back_source_1, photo_back_copyright_1, photo_back_comment_1, photo_front_filename_2, photo_front_creator_2, photo_front_source_2, photo_front_copyright_2, photo_front_comment_2, photo_back_filename_2, photo_back_creator_2, photo_back_source_2, photo_back_copyright_2, photo_back_comment_2, photo_front_filename_3, photo_front_creator_3, photo_front_source_3, photo_front_copyright_3, photo_front_comment_3, photo_back_filename_3, photo_back_creator_3, photo_back_source_3, photo_back_copyright_3, photo_back_comment_3, photo_front_filename_4, photo_front_creator_4, photo_front_source_4, photo_front_copyright_4, photo_front_comment_4, photo_back_filename_4, photo_back_creator_4, photo_back_source_4, photo_back_copyright_4, photo_back_comment_4, die_photo_filename_1, die_photo_creator_1, die_photo_source_1, die_photo_copyright_1, die_photo_comment_1";




	$values = "'" . $manuf . "', '" . $part . "', '" . $chip_type . "', '" . 
		$family . "', '" . $sub_family . "', '" . $model_number . "', '" . 
		$alt_lable1 . "', '" . $alt_lable2 . "', '" . $alt_lable3 . "', '" . 
		$alt_lable4 . "', '" . $alt_lable5 . "', '" . $core . "', '" . 
		$core_designer . "', '" . $core_count . "', '" . $threads . "', '" . 
		$cpuid . "', '" . $core_stepping . "', '" . $pipeline . "', '" . 
		$multiprocessing . "', '" . $architecture . "', '" . $data_bus_ext . "', '" . 
		$address_bus . "', '" . $bus_comments . "', '" . $frequency_min . "', '" . 
		$frequency_max_typ . "', '" . $frequency_ext . "', '" . 
		$clock_multiplier . "', '" . $actual_bus_frequency . "', '" . 
		$effective_bus_frequency . "', '" . $bus_bandwidth . "', '" . 
		$ram_max . "', '" . $ram_type . "', '" . $ram_internal . "', '" . 
		$virtual_memory_max . "', '" . $rom_internal . "', '" . $rom_type . "', '" . 
		$l1_data_cache . "', '" . $l1_data_associativity . "', '" . 
		$l1_instruction_cache . "', '" . $l1_instruction_associativity . "', '" . 
		$l1_unified_cache . "', '" . $l1_unified_associativity . "', '" . 
		$l2_cache . "', '" . $l2_associativity . "', '" . $l3_cache . "', '" . 
		$l3_associativity . "', '" . $package . "', '" . $socket . "', '" . 
		$package_size . "', '" . $package_weight . "', '" . $vcc_core_typ . "', '" . 
		$vcc_core_range . "', '" . $vcc_i_o . "', '" . $i_o_compatibillity . "', '" . 
		$vcc_secondary . "', '" . $vcc_tertiary . "', '" . $power_min . "', '" . 
		$power_typ . "', '" . $power_max . "', '" . $power_thermal_design . "', '" . 
		$temperature_range . "', '" . $temperature_grade . "', '" . 
		$low_power_features . "', '" . $isa . "', '" . $instruction_set . "', '" . 
		$instruction_set_extensions . "', '" . $additional_instructions . "', '" . 
		$process_technology . "', '" . $metal_layers . "', '" . $metal_type . "', '" . 
		$transistor_count . "', '" . $die_size . "', '" . $fpu . "', '" . 
		$on_chip_peripherals . "', '" . $release_date . "', '" . 
		$initial_price . "', '" . $production_type . "', '" . $clone . "', '" . 
		$applications . "', '" . $military_spec . "', '" . $features . "', '" . 
		$comments . "', '";

	$values .= $reference_1 . "', '" . $reference_2 . "', '" . $reference_3 . 
		"', '" . $reference_4 . "', '" . $reference_5 . "', '" . $reference_6 . 
		"', '" . $reference_7 . "', '" . $reference_8 . 
		"', '" . $photo_front_filename_1 . "', '" . $photo_front_creator_1 . 
		"', '" . $photo_front_source_1 . "', '" . $photo_front_copyright_1 . 
		"', '" . $photo_front_comment_1 . "', '" . $photo_back_filename_1 . 
		"', '" . $photo_back_creator_1 . "', '" . $photo_back_source_1 . 
		"', '" . $photo_back_copyright_1 . "', '" . $photo_back_comment_1 . 
		"', '" . $photo_front_filename_2 . "', '" . $photo_front_creator_2 . 
		"', '" . $photo_front_source_2 . "', '" . $photo_front_copyright_2 . 
		"', '" . $photo_front_comment_2 . "', '" . $photo_back_filename_2 . 
		"', '" . $photo_back_creator_2 . "', '" . $photo_back_source_2 . 
		"', '" . $photo_back_copyright_2 . "', '" . $photo_back_comment_2 . 
		"', '" . $photo_front_filename_3 . "','" . $photo_front_creator_3 . 
		"', '" . $photo_front_source_3 . "', '" . $photo_front_copyright_3 . 
		"', '" . $photo_front_comment_3 . "', '" . $photo_back_filename_3 . 
		"', '" . $photo_back_creator_3 . "', '" . $photo_back_source_3 . 
		"', '" . $photo_back_copyright_3 . "', '" . $photo_back_comment_3 . 
		"', '" . $photo_front_filename_4 . "', '" . $photo_front_creator_4 . 
		"', '" . $photo_front_source_4 . "', '" . $photo_front_copyright_4 . 
		"', '" . $photo_front_comment_4 . "', '" . $photo_back_filename_4 . 
		"', '" . $photo_back_creator_4 . "', '" . $photo_back_source_4 . 
		"', '" . $photo_back_copyright_4 . "', '" . $photo_back_comment_4 . 
		"', '" . $die_photo_filename_1 . "', '" . $die_photo_creator_1 . 
		"', '" . $die_photo_source_1 . "', '" . $die_photo_copyright_1 . 
		"', '" . $die_photo_comment_1 . "'";





	// $col = 'part';
	// $chip_count_array = array();
	// $query = "SELECT $col FROM $table_cpu_db";
	// $chip_count_array = mysql_grab_array_1d($statement);
	// $result = parse_db_query( $query );
    // $chip_count = count($chip_count_array);
	// $results = array();

	// $results = mysql_query( $query, $db_handle);
// 	if (!$results) {
    	// echo "Could not execute query: $query\n";
	//     trigger_error(mysql_error(), E_USER_ERROR);
	/// }

	// print_r($results);
	// echo "$chip_count";
	// $results = array();


	if( $add_or_edit === "edit" ){
		echo "Edit mode<br />\n<br />\n";
		$query = "SELECT $col FROM $table_cpu_db";
		// $chip_count_array = mysql_grab_array_1d($statement);
		// $result = parse_db_query( $query );
		// $chip_count = count($chip_count_array);
		$results = array();

		$results = mysql_query( $query, $db_handle);
		if (!$results) {
   	 		echo "Could not execute query: $query\n";
		   	trigger_error(mysql_error(), E_USER_ERROR);
		}
		
		$num_rows = mysql_num_rows($result);
		//	print_r($num_rows);

		if ($num_rows > 0) {
  			echo "Chip exists<br />\n<br />\n";
		} else {
		  	echo "Chip does not exists<br />\n<br />\n";
		}
		
	}elseif( $add_or_edit === "add" ){
		echo "add mode<br />\n<br />\n";
		$query = "SELECT manufacturer FROM $table_cpu_db WHERE manufacturer='$manuf' AND part='$part'";
		$result = mysql_query($query, $db_handle);
		if (!$results) {
    			echo "Could not execute query: $query\n";
	    		trigger_error(mysql_error(), E_USER_ERROR);
		}
		
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) {
  			echo "Chip exists<br />\n<br />\n";
		} else {
		  	echo "Chip does not exists<br />\n<br />\n";
		}
	} else {
		echo "error";
	}

	// mysqli_query($con,"UPDATE Persons SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
	$statement = "INSERT INTO $table ($params) VALUES ($values)";

	echo $statement;

	mysql_close($db_handle);
?>
