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
////	File discription: Adding or editing the cpu_db
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////


include 'globals.php';
include 'db_connect2.php';
include 'log_functions.php'; //append log
include 'display_cpu_db_page_functions.php'; // display page functions
require_once('lib/recaptcha-php/recaptchalib.php');
include 'get_info_functions.php'; // grabs lists and chip info
include 'db_query_functions.php'; //c






/////////////////////////////////////////////////////////////
// Grabbing the variabls
//

/*
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$chip_type = $_POST["chip_type"];
	$family = $_POST["family"];
	$sub_family = $_POST["sub_family"];
	$model_number = $_POST["model_number"];
	$alternative_label_1 = $_POST["alternative_label_1"];
	$alternative_label_2 = $_POST["alternative_label_2"];
	$alternative_label_3 = $_POST["alternative_label_3"];
	$alternative_label_4 = $_POST["alternative_label_4"];
	$alternative_label_5 = $_POST["alternative_label_5"];
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
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];

	$add_or_edit = $_POST["add_or_edit"];



 */



//////////////////////////////////////////////
// Print out the variables
//

function print_input_vars(){
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$chip_type = $_POST["chip_type"];
	$family = $_POST["family"];
	$sub_family = $_POST["sub_family"];
	$model_number = $_POST["model_number"];
	$alternative_label_1 = $_POST["alternative_label_1"];
	$alternative_label_2 = $_POST["alternative_label_2"];
	$alternative_label_3 = $_POST["alternative_label_3"];
	$alternative_label_4 = $_POST["alternative_label_4"];
	$alternative_label_5 = $_POST["alternative_label_5"];
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
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];
	$add_or_edit = $_POST["add_or_edit"];

	$html_code .= <<<Endhtml
<br />
<div style="border-style: solid; border-width: 3px;">
manuf = $manuf<br />
part = $part<br />
chip_type = $chip_type<br />
family = $family<br />
sub_family = $sub_family<br />
model_number = $model_number<br />
	alternative_label_1 = $alternative_label_1<br />
	alternative_label_2 = $alternative_label_2<br />
	alternative_label_3 = $alternative_label_3<br />
	alternative_label_4 = $alternative_label_4<br />
	alternative_label_5 = $alternative_label_5<br />
core = $core<br />
core_designer = $core_designer<br />
core_count = $core_count<br />
threads = $threads<br />
cpuid = $cpuid<br />
core_stepping = $core_stepping<br />
pipeline = $pipeline<br />
multiprocessing = $multiprocessing<br />
architecture = $architecture<br />
data_bus_ext = $data_bus_ext<br />
address_bus = $address_bus<br />
bus_comments = $bus_comments<br />
frequency_min = $frequency_min<br />
frequency_max_typ = $frequency_max_typ<br />
frequency_ext = $frequency_ext<br />
clock_multiplier = $clock_multiplier<br />
actual_bus_frequency = $actual_bus_frequency<br />
effective_bus_frequency = $effective_bus_frequency<br />
bus_bandwidth = $bus_bandwidth<br />
ram_max = $ram_max<br />
ram_type = $ram_type<br />
ram_internal = $ram_internal<br />
virtual_memory_max = $virtual_memory_max<br />
rom_internal = $rom_internal<br />
rom_type = $rom_type<br />
l1_data_cache = $l1_data_cache<br />
l1_data_associativity = $l1_data_associativity<br />
l1_instruction_cache = $l1_instruction_cache<br />
l1_instruction_associativity = $l1_instruction_associativity<br />
l1_unified_cache = $l1_unified_cache<br />
l1_unified_associativity = $l1_unified_associativity<br />
l2_cache = $l2_cache<br />
l2_associativity = $l2_associativity<br />
l3_cache = $l3_cache<br />
l3_associativity = $l3_associativity<br />
package = $package<br />
socket = $socket<br />
package_size = $package_size<br />
package_weight = $package_weight<br />
vcc_core_typ = $vcc_core_typ<br />
vcc_core_range = $vcc_core_range<br />
vcc_i_o = $vcc_i_o<br />
i_o_compatibillity = $i_o_compatibillity<br />
vcc_secondary = $vcc_secondary<br />
vcc_tertiary = $vcc_tertiary<br />
power_min = $power_min<br />
power_typ = $power_typ<br />
power_max = $power_max<br />
power_thermal_design = $power_thermal_design<br />
temperature_range = $temperature_range<br />
temperature_grade = $temperature_grade<br />
low_power_features = $low_power_features<br />
isa = $isa<br />
instruction_set = $instruction_set<br />
instruction_set_extensions = $instruction_set_extensions<br />
additional_instructions = $additional_instructions<br />
process_technology = $process_technology<br />
metal_layers = $metal_layers<br />
metal_type = $metal_type<br />
transistor_count = $transistor_count<br />
die_size = $die_size<br />
fpu = $fpu<br />
on_chip_peripherals = $on_chip_peripherals<br />
release_date = $release_date<br />
initial_price = $initial_price<br />
production_type = $production_type<br />
clone = $clone<br />
applications = $applications<br />
military_spec = $military_spec<br />
features = $features<br />
comments = $comments<br />
reference_1 = $reference_1<br />
reference_2 = $reference_2<br />
reference_3 = $reference_3<br />
reference_4 = $reference_4<br />
reference_5 = $reference_5<br />
reference_6 = $reference_6<br />
reference_7 = $reference_7<br />
reference_8 = $reference_8<br />
submission_comments = $submission_comments<br />
photo_front_filename_1 = $photo_front_filename_1<br />
photo_back_filename_1 = $photo_back_filename_1<br />
photo_front_filename_2 = $photo_front_filename_2<br />
photo_back_filename_2 = $photo_back_filename_2<br />
photo_front_filename_3 = $photo_front_filename_3<br />
photo_back_filename_3 = $photo_back_filename_3<br />
photo_front_filename_4 = $photo_front_filename_4<br />
photo_back_filename_4 = $photo_back_filename_4<br />
die_photo_filename_1 = $die_photo_filename_1<br />
add_or_edit = $add_or_edit<br />
</div>

Endhtml;
	return $html_code;
}







//////////////////////////////////////
// Mi
//

function min_form_reqirements(){
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$reference_1 = $_POST["reference_1"];

	if( isset($manuf) && isset($part) && isset($reference_1) && ( strlen($manuf) >= 2 ) && ( strlen($part) >= 2 ) && ( strlen($reference_1) >= 3 )){
		return true;
	}else{
		return false;
	}
}










////////////////////////////////////
// Does the chip already exist
//

function check_if_chip_exists(){
	global $table_cpu_db, $db_handle;
	
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];


	$query = "SELECT manufacturer FROM $table_cpu_db WHERE manufacturer='$manuf' AND part='$part'";
		// $chip_count_array = mysql_grab_array_1d($statement);
		// $result = parse_db_query( $query );
		// $chip_count = count($chip_count_array);
	$results = array();

	$results = mysql_query( $query, $db_handle);
	if (!$results) {
 		echo "Could not execute query: $query\n";
	   	trigger_error(mysql_error(), E_USER_ERROR);
	}
		
	$num_rows = mysql_num_rows($results);
		//	print_r($num_rows);

	if ($num_rows > 0) {
		return true;
	} else {
	  	return false;
	}
}








//////////////////////////////////////////////////////////
//  Create query statement
//

function add_chip_to_db(){
	global $table_cpu_db, $db_handle;

	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$chip_type = $_POST["chip_type"];
	$family = $_POST["family"];
	$sub_family = $_POST["sub_family"];
	$model_number = $_POST["model_number"];
	$alternative_label_1 = $_POST["alternative_label_1"];
	$alternative_label_2 = $_POST["alternative_label_2"];
	$alternative_label_3 = $_POST["alternative_label_3"];
	$alternative_label_4 = $_POST["alternative_label_4"];
	$alternative_label_5 = $_POST["alternative_label_5"];
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
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];

	$add_or_edit = $_POST["add_or_edit"];


	$params = "manufacturer, part, chip_type, family, sub_family, model_number, alternative_label_1, alternative_label_2, alternative_label_3, alternative_label_4, alternative_label_5, core, core_designer, core_count, threads, cpuid, core_stepping, pipeline, multiprocessing, architecture, data_bus_ext, address_bus, bus_comments, frequency_min, frequency_max_typ, frequency_ext, clock_multiplier, actual_bus_frequency, effective_bus_frequency, bus_bandwidth, ram_max, ram_type, ram_internal, virtual_memory_max, rom_internal, rom_type, l1_data_cache, l1_data_associativity, l1_instruction_cache, l1_instruction_associativity, l1_unified_cache, l1_unified_associativity, l2_cache, l2_associativity, l3_cache, l3_associativity, package, socket, package_size, package_weight, vcc_core_typ, vcc_core_range, vcc_i_o, i_o_compatibillity, vcc_secondary, vcc_tertiary, power_min, power_typ, power_max, power_thermal_design, temperature_range, temperature_grade, low_power_features, isa, instruction_set, instruction_set_extensions, additional_instructions, process_technology, metal_layers, metal_type, transistor_count, die_size, fpu, on_chip_peripherals, release_date, initial_price, production_type, clone, applications, military_spec, features, comments, reference_1, reference_2, reference_3, reference_4, reference_5, reference_6, reference_7, reference_8";


	$params .= ", photo_front_filename_1, photo_front_creator_1, photo_front_source_1, photo_front_copyright_1, photo_front_comment_1, photo_back_filename_1, photo_back_creator_1, photo_back_source_1, photo_back_copyright_1, photo_back_comment_1, photo_front_filename_2, photo_front_creator_2, photo_front_source_2, photo_front_copyright_2, photo_front_comment_2, photo_back_filename_2, photo_back_creator_2, photo_back_source_2, photo_back_copyright_2, photo_back_comment_2, photo_front_filename_3, photo_front_creator_3, photo_front_source_3, photo_front_copyright_3, photo_front_comment_3, photo_back_filename_3, photo_back_creator_3, photo_back_source_3, photo_back_copyright_3, photo_back_comment_3, photo_front_filename_4, photo_front_creator_4, photo_front_source_4, photo_front_copyright_4, photo_front_comment_4, photo_back_filename_4, photo_back_creator_4, photo_back_source_4, photo_back_copyright_4, photo_back_comment_4, die_photo_filename_1, die_photo_creator_1, die_photo_source_1, die_photo_copyright_1, die_photo_comment_1";




	$values = "'" . $manuf . "', '" . $part . "', '" . $chip_type . "', '" . 
		$family . "', '" . $sub_family . "', '" . $model_number . "', '" . 
		$alternative_label_1 . "', '" . $alternative_label_2 . "', '" . $alternative_label_3 . "', '" . 
		$alternative_label_4 . "', '" . $alternative_label_5 . "', '" . $core . "', '" . 
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


	$query = "INSERT INTO $table_cpu_db ($params) VALUES($values)";

	$results = mysql_query($query, $db_handle);
	if (!$results) {
 		echo "Could not execute query: $query\n";
	   	trigger_error(mysql_error(), E_USER_ERROR);
	}

}









function display_add_edit_chip_page($manuf, $part, $edit_type) { // page=add_chip or edit_chip

	$url_manuf = urlencode($manuf);
	$url_part = urlencode($part);

	global $html_title_g, $html_keywords_g, $script_name_g;
	global $mysqli;
	
	$html_code = '';


	if( $edit_type === 'reedit' ||  $edit_type === 'readd' ){  //// Re-Edit mode
		$manuf = $_POST["manufacturer"];
		$part = $_POST["part"];

		$manuf_text = "";
		$manuf_text .= "			<tr>";
		$manuf_text .= "				<td class=\"table_param\">Manufacturer:<span style=\"color: red; \">*</span></td>";
		$manuf_text .= "				<td class=\"table_value\"><b>$manuf</b></td>";
		$manuf_text .= "			</tr>\n";		
		$family = $_POST["family"];
		$alternative_label_1 = $_POST["alternative_label_1"];
		$alternative_label_2 = $_POST["alternative_label_2"];
		$alternative_label_3 = $_POST["alternative_label_3"];
		$alternative_label_4 = $_POST["alternative_label_4"];
		$alternative_label_5 = $_POST["alternative_label_5"];
		$alternative_label_6 = $_POST["alternative_label_6"];
		$chip_type = $_POST["chip_type"];
		$sub_family = $_POST["sub_family"];
		$model_number = $_POST["model_number"];
		$core = $_POST["core"];
		$core_designer = $_POST["core_designer"];
		$microarchitecture = $_POST["microarchitecture"];
		$threads = $_POST["threads"];
		$cpuid = $_POST["cpuid"];
		$core_count = $_POST["core_count"];
		$pipeline = $_POST["pipeline"];
		$multiprocessing = $_POST["multiprocessing"];	
		$architecture = $_POST["architecture"];
		$data_bus_ext = $_POST["data_bus_ext"];
		$address_bus = $_POST["address_bus"];
		$bus_comments = $_POST["bus_comments"]; 
		$frequency_ext = $_POST["frequency_ext"]; 
		$frequency_min = $_POST["frequency_min"];
		$frequency_max_typ = $_POST["frequency_max_typ"];
		// echo "$frequency_max_typ = $_POST['frequency_max_typ']";
		$actual_bus_frequency = $_POST["actual_bus_frequency"];
		$effective_bus_frequency = $_POST["effective_bus_frequency"];
		$bus_bandwidth = $_POST["bus_bandwidth"];
		$clock_multiplier = $_POST["clock_multiplier"];
		$core_stepping = $_POST["core_stepping"];
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
		// $boot_rom = $_POST["boot_rom"];
		$rom_internal = $_POST["rom_internal"];
		$rom_type = $_POST["rom_type"];
		$ram_internal = $_POST["ram_internal"];
		$ram_max = $_POST["ram_max"];
		$ram_type = $_POST["ram_type"];
		$virtual_memory_max = $_POST["virtual_memory_max"];
		$package = $_POST["package"];
		$package_size = $_POST["package_size"];
		$package_weight = $_POST["package_weight"];
		$socket = $_POST["socket"];
		$transistor_count = $_POST["transistor_count"];
		$process_size = $_POST["process_size"];
		$metal_layers = $_POST["metal_layers"];
		$metal_type = $_POST["metal_type"];
		$process_technology = $_POST["process_technology"];
		$die_size = $_POST["die_size"];
		$vcc_core_range = $_POST["vcc_core_range"];
		$vcc_core_typ = $_POST["vcc_core_typ"];
		$vcc_secondary = $_POST["vcc_secondary"];
		$vcc_tertiary = $_POST["vcc_tertiary"];
		$vcc_i_o = $_POST["vcc_i_o"];
		$i_o_compatibillity = $_POST["i_o_compatibillity"]; 
		$power_min = $_POST["power_min"];
		$power_typ = $_POST["power_typ"];
		$power_max = $_POST["power_max"];
		$power_thermal_design = $_POST["power_thermal_design"];
		$temperature_range = $_POST["temperature_range"];
		$temperature_grade = $_POST["temperature_grade"]; 
		$low_power_features = $_POST["low_power_features"];
		$instruction_set = $_POST["instruction_set"];
		$instruction_set_extensions = $_POST["instruction_set_extensions"];
		$additional_instructions = $_POST["additional_instructions"];
		$computer_architecture = $_POST["computer_architecture"];
		$isa = $_POST["isa"];
		$fpu = $_POST["fpu"];
		$on_chip_peripherals = $_POST["on_chip_peripherals"];
		$features = $_POST["features"];
		$production_type = $_POST["production_type"]; 
		$clone = $_POST["clone"]; 
		$release_date = $_POST["release_date"];
		$initial_price = $_POST["initial_price"];
		$applications = $_POST["applications"];
		$military_spec = $_POST["military_spec"];
		$comments = $_POST["comments"];
		$reference_1 = $_POST["reference_1"];
		$reference_2 = $_POST["reference_2"];
		$reference_3 = $_POST["reference_3"];
		$reference_4 = $_POST["reference_4"];
		$reference_5 = $_POST["reference_5"];
		$reference_6 = $_POST["reference_6"];
		$reference_7 = $_POST["reference_7"];
		$reference_8 = $_POST["reference_8"];
	
		$photo_front_filename_1 = $_POST["photo_front_filename_1"]; 
		$photo_front_creator_1 = $_POST["photo_front_creator_1"]; 
		$photo_front_source_1= 	 $_POST["photo_front_source_1"]; 
		$photo_front_copyright_1= $_POST["photo_front_copyright_1"]; 
		$photo_front_comment_1 =  $_POST["photo_front_comment_1"]; 
	
		$photo_back_filename_1 =  $_POST["photo_back_filename_1"]; 
		$photo_back_creator_1 =  $_POST["photo_back_creator_1"]; 
		$photo_back_source_1= 	 $_POST["photo_back_source_1"]; 
		$photo_back_copyright_1 = $_POST["photo_back_copyright_1"]; 
		$photo_back_comment_1 = 	 $_POST["photo_back_comment_1"]; 
	
		$photo_front_filename_2 =$_POST["photo_front_filename_2"]; 
		$photo_front_creator_2 =$_POST["photo_front_creator_2"]; 
		$photo_front_source_2=	$_POST["photo_front_source_2"]; 
		$photo_front_copyright_2=$_POST["photo_front_copyright_2"]; 
		$photo_front_comment_2 = $_POST["photo_front_comment_2"]; 
	
		$photo_back_filename_2 = $_POST["photo_back_filename_2"]; 
		$photo_back_creator_2 = $_POST["photo_back_creator_2"]; 
		$photo_back_source_2=	$_POST["photo_back_source_2"]; 
		$photo_back_copyright_2 =$_POST["photo_back_copyright_2"]; 
		$photo_back_comment_2 = 	$_POST["photo_back_comment_2"]; 
	
		$photo_front_filename_3 =$_POST["photo_front_filename_3"]; 
		$photo_front_creator_3 =$_POST["photo_front_creator_3"]; 
		$photo_front_source_3=	$_POST["photo_front_source_3"]; 
		$photo_front_copyright_3=$_POST["photo_front_copyright_3"]; 
		$photo_front_comment_3 = $_POST["photo_front_comment_3"]; 
	
		$photo_back_filename_3 = $_POST["photo_back_filename_3"]; 
		$photo_back_creator_3 = $_POST["photo_back_creator_3"]; 
		$photo_back_source_3=	$_POST["photo_back_source_3"]; 
		$photo_back_copyright_3 =$_POST["photo_back_copyright_3"]; 
		$photo_back_comment_3 = 	$_POST["photo_back_comment_3"]; 
	
		$photo_front_filename_4 =$_POST["photo_front_filename_4"]; 
		$photo_front_creator_4 =$_POST["photo_front_creator_4"]; 
		$photo_front_source_4=	$_POST["photo_front_source_4"]; 
		$photo_front_copyright_4=$_POST["photo_front_copyright_4"]; 
		$photo_front_comment_4 = $_POST["photo_front_comment_4"]; 
	
		$photo_back_filename_4 = $_POST["photo_back_filename_4"]; 
		$photo_back_creator_4 = $_POST["photo_back_creator_4"]; 
		$photo_back_source_4=	$_POST["photo_back_source_4"]; 
		$photo_back_copyright_4 =$_POST["photo_back_copyright_4"]; 
		$photo_back_comment_4 = 	$_POST["photo_back_comment_4"]; 
	
		$die_photo_filename_1 = 	$_POST["die_photo_filename_1"]; 
		$die_photo_creator_1 = 	$_POST["die_photo_creator_1"]; 
		$die_photo_source_1 =	$_POST["die_photo_source_1"]; 
		$die_photo_copyright_1 = $_POST["die_photo_copyright_1"]; 
		$die_photo_comment_1  = 	$_POST["die_photo_comment_1"]; 



		if( $edit_type === 'readd' ){  //// Re-Add mode
			$html_title_g = 'cpu-db.info - Add Chip Details';
			$html_keywords_g = 'CPU, MCU, DSP, BSP, add';

			$html_code .= "<h1>Add Chip Info</h1>\n";

			$title2 = "Add $manuf - $part";
			$add_or_edit = "add";


		}elseif( $edit_type === 'reedit' ){  //// Re-Add mode
			$html_title_g = 'cpu-db.info - Edit Chip Details';
			$html_keywords_g = 'CPU, MCU, DSP, BSP, edit';

			$html_code .= "<h1>Edit Chip Info</h1>\n";

			$title2 = "Edit $manuf - $part";
			$add_or_edit = "edit";
		}



	}elseif( $edit_type === 'edit' ){  //// Edit mode
		
		$manuf_text = "";
		$manuf_text .= <<<Endhtml
			<tr>
				<td class="table_param">Manufacturer:<span style="color: red;">*</span></td>
				<td class="table_value"><b>$manuf</b></td>
			</tr><tr>
				<td class="table_param">Manufacturer (if different):</td>
				<td class="table_value"><input type="text" name="manuf_diff" value=""> e.g. <i>Intel</i></td>
			</tr>
Endhtml;
		
		
		$html_title_g = 'cpu-db.info - Edit Chip Details';
		$html_keywords_g = 'CPU, MCU, DSP, BSP, edit';

		$html_code .= "<h1>Edit Chip Info</h1>\n";

		$title2 = "Edit $manuf - $part";
		$add_or_edit = "edit";

		$chip = get_single_chip_info($manuf,$part);
	
		$family = $chip["family"];
		$alternative_label_1 = $chip["alternative_label_1"];
		$alternative_label_2 = $chip["alternative_label_2"];
		$alternative_label_3 = $chip["alternative_label_3"];
		$alternative_label_4 = $chip["alternative_label_4"];
		$alternative_label_5 = $chip["alternative_label_5"];
		$alternative_label_6 = $chip["alternative_label_6"];
		$chip_type = $chip["chip_type"];
		$sub_family = $chip["sub_family"];
		$model_number = $chip["model_number"];
		$core = $chip["core"];
		$core_designer = $chip["core_designer"];
		$microarchitecture = $chip["microarchitecture"];
		$threads = $chip["threads"];
		$cpuid = $chip["cpuid"];
		$core_count = $chip["core_count"];
		$pipeline = $chip["pipeline"];
		$multiprocessing = $chip["multiprocessing"];	
		$architecture = $chip["architecture"];
		$data_bus_ext = $chip["data_bus_ext"];
		$address_bus = $chip["address_bus"];
		$bus_comments = $chip["bus_comments"]; 
		$frequency_ext = $chip["frequency_ext"]; 
		$frequency_min = $chip["frequency_min"];
		$frequency_max_typ = $chip["frequency_max_typ"];
		// echo "$frequency_max_typ = $chip['frequency_max_typ']";
		$actual_bus_frequency = $chip["actual_bus_frequency"];
		$effective_bus_frequency = $chip["effective_bus_frequency"];
		$bus_bandwidth = $chip["bus_bandwidth"];
		$clock_multiplier = $chip["clock_multiplier"];
		$core_stepping = $chip["core_stepping"];
		$l1_data_cache = $chip["l1_data_cache"];
		$l1_data_associativity = $chip["l1_data_associativity"];
		$l1_instruction_cache = $chip["l1_instruction_cache"];
		$l1_instruction_associativity = $chip["l1_instruction_associativity"];
		$l1_unified_cache = $chip["l1_unified_cache"];
		$l1_unified_associativity = $chip["l1_unified_associativity"];
		$l2_cache = $chip["l2_cache"];
		$l2_associativity = $chip["l2_associativity"];
		$l3_cache = $chip["l3_cache"];
		$l3_associativity = $chip["l3_associativity"];
		// $boot_rom = $chip["boot_rom"];
		$rom_internal = $chip["rom_internal"];
		$rom_type = $chip["rom_type"];
		$ram_internal = $chip["ram_internal"];
		$ram_max = $chip["ram_max"];
		$ram_type = $chip["ram_type"];
		$virtual_memory_max = $chip["virtual_memory_max"];
		$package = $chip["package"];
		$package_size = $chip["package_size"];
		$package_weight = $chip["package_weight"];
		$socket = $chip["socket"];
		$transistor_count = $chip["transistor_count"];
		$process_size = $chip["process_size"];
		$metal_layers = $chip["metal_layers"];
		$metal_type = $chip["metal_type"];
		$process_technology = $chip["process_technology"];
		$die_size = $chip["die_size"];
		$vcc_core_range = $chip["vcc_core_range"];
		$vcc_core_typ = $chip["vcc_core_typ"];
		$vcc_secondary = $chip["vcc_secondary"];
		$vcc_tertiary = $chip["vcc_tertiary"];
		$vcc_i_o = $chip["vcc_i_o"];
		$i_o_compatibillity = $chip["i_o_compatibillity"]; 
		$power_min = $chip["power_min"];
		$power_typ = $chip["power_typ"];
		$power_max = $chip["power_max"];
		$power_thermal_design = $chip["power_thermal_design"];
		$temperature_range = $chip["temperature_range"];
		$temperature_grade = $chip["temperature_grade"]; 
		$low_power_features = $chip["low_power_features"];
		$instruction_set = $chip["instruction_set"];
		$instruction_set_extensions = $chip["instruction_set_extensions"];
		$additional_instructions = $chip["additional_instructions"];
		$computer_architecture = $chip["computer_architecture"];
		$isa = $chip["isa"];
		$fpu = $chip["fpu"];
		$on_chip_peripherals = $chip["on_chip_peripherals"];
		$features = $chip["features"];
		$production_type = $chip["production_type"]; 
		$clone = $chip["clone"]; 
		$release_date = $chip["release_date"];
		$initial_price = $chip["initial_price"];
		$applications = $chip["applications"];
		$military_spec = $chip["military_spec"];
		$comments = $chip["comments"];
		$reference_1 = $chip["reference_1"];
		$reference_2 = $chip["reference_2"];
		$reference_3 = $chip["reference_3"];
		$reference_4 = $chip["reference_4"];
		$reference_5 = $chip["reference_5"];
		$reference_6 = $chip["reference_6"];
		$reference_7 = $chip["reference_7"];
		$reference_8 = $chip["reference_8"];
	
		$photo_front_filename_1 = $chip["photo_front_filename_1"]; 
		$photo_front_creator_1 = $chip["photo_front_creator_1"]; 
		$photo_front_source_1= 	 $chip["photo_front_source_1"]; 
		$photo_front_copyright_1= $chip["photo_front_copyright_1"]; 
		$photo_front_comment_1 =  $chip["photo_front_comment_1"]; 
	
		$photo_back_filename_1 =  $chip["photo_back_filename_1"]; 
		$photo_back_creator_1 =  $chip["photo_back_creator_1"]; 
		$photo_back_source_1= 	 $chip["photo_back_source_1"]; 
		$photo_back_copyright_1 = $chip["photo_back_copyright_1"]; 
		$photo_back_comment_1 = 	 $chip["photo_back_comment_1"]; 
	
		$photo_front_filename_2 =$chip["photo_front_filename_2"]; 
		$photo_front_creator_2 =$chip["photo_front_creator_2"]; 
		$photo_front_source_2=	$chip["photo_front_source_2"]; 
		$photo_front_copyright_2=$chip["photo_front_copyright_2"]; 
		$photo_front_comment_2 = $chip["photo_front_comment_2"]; 
	
		$photo_back_filename_2 = $chip["photo_back_filename_2"]; 
		$photo_back_creator_2 = $chip["photo_back_creator_2"]; 
		$photo_back_source_2=	$chip["photo_back_source_2"]; 
		$photo_back_copyright_2 =$chip["photo_back_copyright_2"]; 
		$photo_back_comment_2 = 	$chip["photo_back_comment_2"]; 
	
		$photo_front_filename_3 =$chip["photo_front_filename_3"]; 
		$photo_front_creator_3 =$chip["photo_front_creator_3"]; 
		$photo_front_source_3=	$chip["photo_front_source_3"]; 
		$photo_front_copyright_3=$chip["photo_front_copyright_3"]; 
		$photo_front_comment_3 = $chip["photo_front_comment_3"]; 
	
		$photo_back_filename_3 = $chip["photo_back_filename_3"]; 
		$photo_back_creator_3 = $chip["photo_back_creator_3"]; 
		$photo_back_source_3=	$chip["photo_back_source_3"]; 
		$photo_back_copyright_3 =$chip["photo_back_copyright_3"]; 
		$photo_back_comment_3 = 	$chip["photo_back_comment_3"]; 
	
		$photo_front_filename_4 =$chip["photo_front_filename_4"]; 
		$photo_front_creator_4 =$chip["photo_front_creator_4"]; 
		$photo_front_source_4=	$chip["photo_front_source_4"]; 
		$photo_front_copyright_4=$chip["photo_front_copyright_4"]; 
		$photo_front_comment_4 = $chip["photo_front_comment_4"]; 
	
		$photo_back_filename_4 = $chip["photo_back_filename_4"]; 
		$photo_back_creator_4 = $chip["photo_back_creator_4"]; 
		$photo_back_source_4=	$chip["photo_back_source_4"]; 
		$photo_back_copyright_4 =$chip["photo_back_copyright_4"]; 
		$photo_back_comment_4 = 	$chip["photo_back_comment_4"]; 
	
		$die_photo_filename_1 = 	$chip["die_photo_filename_1"]; 
		$die_photo_creator_1 = 	$chip["die_photo_creator_1"]; 
		$die_photo_source_1 =	$chip["die_photo_source_1"]; 
		$die_photo_copyright_1 = $chip["die_photo_copyright_1"]; 
		$die_photo_comment_1  = 	$chip["die_photo_comment_1"]; 
		
	}else{  ////   Add chip

		$manuf_array = get_manuf_list_alphabetical();

		$manuf_text = "";
		$manuf_text .= <<<Endhtml
			<tr>
				<td class="table_param">Manufacturer:<span style="color: red;">*</span></td>
				<td class="table_value">
					<select name="manuf">
Endhtml;

		foreach ($manuf_array as $manuf_t){
			$manuf_text .=	"\t\t\t\t<option value=\"$manuf_t\">$manuf_t</option>\n";
		}

		$manuf_text .= <<<Endhtml
				</select>	
(if not in list): <input type="text" name="manuf_not_in_list" value=""> e.g. <i>Intel</i></td>
			</tr>
Endhtml;


		$html_title_g = 'cpu-db.info - Add Chip';
		$html_keywords_g = 'CPU, MCU, DSP, BSP, add chip';

		$html_code .= "<h1>Add a chip</h1>\n";
		$title2 = "Add new chip";
		$add_or_edit = "add";
		
		$add_warning = '<div style="color: red; font-weight: bold;">Make sure the chip you are adding doesn\'t already exist';

		$family  = '';
		$alternative_label_1  = '';
		$alternative_label_2  = '';
		$alternative_label_3  = '';
		$alternative_label_4  = '';
		$alternative_label_5  = '';
		$alternative_label_6  = '';
		$chip_type  = '';
		$sub_family  = '';
		$model_number  = '';
		$core  = '';
		$core_designer  = '';
		$microarchitecture  = '';
		$threads  = '';
		$cpuid  = '';
		$core_count  = '';
		$pipeline  = '';
		$multiprocessing  = '';
		$architecture  = '';
		$data_bus_ext  = '';
		$address_bus  = '';
		$bus_comments  = '';
		$frequency_ext  = '';
		$frequency_min  = '';
		$frequency_max_typ  = '';
		// echo "$frequency_max_typ  = '';
		$actual_bus_frequency  = '';
		$effective_bus_frequency  = '';
		$bus_bandwidth  = '';
		$clock_multiplier  = '';
		$core_stepping  = '';
		$l1_data_cache  = '';
		$l1_data_associativity  = '';
		$l1_instruction_cache  = '';
		$l1_instruction_associativity  = '';
		$l1_unified_cache  = '';
		$l1_unified_associativity  = '';
		$l2_cache  = '';
		$l2_associativity  = '';
		$l3_cache  = '';
		$l3_associativity  = '';
		// $boot_rom  = '';
		$rom_internal  = '';
		$rom_type  = '';
		$ram_internal  = '';
		$ram_max  = '';
		$ram_type  = '';
		$virtual_memory_max  = '';
		$package  = '';
		$package_size  = '';
		$package_weight  = '';
		$socket  = '';
		$transistor_count  = '';
		$process_size  = '';
		$metal_layers  = '';
		$metal_type  = '';
		$process_technology  = '';
		$die_size  = '';
		$vcc_core_range  = '';
		$vcc_core_typ  = '';
		$vcc_secondary  = '';
		$vcc_tertiary  = '';
		$vcc_i_o  = '';
		$i_o_compatibillity  = '';
		$power_min  = '';
		$power_typ  = '';
		$power_max  = '';
		$power_thermal_design  = '';
		$temperature_range  = '';
		$temperature_grade  = '';
		$low_power_features  = '';
		$instruction_set  = '';
		$instruction_set_extensions  = '';
		$additional_instructions  = '';
		$computer_architecture  = '';
		$isa  = '';
		$fpu  = '';
		$on_chip_peripherals  = '';
		$features  = '';
		$production_type  = '';
		$clone  = '';
		$release_date  = '';
		$initial_price  = '';
		$applications  = '';
		$military_spec  = '';
		$comments  = '';
		$reference_1  = '';
		$reference_2  = '';
		$reference_3  = '';
		$reference_4  = '';
		$reference_5  = '';
		$reference_6  = '';
		$reference_7  = '';
		$reference_8  = '';
	
		$photo_front_filename_1  = '';
		$photo_front_creator_1  = '';
		$photo_front_source_1 = '';
		$photo_front_copyright_1 = '';
		$photo_front_comment_1  = '';
	
		$photo_back_filename_1  = '';
		$photo_back_creator_1  = '';
		$photo_back_source_1 = '';
		$photo_back_copyright_1  = '';
		$photo_back_comment_1  = '';
	
		$photo_front_filename_2  = '';
		$photo_front_creator_2  = '';
		$photo_front_source_2 = '';
		$photo_front_copyright_2 = '';
		$photo_front_comment_2  = '';
	
		$photo_back_filename_2  = '';
		$photo_back_creator_2  = '';
		$photo_back_source_2 = '';
		$photo_back_copyright_2  = '';
		$photo_back_comment_2  = '';
	
		$photo_front_filename_3  = '';
		$photo_front_creator_3  = '';
		$photo_front_source_3 = '';
		$photo_front_copyright_3 = '';
		$photo_front_comment_3  = '';
	
		$photo_back_filename_3  = '';
		$photo_back_creator_3  = '';
		$photo_back_source_3 = '';
		$photo_back_copyright_3  = '';
		$photo_back_comment_3  = '';
	
		$photo_front_filename_4  = '';
		$photo_front_creator_4  = '';
		$photo_front_source_4 = '';
		$photo_front_copyright_4 = '';
		$photo_front_comment_4  = '';
	
		$photo_back_filename_4  = '';
		$photo_back_creator_4  = '';
		$photo_back_source_4 = '';
		$photo_back_copyright_4  = '';
		$photo_back_comment_4  = '';
	
		$die_photo_filename_1  = '';
		$die_photo_creator_1  = '';
		$die_photo_source_1  = '';
		$die_photo_copyright_1  = '';
		$die_photo_comment_1   = '';
	}




	if(login_check($mysqli) == true) {
		$html_code .= <<<Endhtml

<div style="border-style: solid; border-width: 1px;width:800px;padding:10px;">
	<div style="font-weight: bold; font-size:20px;">Notes on how to edit:</div><br />
		<div style="padding:10px;">

		$add_warning

		<div style="color: red; font-weight: bold;">Required fields*</div>
		<br />

		<div style="font-weight: bold;">All info must come from a valid source, and referenced at the bottom.</div><br />

		<div style="font-weight: bold;">No HTML, or code.</div><br />

		<div style="font-weight: bold;">Use abbreviations when available.</div><br />

		<div style="font-weight: bold;">Prefered Units:</div>
		<ul>
			<li>b, B: <i>bit, byte</i> </li>
			<li>um, nm: <i>micrometers, nanometers</i> </li>
			<li>mm^2, mm^3: <i>square millimeters, cubic millimeters</i> </li>
			<li>V, W: <i>Volts, Watts</i> </li>
			<li>C: <i>Celsius</i> </li>
			<li>kHz, MHz, GHz: <i>kilo-Hertz, mega-Hertz, giga-Hertz</i> </li>
			<li>KiB, MiB, GiB: <i>kilobytes, megabytes, gigabytes</i> </li>
			<li>MiB/s, GiB/s: <i>megabytes per second, gigabytes per second</i> </li>
			<li>k, M: <i>thousand, million</i> </li>
			<li>currency: <i>dollars US</i> </li>
			<li>date format: <i>13 April 2001</i> </li>
		</ul><br />

	</div>
</div><br /><br />

	

	<div style="font-weight: bold;">$title2</div><br />

	<form name="form" method="post" action="edit_chip_info.php">
	<table>
		<tr>
			<td>


	<table>
	  <tr>
	  <td colspan="2" width="700">
		<table width="100%">
$manuf_text
			<tr>
				<td class='table_param'>Manufacture Part Number:<span style="color: red; ">*</span></td>
				<td class='table_value'><input type="text" name="part" value="$part"> e.g. <i>A80486DX-25</i></td>
			</tr><tr>
				<td class='table_param'>Chip type:</td>
				<td class='table_value'><input type="text" name="chip_type" value="$chip_type"> e.g. <i>CPU, DSP, MCU, BSP, FPU</i></td>
			</tr><tr>
				<td class='table_param'>Family:</td>
				<td class='table_value'><input type="text" name="family" value="$family"> e.g. <i>Core 2</i></td>
		</tr><tr>
			<td class='table_param'>Sub-family:</td>
			<td class='table_value'><input type="text" name="sub_family" value="$sub_family"> e.g. <i>Core 2 Quad</i></td>
		</tr><tr>
			<td class='table_param'>Processor's Families Model:</td>
			<td class='table_value'><input type="text" name="model_number" value="$model_number"> e.g. <i>Q8300</i></td>
		</tr><tr>
			<td class='table_param'>Alt Chip Label 1:</td>
			<td class='table_value'><input type="text" name="alternative_label_1" value="$alternative_label_1"> e.g. <i>SL34Q</i></td>
		</tr><tr>
			<td class='table_param'>Alt Chip Label 2:</td>
			<td class='table_value'><input type="text" name="alternative_label_2" value="$alternative_label_2"></td>
		</tr><tr>
			<td class='table_param'>Alt Chip Label 3:</td>
			<td class='table_value'><input type="text" name="alternative_label_3" value="$alternative_label_3"></td>
		</tr><tr>
			<td class='table_param'>Alt Chip Label 4:</td>
			<td class='table_value'><input type="text" name="alternative_label_4" value="$alternative_label_4"></td>
		</tr><tr>
			<td class='table_param'>Alt Chip Label 5:</td>
			<td class='table_value'><input type="text" name="alternative_label_5" value="$alternative_label_5"></td>
			</tr>		
		</table><br />
	  </td>
	  </tr>
	  <tr>
	  	<td colspan="2" class='table_sec'>Core</td>
	  </tr>
	  <tr>
	  	<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
					<td class='table_param'>Processor core:</td>
					<td class='table_value'><input type="text" name="core" value="$core"> e.g. <i>ARMv4</i></td>
				</tr>
				<tr>
					<td class='table_param'>Core designer:</td>
					<td class='table_value'><input type="text" name="core_designer" value="$core_designer"> e.g. <i>ARM</i></td>
				</tr>
				<tr>
					<td class='table_param'>Number of Cores:</td>
					<td class='table_value'><input type="text" name="core_count" value="$core_count"> e.g. <i>2</i></td>
				</tr>
<tr><td class='table_param'>Threads:</td><td class='table_value'><input type="text" name="threads" value="$threads"> e.g. <i>2</i></td></tr>
				<tr>
			  		<td class='table_param'>CPUID:</td>
					<td class='table_value'><input type="text" name="cpuid" value="$cpuid"> e.g. <i>1067A</i></td>
				</tr>
				<tr>
					<td class='table_param'>Core stepping:</td>
					<td class='table_value'><input type="text" name="core_stepping" value="$core_stepping"> e.g. <i>R0</i></td>
				</tr>
				<tr>
			  		<td class='table_param'>Pipeline:</td>
					<td class='table_value'><input type="text" name="pipeline" value="$pipeline"> e.g. <i>5-stage</i></td>
				</tr>
				<tr>
					<td class='table_param'>Multiprocessing support:</td>
					<td class='table_value'><input type="text" name="multiprocessing" value="$multiprocessing"> e.g. <i>Yes, No</i></td>
				</tr>
			</table>
		</td>
		</tr>
	 <tr>
	  	<td colspan="2" class='table_sec'>Bus</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
			  		<td class='table_param'>Architecture:</td>
					<td class='table_value'><input type="text" name="architecture" value="$architecture"> e.g. <i>8, 16, 32</i></td> 
				</tr>
				<tr>
			  		<td class='table_param'>External data bus:</td>
					<td class='table_value'><input type="text" name="data_bus_ext" value="$data_bus_ext"> e.g. <i>8, 16, 32</i></td>
				</tr>
				<tr>
			  		<td class='table_param'>Address bus:</td>
					<td class='table_value'><input type="text" name="address_bus" value="$address_bus"> e.g. <i>8, 16, 32</i></td>
				</tr>
<tr><td class='table_param'>Bus comments:</td><td class='table_value'><input type="text" name="bus_comments" value="$bus_comments"></td></tr>
			</table>
		</td>
	</tr>
	 <tr>
	  	<td colspan="2" class='table_sec'>Speed</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
<tr><td class='table_param'>Frequency (min):</td><td class='table_value'><input type="text" name="frequency_min" value="$frequency_min"> units: <i>kHz, MHz, GHz</i></td></tr>
				<tr>
		  			<td class='table_param_long'>Frequency: (typical or max)</td>
					<td class='table_value'><input type="text" name="frequency_max_typ" value="$frequency_max_typ"> units: <i>kHz, MHz, GHz</i></td>
				</tr>
<tr><td class='table_param'>Frequency (ext):</td><td class='table_value'><input type="text" name="frequency_ext" value="$frequency_ext"> units: <i>kHz, MHz, GHz</i></td></tr>
				<tr>
		  			<td class='table_param_long'>Clock multiplier:</td>
					<td class='table_value'><input type="text" name="clock_multiplier" value="$clock_multiplier"> e.g. <i>2x</i></td>
				</tr><tr>
		  			<td class='table_param_long'>Bus frequency, actual:</td>
					<td class='table_value'><input type="text" name="actual_bus_frequency" value="$actual_bus_frequency"> units: <i>kHz, MHz, GHz</i></td>
				</tr><tr>
		  			<td class='table_param_long'>Bus frequency, effective:</td>
					<td class='table_value'><input type="text" name="effective_bus_frequency" value="$effective_bus_frequency"> units: <i>kHz, MHz, GHz</i></td>
				</tr><tr>
		  			<td class='table_param_long'>Bus bandwidth:</td>
					<td class='table_value'><input type="text" name="bus_bandwidth" value="$bus_bandwidth"> units: <i>KiB/s, MiB/s</i></td>
				</tr>
			</table>
		</td>
	</tr>
		 <tr>
	  	<td colspan="2" class='table_sec'>Memory</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
				  	<td colspan="2" class='table_param'>RAM</td>
				</tr>
				<tr>
					<td class='table_td_blank'></td>
					<td>
						<table width="100%">
							<tr>
					  			<td class='table_param'>RAM external(max):</td>
								<td class='table_value'><input type="text" name="ram_max" value="$ram_max"> units: <i>KiB, MiB, GiB, TiB</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>RAM external type:</td>
								<td class='table_value'><input type="text" name="ram_type" value="$ram_type"> e.g. <i>DRAM, SDRAM, DDR</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>Internal RAM:</td>
								<td class='table_value'><input type="text" name="ram_internal" value="$ram_internal"> units: <i>b, B, KiB; or "NA" </i></td>
							</tr>
							<tr>
					  			<td class='table_param'>Virtual memory:</td>
								<td class='table_value'><input type="text" name="virtual_memory_max" value="$virtual_memory_max"> units: <i>GiB, TiB, EiB; or "Not supported" or "NA"  </i></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
				  	<td colspan="2" class='table_param'>ROM</td>
				</tr>
				<tr>
					<td class='table_td_blank'></td>
					<td>
						<table width="100%">
							<tr>
					  			<td class='table_param'>ROM internal:</td>
								<td class='table_value'><input type="text" name="rom_internal" value="$rom_internal"> units: <i>b, B, KiB; or "NA"</i></td>
							</tr>
							<tr>	
					  			<td class='table_param'>ROM type:</td>
								<td class='table_value'><input type="text" name="rom_type" value="$rom_type"> e.g. <i>Masked ROM, OTP, UV-EPROM, EEPROM, flash, or NA</i></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
				  	<td colspan="2" class='table_param'>Cache</td>
				</tr>
				<tr>
					<td colspan="2">
						<table>
							<tr>
					  			<td class='table_param'>L1 data cache:</td>
								<td class='table_value'><input type="text" name="l1_data_cache" value="$l1_data_cache"> units: <i>b, B, KiB; or "NA"</i></td>
							</tr>
							<tr> 
					  			<td class='table_param'>L1 data cache specs</td>
								<td class='table_value'><input type="text" name="l1_data_associativity" value="$l1_data_associativity"> e.g. <i>associativity, write policy, external</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>L1 instruction cache:</td>
								<td class='table_value'><input type="text" name="l1_instruction_cache" value="$l1_instruction_cache"> units: <i>b, B, KiB; or "NA" </i></td>
							</tr>
							<tr> 
					  			<td class='table_param'>L1 instruction cache specs:</td>
								<td class='table_value'><input type="text" name="l1_instruction_associativity" value="$l1_instruction_associativity"> e.g. <i>associativity, write policy, external</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>L1 unified cache:</td>
								<td class='table_value'><input type="text" name="l1_unified_cache" value="$l1_unified_cache"> units: <i>b, B, KiB; or "NA"</i></td>
							</tr>
							<tr> 
					  			<td class='table_param'>L1 unified cache specs:</td>
								<td class='table_value'><input type="text" name="l1_unified_associativity" value="$l1_unified_associativity"> e.g. <i>associativity, write policy, external</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>L2 cache:</td>
								<td class='table_value'><input type="text" name="l2_cache" value="$l2_cache"> units: <i>B, KiB, MiB; or "NA" </i></td>
							</tr>
							<tr> 
					  			<td class='table_param'>L2 cache specs:</td>
								<td class='table_value'><input type="text" name="l2_associativity" value="$l2_associativity"> e.g. <i>associativity, write policy, external</i></td>
							</tr>
							<tr>
					  			<td class='table_param'>L3 cache:</td>
								<td class='table_value'><input type="text" name="l3_cache" value="$l3_cache"> units: <i>KiB, MiB; or "NA"</i></td>
							</tr>
							<tr> 
					  			<td class='table_param'>L3 cache specs:</td>
								<td class='table_value'><input type="text" name="l3_associativity" value="$l3_associativity"> e.g. <i>associativity, write policy, external</i></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Package</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
				  	<td class='table_param'>Package:</td>
					<td class='table_value'><input type="text" name="package" value="$package"> e.g. <i>PDIP-40, CPGA-68, Staggered PPGA-370</i></td>
				</tr>
				<tr>		
		  			<td class='table_param'>Socket:</td>
					<td class='table_value'><input type="text" name="socket" value="$socket"> e.g. <i>DIP-40, Socket-7, Socket 370</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Package size:</td>
					<td class='table_value'><input type="text" name="package_size" value="$package_size"> e.g. <i>2.75 x 2.75 cm^2</i></td>	
				</tr>
				<tr>
		  			<td class='table_param'>Package weight:</td>
					<td class='table_value'><input type="text" name="package_weight" value="$package_weight"> e.g. <i>10g</i></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Power</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_param'>Supply voltage(typ):</td>
					<td class='table_value'><input type="text" name="vcc_core_typ" value="$vcc_core_typ"> e.g. <i>3.3V, 5V</i></td>
				</tr><tr>
		  			<td class='table_param'>Suppy voltage range:</td>
					<td class='table_value'><input type="text" name="vcc_core_range" value="$vcc_core_range"> e.g. <i>3 to 5.5V, 5V +/- 10%</i></td>
				</tr><tr>	
		  			<td class='table_param'>I/O voltage:</td>
					<td class='table_value'><input type="text" name="vcc_i_o" value="$vcc_i_o"> e.g. <i>5V, 3.3V</i></td>
				</tr><tr>
					<td class='table_param'>I/O compatability:</td>
					<td class='table_value'><input type="text" name="i_o_compatibillity" value="$i_o_compatibillity"> e.g. <i>TTL, CMOS, LVTTL</i></td>
				</tr><tr>
					<td class='table_param'>Secondary voltage:</td>
					<td class='table_value'><input type="text" name="vcc_secondary" value="$vcc_secondary"> e.g. <i>12V</i></td>
				</tr><tr>
					<td class='table_param'>Tersiary voltage:</td>
					<td class='table_value'><input type="text" name="vcc_tertiary" value="$vcc_tertiary"> e.g. <i>-5V</i></td>
				</tr><tr>
		  			<td class='table_param'>Power(min):</td>
					<td class='table_value'><input type="text" name="power_min" value="$power_min"> units: <i>uW, mW, W</i></td>	
				</tr>
				<tr>
		  			<td class='table_param'>Power(typ):</td>
					<td class='table_value'><input type="text" name="power_typ" value="$power_typ"> units: <i>uW, mW, W</i></td>	
				</tr>
				<tr>
		  			<td class='table_param'>Power(max):</td>
					<td class='table_value'><input type="text" name="power_max" value="$power_max"> units: <i>uW, mW, W</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Thermal Power:</td>
					<td class='table_value'><input type="text" name="power_thermal_design" value="$power_thermal_design"> units: <i>W</i></td>
				</tr>
				<tr>	
		  			<td class='table_param'>Temp range:</td>
					<td class='table_value'><input type="text" name="temperature_range" value="$temperature_range"> e.g. <i>-40 to 85C</i></td>
				</tr>
				<tr>	
		  			<td class='table_param'>Temp grade:</td>
					<td class='table_value'><input type="text" name="temperature_grade" value="$temperature_grade"> e.g. <i>Commercial, Extended, Industial, Millitary</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Low power features:</td>
					<td class='table_value'><input type="text" name="low_power_features" value="$low_power_features"> e.g. <i>HALT mode, Deep Sleep state</i></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Instruction set</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_param'>ISA:</td>
					<td class='table_value'><input type="text" name="isa" value="$isa">  e.g. <i>x86, x86-64, SPARC, MIPS, ARM</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Instruction set:</td>
					<td class='table_value'><input type="text" name="instruction_set" value="$instruction_set"> e.g. <i>486, SPARCv7</i></td>	
				</tr>
				<tr>
					<td class='table_param'>Instruction set extensions:</td>
					<td class='table_value'><input type="text" name="instruction_set_extensions" value="$instruction_set_extensions"> e.g. <i>MMX, SSE</i></td>
				</tr>
				<tr>
					<td class='table_param'>Additional instructions:</td>
					<td class='table_value'><input type="text" name="additional_instructions" value="$additional_instructions"> e.g. <i>CLFLUSH, CMPXCHG16B</i></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Technology</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_param'>Process Tech:</td>
					<td class='table_value'><input type="text" name="process_technology" value="$process_technology"> e.g. <i>Bipolar, BiCMOS, PMOS, NMOS, HMOS, CMOS</i></td>
				</tr>
				<tr>
					<td class='table_param'>Metal layers:</td>
					<td class='table_value'><input type="text" name="metal_layers" value="$metal_layers"> e.g. <i>3, 4, 5</i></td>
				</tr>
				<tr>
					<td class='table_param'>Metal type:</td>
					<td class='table_value'><input type="text" name="metal_type" value="$metal_type"> e.g. <i>Al, Cu</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Transistors:</td>
					<td class='table_value'><input type="text" name="transistor_count" value="$transistor_count"> e.g. <i>29k, 6.6M</i></td>
				</tr>
				<tr>	
		  			<td class='table_param'>Die Size:</td>
					<td class='table_value'><input type="text" name="die_size" value="$die_size"> e.g. <i>6.6 x 5.6 mm^2, 180mm^2</i></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Features</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_param'>FPU:</td>
					<td class='table_value'><input type="text" name="fpu" value="$fpu"> e.g. <i>Integated, Ext 80387, NA</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>On chip peripherals:</td>
					<td class='table_value'><input type="text" name="on_chip_peripherals" value="$on_chip_peripherals"> e.g. <i>ADC, MMU, WDT; use acronyms if posible</i></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" class='table_sec'>Additional info</td>
	</tr>
	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_param'>Introduction date:</td>
					<td class='table_value'><input type="text" name="release_date" value="$release_date"> format: <i>15 April 2012</i> </td>
				</tr>
				<tr>
		  			<td class='table_param'>Introduction price:</td>
					<td class='table_value'><input type="text" name="initial_price" value="$initial_price"> units: <i>in US dollars</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Production type:</td>
					<td class='table_value'><input type="text" name="production_type" value="$production_type"> e.g. <i>Normal, Customer sample, Engineering sample</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Clone:</td>
					<td class='table_value'><input type="text" name="clone" value="$clone"> e.g. <i>"no", "yes, clone of Intel 486DX", "based on Z-80" </i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Typical application:</td>
					<td class='table_value'><input type="text" name="applications" value="$applications"> e.g. <i>Desktop computer, server, embedded system, game console, TV/monitor</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Military specifications:</td>
					<td class='table_value'><input type="text" name="military_spec" value="$military_spec"> e.g. <i>no, yes, MIL-STD-883</i></td>
				</tr>
				<tr>
		  			<td class='table_param'>Features:</td>
					<td class='table_value'><input type="text" name="features" value="$features"></td>
				</tr>
				<tr>
		  			<td class='table_param'>Comments about chip:</td>
					<td class='table_value'><input type="text" name="comments" value="$comments"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class='table_sec'><br /><br />Photos</td>
	</tr><tr>
	<td colspan="2" class='table_value'>
&nbsp;&nbsp;<b>Filenames:</b> Use the filename generated by the Upload page<br /><br />

&nbsp;&nbsp;<b>front:</b> is the front or top of the chip.<br />
&nbsp;&nbsp;<b>back:</b> is the back or bottom of the chip. <br />
&nbsp;&nbsp;<b>die:</b> is <a href="http://en.wikipedia.org/wiki/Die_%28integrated_circuit%29">die</a> of the chip.<br /><br />

&nbsp;&nbsp;<b><a href="$script_name_g?page=upload" target="_blank">Upload an Image</a></b><br /><br />

		</td>
	</tr>

	<tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
	
			<tr>
				<td class='table_param'>photo_front_filename_1</td>
				<td class='table_value'><input type="text" name="photo_front_filename_1" value="$photo_front_filename_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>
	
			<tr>
				<td class='table_param'>photo_back_filename_1</td>
				<td class='table_value'><input type="text" name="photo_back_filename_1" value="$photo_back_filename_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_2</td>
				<td class='table_value'><input type="text" name="photo_front_filename_2" value="$photo_front_filename_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_2</td>
				<td class='table_value'><input type="text" name="photo_back_filename_2" value="$photo_back_filename_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_3</td>
				<td class='table_value'><input type="text" name="photo_front_filename_3" value="$photo_front_filename_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_3</td>
				<td class='table_value'><input type="text" name="photo_back_filename_3" value="$photo_back_filename_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_4</td>
				<td class='table_value'><input type="text" name="photo_front_filename_4" value="$photo_front_filename_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_4</td>
				<td class='table_value'><input type="text" name="photo_back_filename_4" value="$photo_back_filename_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>die_photo_filename_1</td>
				<td class='table_value'><input type="text" name="die_photo_filename_1" value="$die_photo_filename_1" size="60"></td>
			</tr>
		</table>
			</td>
		</tr>
	</table>
	<br />

	<table>
	  	<tr>
			<td colspan="2" class='table_sec'>References<span style="color: red; ">*</span></td>
		</tr><tr>
			<td class='table_td_blank'></td>
			<td class='table_value'>
				At least one reference is required.
			</td>
	  </tr>
	  <tr>
			<td class='table_td_blank'></td>
			<td>
			<table width="100%">
				<tr>
					<td class='table_value'>
&oplus; Reference 1:<span style="color: red;">*</span> <input type="text" size="105" name="reference_1" value="$reference_1">
<br />
&oplus; Reference 2: <input type="text" size="105" name="reference_2" value="$reference_2">
<br />
&oplus; Reference 3: <input type="text" size="105" name="reference_3" value="$reference_3">
<br />
&oplus; Reference 4: <input type="text" size="105" name="reference_4" value="$reference_4">
<br />
&oplus; Reference 5: <input type="text" size="105" name="reference_5" value="$reference_5">
<br />
&oplus; Reference 6: <input type="text" size="105" name="reference_6" value="$reference_6">
<br />
&oplus; Reference 7: <input type="text" size="105" name="reference_7" value="$reference_7">
<br />
&oplus; Reference 8: <input type="text" size="105" name="reference_8" value="$reference_8">
<br /><br />




<b>Example formating:</b><br />
<ul>
	<li>http://www.cpu-world.com/CPUs/6800/AMI-S6800D.html Accessed 15 April 2013</li>
	<li>Datasheet: Hitachi, "SH7708 Series SH7708, SH7708S, SH7708R Hardware Manual", ADE-602-105E, May 1999. Available from http://www.alldatasheet.com/datasheet-pdf/pdf/93970/HITACHI/HD6417708F60.html Accessed 10 Dec 2012</li>
</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr><tr>
	  	<td colspan="2" class='table_sec'><br /><br />Comments on submission:</td>
	</tr><tr>
		<td class='table_td_blank'></td>
		<td>
			<input type="text" size="80" name="submission_comments"><br /><br />
			<input type="hidden" name="add_or_edit" value="$add_or_edit">
			<input type="submit" value="Submit">
		</td>
	  </tr>
	</table>	
	
	</form> 
	<br /><br /><br />


Endhtml;

	} else {
		$html_code .= "You must be logged in to edit the db<br />\n<a href=\"login.php\">Login/Register</a>";
	}

	return $html_code;
}









//////////////////////////////////////////////////////////
//  Create query statement
//

function edit_chip_info(){
	global $table_cpu_db, $db_handle;

	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$chip_type = $_POST["chip_type"];
	$family = $_POST["family"];
	$sub_family = $_POST["sub_family"];
	$model_number = $_POST["model_number"];
	$alternative_label_1 = $_POST["alternative_label_1"];
	$alternative_label_2 = $_POST["alternative_label_2"];
	$alternative_label_3 = $_POST["alternative_label_3"];
	$alternative_label_4 = $_POST["alternative_label_4"];
	$alternative_label_5 = $_POST["alternative_label_5"];
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
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];

	$params = "manufacturer='$manuf', part='$part', chip_type='$chip_type', family='$family', sub_family='$sub_family', model_number='$model_number', alternative_label_1='$alternative_label_1', alternative_label_2='$alternative_label_2', alternative_label_3='$alternative_label_3', alternative_label_4='$alternative_label_4', alternative_label_5='$alternative_label_5', core='$core', core_designer='$core_designer', core_count='$core_count', threads='$threads', cpuid='$cpuid', core_stepping='$core_stepping', pipeline='$pipeline', multiprocessing='$multiprocessing', architecture='$architecture', data_bus_ext='$data_bus_ext', address_bus='$address_bus', bus_comments='$bus_comments', frequency_min='$frequency_min', frequency_max_typ='$frequency_max_typ', frequency_ext='$frequency_ext', clock_multiplier='$clock_multiplier', actual_bus_frequency='$actual_bus_frequency', ";
	$params .= "effective_bus_frequency='$effective_bus_frequency', bus_bandwidth='$bus_bandwidth', ram_max='$ram_max', ram_type='$ram_type', ram_internal='$ram_internal', virtual_memory_max='$virtual_memory_max', rom_internal='$rom_internal', rom_type='$rom_type', l1_data_cache='$l1_data_cache', l1_data_associativity='$l1_data_associativity', l1_instruction_cache='$l1_instruction_cache', l1_instruction_associativity='$l1_instruction_associativity', l1_unified_cache='$l1_unified_cache', l1_unified_associativity='$l1_unified_associativity', l2_cache='$l2_cache', l2_associativity='$l2_associativity', l3_cache='$l3_cache', l3_associativity='$l3_associativity', package='$package', socket='$socket', package_size='$package_size', package_weight='$package_weight', vcc_core_typ='$vcc_core_typ', vcc_core_range='$vcc_core_range', vcc_i_o='$vcc_i_o', i_o_compatibillity='$i_o_compatibillity', vcc_secondary='$vcc_secondary', vcc_tertiary='$vcc_tertiary', power_min='$power_min', power_typ='$power_typ', power_max='$power_max', power_thermal_design='$power_thermal_design', temperature_range='$temperature_range', temperature_grade='$temperature_grade', low_power_features='$low_power_features', isa='$isa', instruction_set='$instruction_set', instruction_set_extensions='$instruction_set_extensions', additional_instructions='$additional_instructions', process_technology='$process_technology', metal_layers='$metal_layers', ";
	$params .= "metal_type='$metal_type', transistor_count='$transistor_count', die_size='$die_size', fpu='$fpu', on_chip_peripherals='$on_chip_peripherals', release_date='$release_date', initial_price='$initial_price', production_type='$production_type', clone='$clone', applications='$applications', military_spec='$military_spec', features='$features', comments='$comments', reference_1='$reference_1', reference_2='$reference_2', reference_3='$reference_3', reference_4='$reference_4', reference_5='$reference_5', reference_6='$reference_6', reference_7='$reference_7', reference_8='$reference_8', photo_front_filename_1='$photo_front_filename_1', photo_back_filename_1='$photo_back_filename_1', photo_front_filename_2='$photo_front_filename_2', photo_back_filename_2='$photo_back_filename_2', photo_front_filename_3='$photo_front_filename_3', photo_back_filename_3='$photo_back_filename_3', photo_front_filename_4='$photo_front_filename_4', photo_back_filename_4='$photo_back_filename_4', die_photo_filename_1='$die_photo_filename_1'";


	global $table_cpu_db, $db_handle;

	$query = "UPDATE $table_cpu_db SET $params WHERE manufacturer='$manuf' AND part='$part'";

	$results = mysql_query($query, $db_handle);
	if (!$results) {
 		echo "Could not execute query: $query\n";
	   	trigger_error(mysql_error(), E_USER_ERROR);
	}

}








function display_add_edit_main_page(){
	global $script_name_g, $mysqli;


	$add_or_edit = $_POST["add_or_edit"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];

	if( $_GET["page"] === "add_chip" ){ //add
		$html_code .= "<h2>Adding chip to db</h2>";
	}elseif( $_GET["page"] === "edit_chip" ){ //edit
		$html_code .= "<h2>Editing chip in db</h2>";
	}

	if(login_check($mysqli) == true) {
		if( isset($_GET["page"]) ){ // Edit pages
			// $html_code .= "<h1>Main</h1>\n";

			if( $_GET["page"] === "add_chip" ){ //add
				$html_code .= display_add_edit_chip_page("", "", "add");
			}elseif( $_GET["page"] === "edit_chip" ){ //edit
				$html_code .= display_add_edit_chip_page($_GET["manuf"], $_GET["part"], "edit");
			}else{
				$html_code .= "<p style=\"color: red;\">Error: undefined page type</p>";
				log_it("Error: edit_chip_info.php?page= not add_chip or edit_chip");
			}

		}elseif( isset($_POST["add_or_edit"]) ){ // Submitted pages
			$html_code .= "<h1>Submitted</h1>\n";

			if( $_POST["add_or_edit"] === "add" ){ // Add submissions
				$html_code .= "<h2>Adding</h2>\n";			
				$html_code .= add_submission();
			}elseif( $_POST["add_or_edit"] === "edit" ){ // Edit
				$html_code .= "<h2>Editing</h2>\n";			
				$html_code .= edit_submission();
			}else{
				$html_code .= "<p style=\"color: red;\">Error: form not 'add' or 'edit'</p>\n";
				log_it("Error: edit_chip_info.php: form not add or edit");
			}


		}else{
			$html_code .= "<p style=\"color: red;\">Error: not add/edit page or submisson</p>\n";
			log_it("Error: edit_chip_info.php: not add/edit page or submisson");
		}
	}else{
		$html_code .= "<p style=\"color: red;\">Error: Not Logged in!</p>\n";
		log_it("Error: edit_chip_info.php not logged in");
	}


	return $html_code;
}










function display_add_edit_page(){
	global $script_name_g, $mysqli;


	$add_or_edit = $_POST["add_or_edit"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];


	$html_code = '';

	
	
	
	if( $add_or_edit === "add"  ){
		$html_code .= "<h1>Add mode</h1>\n";
	}else{
		$html_code .= "<h1>Edit mode</h1>\n";
	}
}

	// if( min_form_reqirements() ){
		// $min_form = true;
	// }else{
		// echo "<p style=\"color: red;\">Required: Submission requires a manufacture, part number, and reference at minimum</p><br />\n";
		// $min_form = false;
	// }	


	// if( check_if_chip_exists() ){
		// echo "Chip is found in the DB<br />\n";
		// $chip_exists = true;
	// }else{
		// echo "Chip is not found in the DB<br />\n";
		// $chip_exists = false;	
	// }






function add_submission(){
	global $script_name_g, $mysqli;


	$add_or_edit = $_POST["add_or_edit"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	
	$photo_front_filename_1 = $_POST["photo_front_filename_1"];
	$photo_back_filename_1 = $_POST["photo_back_filename_1"];
	$photo_front_filename_2 = $_POST["photo_front_filename_2"];
	$photo_back_filename_2 = $_POST["photo_back_filename_2"];
	$photo_front_filename_3 = $_POST["photo_front_filename_3"];
	$photo_back_filename_3 = $_POST["photo_back_filename_3"];
	$photo_front_filename_4 = $_POST["photo_front_filename_4"];
	$photo_back_filename_4 = $_POST["photo_back_filename_4"];
	$die_photo_filename_1 = $_POST["die_photo_filename_1"];


	$html_code = '';

	$log_error = '';


	if($add_or_edit === "add" ){
		if( !(check_if_chip_exists()) && min_form_reqirements() && (login_check($mysqli) == true) && does_image_exist($photo_front_filename_1) && does_image_exist($photo_back_filename_1) && does_image_exist($photo_front_filename_2) && does_image_exist($photo_back_filename_2) && does_image_exist($photo_front_filename_3) && does_image_exist($photo_back_filename_3) && does_image_exist($photo_front_filename_4) && does_image_exist($photo_back_filename_4) && does_image_exist($die_photo_filename_1) ){
			add_chip_to_db();
			$html_code .= "Success: Chip added<br /><br />\n";
			$html_code .= "Check the chip's page: <a href=\"$script_name_g?page=c&manuf=$manuf&part=$part\">$script_name_g?page=c&manuf=$manuf&part=$part</a><br /><br />\n";
			log_it("Edit Chip Success: manuf=$manuf, part=$part");		
		}else{
			$html_code .= "<p style=\"color: red;\">Error: Chip not added</p><br />\n";
			if( check_if_chip_exists() ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Chip already exists<br />\n";
				$log_error .= "Chip already exists; ";
			}
			if( !(min_form_reqirements()) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Requires a manufacture, part number, and reference at minimum<br />\n";
				$log_error .= "not min requirements";
			}
			if((login_check($mysqli) == false) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Not logged in<br />\n";
				$log_error .= "not logged in; ";
			}
			if( !( does_image_exist($photo_front_filename_1) ) && !( empty($photo_front_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_1 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_1) ) && !( empty($photo_back_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_1 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_2) ) && !( empty($photo_front_filename_2) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_2</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_2 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_2) ) && !( empty($photo_back_filename_2) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_2</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_2 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_3) ) && !( empty($photo_front_filename_3) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_3</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_3 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_3) ) && !( empty($photo_back_filename_3) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_3</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_3 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_4) ) && !( empty($photo_front_filename_4) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_4</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_4 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_4) ) && !( empty($photo_back_filename_4) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_4</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_4 not uploaded; ";
			}
			if( !( does_image_exist($die_photo_filename_1) ) && !( empty($die_photo_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$die_photo_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$die_photo_filename_1 not uploaded; ";
			}
			
			log_it("Add Chip Error: manuf=$manuf, part=$part; $log_error");
			$html_code .= "</p>"; 

			$html_code .= display_add_edit_chip_page($manuf, $part, "add");

		}
	}
	return $html_code;
}









function edit_submission(){
	global $script_name_g, $mysqli;


	$add_or_edit = $_POST["add_or_edit"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];


	$html_code = '';

	$log_error = '';


	$html_code .= "<h2>Editing chip in DB</h2>\n";

	if($add_or_edit === "edit" ){
		if( check_if_chip_exists() && min_form_reqirements() && (login_check($mysqli) == true) && does_image_exist($photo_front_filename_1) && does_image_exist($photo_back_filename_1) && does_image_exist($photo_front_filename_2) && does_image_exist($photo_back_filename_2) && does_image_exist($photo_front_filename_3) && does_image_exist($photo_back_filename_3) && does_image_exist($photo_front_filename_4) && does_image_exist($photo_back_filename_4) && does_image_exist($die_photo_filename_1)  ){
			edit_chip_info();
			$html_code .= "Success: Chip info Modified<br />\n";
			$html_code .= "Check the chip's page: <a href=\"$script_name_g?page=c&manuf=$manuf&part=$part\">$script_name_g?page=c&manuf=$manuf&part=$part</a><br /><br />\n";
			log_it("Edit Chip Success: manuf=$manuf, part=$part");		
		}else{
			$html_code .= "<p style=\"color: red;\">Error: Chip not modified</p><br />\n";
			if( !(check_if_chip_exists()) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Chip does not exist<br />\n";
				$log_error .= "Chip doesn't exists; ";
			}
			if((login_check($mysqli) == false) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Not logged in<br />\n";
				$log_error .= "not logged in; ";
			}
			if( !(min_form_reqirements()) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Requires a manufacture, part number, and reference at minimum<br />\n";
				$log_error .= "not min requirements";
			}
			if( !( does_image_exist($photo_front_filename_1) ) && !( empty($photo_front_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_1 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_1) ) && !( empty($photo_back_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_1 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_2) ) && !( empty($photo_front_filename_2) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_2</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_2 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_2) ) && !( empty($photo_back_filename_2) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_2</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_2 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_3) ) && !( empty($photo_front_filename_3) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_3</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_3 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_3) ) && !( empty($photo_back_filename_3) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_3</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_3 not uploaded; ";
			}
			if( !( does_image_exist($photo_front_filename_4) ) && !( empty($photo_front_filename_4) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_front_filename_4</i> has not been uploaded<br />\n";
				$log_error .= "$photo_front_filename_4 not uploaded; ";
			}
			if( !( does_image_exist($photo_back_filename_4) ) && !( empty($photo_back_filename_4) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$photo_back_filename_4</i> has not been uploaded<br />\n";
				$log_error .= "$photo_back_filename_4 not uploaded; ";
			}
			if( !( does_image_exist($die_photo_filename_1) ) && !( empty($die_photo_filename_1) ) ){
				$html_code .= "&nbsp;&nbsp;&nbsp;&nbsp;Image: <i>$die_photo_filename_1</i> has not been uploaded<br />\n";
				$log_error .= "$die_photo_filename_1 not uploaded; ";
			}

			log_it("Edit Chip Error: manuf=$manuf, part=$part; $log_error");		

			$html_code .= display_add_edit_chip_page($manuf, $part, "edit");

		}
	}
	return $html_code;
}










/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////   Main Code
////
////


$html_code_g = '';
$html_title_g = 'cpu-db.info - Login page';
$html_keywords_g = 'CPU, MCU, DSP, BSP, database, login';
$script_name_g = 'index.php'; //#$ENV{'SCRIPT_NAME'};



$html_code_g .= display_header();

$html_code_g .= display_add_edit_main_page();
// $html_code_g .= display_login_page2();
$html_code_g .= print_input_vars();
$html_code_g .= display_footer();



echo $html_code_g;	

// add_chip_to_db();

// edit_chip_info()

// print_input_vars();
mysql_close($db_handle);
?>
</body>
</html>
