
<?php

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////    
////    File Description: generate the html for pages
////   
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////





///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
////
////   Other
////



function display_chip_photo_thumb($filename, $creator, $source, $license, $comments, $type, $main) {

	$text = "";

	$type_text = '';
	if( $type === "front" ){
		$type_text = "\t\t\t\t\tChip Photo";
	}elseif( $type === "back" ){
		$type_text = "\t\t\t\t\tChip Photo<br />\t\t\t\t\t(bottom)";
	}elseif( $type === "die" ){
		$type_text = "\t\t\t\t\tDie photo";
	}

	if( empty($filename) ){
		if( $main == 0 ){
			$text .= "						<td></td>\n";
		}else{
			$text .=  <<<Endhtml
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<p style="font-size: 16px;">
							$type_text<br />
							</p><p style="font-size: 12px;">
							is unavailable.<br /><br />
							If you have one, please <a href="$script_name_g?page=upload">upload</a> one.
							</p>
						</div>
					</td>
Endhtml;
		}
	}else{
		$source_text = '';
		$copyright_text = '';
		$comment_text = '';
		if( $source === '' ){
			$source_text = '';
		}else{
			$source_text = "Source: $source <br />";
			$source_text = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $source_text) ;
		}
		if( $creator === '' ){
			$creator_text = '';
		}else{
			$creator_text = "Creator: $creator<br />";
		}
		if( $license === '' ){
			$copyright_text = '';
		}else{
			$copyright_text = "Licence: $license <br />";
			#$copyright_text = fix_license_text($copyright_text);	
		}
		if( $comments === '' ){
			$comment_text = '';
		}else{
			$comment_text = "Comments: $comments <br />";
		}
		$text .=  <<<Endhtml
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<img src="http://cpu-db.info/images/photos/sm/
Endhtml;
		$text .= $filename;
		$text .= '_sm.jpg" width="300" />';
		$text .=  <<<Endhtml

						</div>
						<div>
							<p style="font-size: 12px;">
							$creator_text
							$source_text
							$copyright_text
							$comment_text
							</p>
						</div>
					</td>
Endhtml;
	}

	return $text;
}




////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/////
/////    Pages
/////




function display_single_chip_info_g($manuf, $part) { // page=c
	global $html_title_g, $html_keywords_g;
	// $manuf = $_[0];
	// $part = $_[1];

	$html_title_g = "cpu-db.info - $manuf $part";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf, $part";

	$ref_warning = '';
	$missing_info_level=0;
	$missing_info_message = '';

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
	$bus_comments = $chip["bus_comments"]; //new
	$frequency_ext = $chip["frequency_ext"]; //new
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
	$i_o_compatibillity = $chip["i_o_compatibillity"]; //new
	$power_min = $chip["power_min"];
	$power_typ = $chip["power_typ"];
	$power_max = $chip["power_max"];
	$power_thermal_design = $chip["power_thermal_design"];
	$temperature_range = $chip["temperature_range"];
	$temperature_grade = $chip["temperature_grade"]; //new
	$low_power_features = $chip["low_power_features"];
	$instruction_set = $chip["instruction_set"];
	$instruction_set_extensions = $chip["instruction_set_extensions"];
	$additional_instructions = $chip["additional_instructions"];
	$computer_architecture = $chip["computer_architecture"];
	$isa = $chip["isa"];
	$fpu = $chip["fpu"];
	$on_chip_peripherals = $chip["on_chip_peripherals"];
	$features = $chip["features"];
	$production_type = $chip["production_type"]; //new
	$clone = $chip["clone"]; //new
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

	$photo_front_filename_1 = $chip["photo_front_filename_1"]; //new
	$photo_front_creator_1 = $chip["photo_front_creator_1"]; //new
	$photo_front_source_1= 	 $chip["photo_front_source_1"]; //new
	$photo_front_copyright_1= $chip["photo_front_copyright_1"]; //new
	$photo_front_comment_1 =  $chip["photo_front_comment_1"]; //new

	$photo_back_filename_1 =  $chip["photo_back_filename_1"]; //new
	$photo_back_creator_1 =  $chip["photo_back_creator_1"]; //new
	$photo_back_source_1= 	 $chip["photo_back_source_1"]; //new
	$photo_back_copyright_1 = $chip["photo_back_copyright_1"]; //new
	$photo_back_comment_1 = 	 $chip["photo_back_comment_1"]; //new

	$photo_front_filename_2 =$chip["photo_front_filename_2"]; //new
	$photo_front_creator_2 =$chip["photo_front_creator_2"]; //new
	$photo_front_source_2=	$chip["photo_front_source_2"]; //new
	$photo_front_copyright_2=$chip["photo_front_copyright_2"]; //new
	$photo_front_comment_2 = $chip["photo_front_comment_2"]; //new

	$photo_back_filename_2 = $chip["photo_back_filename_2"]; //new
	$photo_back_creator_2 = $chip["photo_back_creator_2"]; //new
	$photo_back_source_2=	$chip["photo_back_source_2"]; //new
	$photo_back_copyright_2 =$chip["photo_back_copyright_2"]; //new
	$photo_back_comment_2 = 	$chip["photo_back_comment_2"]; //new

	$photo_front_filename_3 =$chip["photo_front_filename_3"]; //new
	$photo_front_creator_3 =$chip["photo_front_creator_3"]; //new
	$photo_front_source_3=	$chip["photo_front_source_3"]; //new
	$photo_front_copyright_3=$chip["photo_front_copyright_3"]; //new
	$photo_front_comment_3 = $chip["photo_front_comment_3"]; //new

	$photo_back_filename_3 = $chip["photo_back_filename_3"]; //new
	$photo_back_creator_3 = $chip["photo_back_creator_3"]; //new
	$photo_back_source_3=	$chip["photo_back_source_3"]; //new
	$photo_back_copyright_3 =$chip["photo_back_copyright_3"]; //new
	$photo_back_comment_3 = 	$chip["photo_back_comment_3"]; //new

	$photo_front_filename_4 =$chip["photo_front_filename_4"]; //new
	$photo_front_creator_4 =$chip["photo_front_creator_4"]; //new
	$photo_front_source_4=	$chip["photo_front_source_4"]; //new
	$photo_front_copyright_4=$chip["photo_front_copyright_4"]; //new
	$photo_front_comment_4 = $chip["photo_front_comment_4"]; //new

	$photo_back_filename_4 = $chip["photo_back_filename_4"]; //new
	$photo_back_creator_4 = $chip["photo_back_creator_4"]; //new
	$photo_back_source_4=	$chip["photo_back_source_4"]; //new
	$photo_back_copyright_4 =$chip["photo_back_copyright_4"]; //new
	$photo_back_comment_4 = 	$chip["photo_back_comment_4"]; //new

	$die_photo_filename_1 = 	$chip["die_photo_filename_1"]; //new
	$die_photo_creator_1 = 	$chip["die_photo_creator_1"]; //new
	$die_photo_source_1 =	$chip["die_photo_source_1"]; //new
	$die_photo_copyright_1 = $chip["die_photo_copyright_1"]; //new
	$die_photo_comment_1  = 	$chip["die_photo_comment_1"]; //new
	

	if( $family === '' ){
		$family='?';
		$missing_info_level++;
	}
	if( $alternative_label_1 === '' ){
		$alternative_label_1='?';
	}
	if( $alternative_label_2 === '' ){
		$alternative_label_2='?';
	}
	if( $alternative_label_3 === '' ){
		$alternative_label_3='?';
	}
	if( $alternative_label_4 === '' ){
		$alternative_label_4='?';
	}
	if( $alternative_label_5 === '' ){
		$alternative_label_5='?';
	}
	if( $alternative_label_6 === '' ){
		$alternative_label_6='?';
	}
	if( $chip_type === '' ){
		$chip_type='?';
		$missing_info_level++;
	}
	if( $sub_family === '' ){
		$sub_family_text='';
	}else{
		$sub_family_text="</tr><tr>\n\t\t\t<td class='table_param'>Sub-family:</td>\n\t\t\t\t<td class='table_value'>$sub_family</td>";
	}
	if( $model_number === '' ){
		$model_number_text='';
	}else{
		$model_number_text="</tr><tr>\n\t\t\t<td class='table_param'>Model Number:</td>\n\t\t\t\t<td class='table_value'>$model_number</td>";
	}
	if( $core === '' ){
		$core='?';
	}
	if( $core_designer === '' ){
		$core_designer='?';
	}
	if( $microarchitecture === '' ){
		$microarchitecture='?';
	}
	if( $threads === '' ){
		$threads_text = '';
	}else{
		$threads_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Threads:</td>\n\t\t\t\t\t<td class='table_value'>$threads</td>\n\t\t\t\t</tr>";
	}
	if( $cpuid === '' ){
		$cpuid='?';
	}
	if( $core_count === '' ){
		$core_count='?';
	}
	if( $pipeline === '' ){
		$pipeline='?';
	}
	if( $multiprocessing === '' ){
		$multiprocessing='?';
	}
	if( $architecture === '' ){
		$architecture='?';
		$missing_info_level++;
	}
	if( $data_bus_ext === '' ){
		$data_bus_ext='?';
	}
	if( $address_bus === '' ){
		$address_bus='?';
	}
	if( $frequency_max_typ === '' ){
		$frequency_max_typ='?';
		$missing_info_level++;
	}
	if( $actual_bus_frequency === '' ){
		$actual_bus_frequency='?';
	}
	if( $effective_bus_frequency === '' ){
		$effective_bus_frequency='?';
	}
	if( $bus_bandwidth === '' ){
		$bus_bandwidth='?';
	}
	if( $clock_multiplier === '' ){
		$clock_multiplier='?';
	}
	if( $core_stepping === '' ){
		$core_stepping='?';
	}
	if( $l1_data_cache === '' ){
		$l1_data_cache='?';
	}
	if( $l1_data_associativity === '' ){
		$l1_data_associativity='?';
	}
	if( $l1_instruction_cache === '' ){
		$l1_instruction_cache='?';
	}
	if( $l1_instruction_associativity === '' ){
		$l1_instruction_associativity='?';
	}
	if( $l1_unified_cache === '' ){
		$l1_unified_cache='?';
	}
	if( $l1_unified_associativity === '' ){
		$l1_unified_associativity='?';
	}
	if( $l2_cache === '' ){
		$l2_cache='?';
	}
	if( $l2_associativity === '' ){
		$l2_associativity='?';
	}
	if( $l3_cache === '' ){
		$l3_cache='?';
	}
	if( $l3_associativity === '' ){
		$l3_associativity='?';
	}
	if( $boot_rom === '' ){
		$boot_rom='?';
	}
	if( $rom_internal === '' ){
		$rom_internal='?';
	}
	if( $rom_type === '' ){
		$rom_type='?';
	}
	if( $ram_internal === '' ){
		$ram_internal='?';
	}
	if( $ram_max === '' ){
		$ram_max='?';
	}
	if( $ram_type === '' ){
		$ram_type='?';
	}
	if( $virtual_memory_max === '' ){
		$virtual_memory_max='?';
	}
	if( $package === '' ){
		$package='?';
		$missing_info_level++;
	}
	if( $package_size === '' ){
		$package_size='?';
	}
	if( $package_weight === '' ){
		$package_weight='?';
	}else{
		// $package_weight =~ s/g$/ g/;
	}
	if( $socket === '' ){
		$socket='?';
	}
	if( $transistor_count === '' ){
		$transistor_count='?';
	}
	if( $process_size === '' ){
		$process_size='?';
	}
	if( $metal_layers === '' ){
		$metal_layers='?';
	}
	if( $metal_type === '' ){
		$metal_type='?';
	}
	if( $process_technology === '' ){
		$process_technology='?';
	}
	if( $die_size === '' ){
		$die_size='?';
	}
	if( $vcc_core_range === '' ){
		$vcc_core_range='?';
	}
	if( $vcc_core_typ === '' ){
		$vcc_core_typ='?';
		$missing_info_level++;
	}
	if( $vcc_secondary === '' ){
		$vcc_secondary='?';
	}
	if( $vcc_tertiary === '' ){
		$vcc_tertiary='?';
	}
	if( $vcc_i_o === '' ){
		$vcc_i_o='?';
	}
	if( $power_min === '' ){
		$power_min='?';
	}
	if( $power_typ === '' ){
		$power_typ='?';
	}
	if( $power_max === '' ){
		$power_max='?';
	}
	if( $power_thermal_design === '' ){
		$power_thermal_design='?';
	}
	if( $temperature_range === '' ){
		$temperature_range='?';
	}
	if( $low_power_features === '' ){
		$low_power_features='?';
	}
	if( $instruction_set === '' ){
		$instruction_set='?';
	}
	if( $instruction_set_extensions === '' ){
		$instruction_set_extensions='?';
	}
	if( $additional_instructions === '' ){
		$additional_instructions='?';
	}
	if( $computer_architecture === '' ){
		$computer_architecture='?';
	}
	if( $isa === '' ){
		$isa='?';
	}
	if( $fpu === '' ){
		$fpu='?';
	}
	if( $on_chip_peripherals === '' ){
		$on_chip_peripherals='?';
	}
	if( $release_date === '' ){
		$release_date='?';
	}
	if( $initial_price === '' ){
		$initial_price='?';
	}
	if( $applications === '' ){
		$applications='?';
	}

	$i_o_compatibillity_text='';
	if( $i_o_compatibillity === '' ){
		$i_o_compatibillity_text='';
	}else{
		$i_o_compatibillity_text = "<tr>\n\t\t\t\t\t<td class='table_param'>I/O compatability:</td>\n\t\t\t\t\t<td class='table_value'>$i_o_compatibillity</td>\n\t\t\t\t</tr>";
	}

	$production_type_text ='';
	if( $production_type === '' ){
		if( preg_match("/[Ss]ample/", $part) ){
			$production_type_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Production type:</td>\n\t\t\t\t\t<td class='table_value'>Sample</td>\n\t\t\t\t</tr>";
		}else{
			$production_type_text ='';
		}
	}else{
		$production_type_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Production type:</td>\n\t\t\t\t\t<td class='table_value'>$production_type</td>\n\t\t\t\t</tr>";
	}

	$clone_text = '';
	if( $clone === '' ){
		$clone_text = '';
	}else{
		$clone_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Clone:</td>\n\t\t\t\t\t<td class='table_value'>$clone</td>\n\t\t\t\t</tr>";
	}

	$comments_text = '';
	if( $comments === '' ){
		$comments_text = '';
	}else{
		$comments_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Comments:</td>\n\t\t\t\t\t<td class='table_value'>$comments</td>\n\t\t\t\t</tr>";
	}

	$military_spec_text = '';
	if( $military_spec === '' ){
		$military_spec_text = '';
	}else{
		$military_spec_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Millitary specs:</td>\n\t\t\t\t\t<td class='table_value'>$military_spec</td>\n\t\t\t\t</tr>";
	}

	$features_text='';
	if( $features === '' ){
		$features_text='';
	}else{
		$features_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Features:</td>\n\t\t\t\t\t<td class='table_value'>$features</td>\n\t\t\t\t</tr>";
	}



	// Photo
	// $photo_front_filename_1 = 'ic_photo--top--Zilog--Z0800210PSC--(Z8000-CPU).png';
	// $photo_front_source_1 = 'CPU Grave Yard';
	// $photo_front_copyright_1 = 'Creative Commons BY-SA 3.0';
	// $photo_front_comments_1 = '';
	// $html_code .= " /$photo_front_filename_1/ $photo_front_creator_1 $photo_front_creator_1/$photo_front_source_1/$photo_front_copyright_1/$photo_front_comment_1<br /> - $photo_back_filename_1/$photo_back_creator_1/$photo_back_source_1/$photo_back_copyright_1/$photo_back_comment_1<br />- $die_photo_filename_1/$die_photo_creator_1/$die_photo_source_1/$die_photo_copyright_1/$die_photo_comment_1  ";
	
	$ic_photo_front_text = display_chip_photo_thumb($photo_front_filename_1, $photo_front_creator_1, $photo_front_source_1, $photo_front_copyright_1, $photo_front_comment_1, "front", "1");

		// $ic_photo_front_text = display_chip_photo_thumb( 0, 1, 2, 3, 4, 5, 6, 7, 8);

	$ic_photo_back_text = display_chip_photo_thumb($photo_back_filename_1, $photo_back_creator_1, $photo_back_source_1, $photo_back_copyright_1, $photo_back_comment_1, "back", "0");

	$ic_photo_die_text = display_chip_photo_thumb($die_photo_filename_1, $die_photo_creator_1, $die_photo_source_1, $die_photo_copyright_1, $die_photo_comment_1, "die", "1");

	// $ic_photo_front_text = display_chip_photo_thumb($photo_front_filename_1, $photo_front_creator_1, $photo_front_source_1, $photo_front_copyright_1, $photo_front_comment_1, "front", "1");

	// $ic_photo_front_text = display_chip_photo_thumb($photo_front_filename_1, $photo_front_creator_1, $photo_front_source_1, $photo_front_copyright_1, $photo_front_comment_1, "front", "1");

	// $ic_photo_front_text = display_chip_photo_thumb($photo_front_filename_1, $photo_front_creator_1, $photo_front_source_1, $photo_front_copyright_1, $photo_front_comment_1, "front", "1");




	//###############
	// Polishing
	//
	
	
	// Voltage
	if( preg_match("/4.75-5.25/", $vcc_core_range) || preg_match("/4.75 - 5.25/", $vcc_core_range) || preg_match("/4.75 to 5.25/", $vcc_core_range) || preg_match("/5V +/- 5%/", $vcc_core_range) ){
		$vcc_core_range = "5 V &#177; 5%";
	}elseif( preg_match("/4.5-5.5/", $vcc_core_range) || preg_match("/4.5 - 5.5/", $vcc_core_range) ||  preg_match("/4.5 to 5.5/", $vcc_core_range) || preg_match("/5V +/- 10%/", $vcc_core_range) ){
		$vcc_core_range = "5 V &#177; 10%";
	}elseif( preg_match("/3.135-3.465/", $vcc_core_range) || preg_match("/3.135 - 3.465/", $vcc_core_range) || preg_match("/3.135 to 3.465/", $vcc_core_range) || preg_match("/3.3V +/- 5%/", $vcc_core_range) ){
		$vcc_core_range = "3.3 V &#177; 5%";
	}

	$vcc_core_range = preg_replace('/([0-9])-([0-9])/', '$1 to $2', $vcc_core_range );
	$vcc_core_range = preg_replace('/([0-9]) - ([0-9])/', '$1 to $2', $vcc_core_range );
	$vcc_core_range = preg_replace('/([0-9]) – ([0-9])/', '$1 to $2', $vcc_core_range );
	$vcc_core_range = preg_replace('/([0-9])–([0-9])/', '$1 to $2', $vcc_core_range);
	$vcc_core_range = preg_replace('/([0-9])V$/', '$1 V/',	$vcc_core_range	);
	$vcc_core_typ = preg_replace('/([0-9])V$/', '$1 V', $vcc_core_typ );
	$vcc_secondary  = preg_replace('/([0-9])V$/', '$1 V', $vcc_secondary );
	$vcc_tertiary  = preg_replace('/([0-9])V$/', '$1 V', $vcc_tertiary  );
	$vcc_i_o   = preg_replace('/([0-9])V$/', '$1 V', $vcc_i_o  );

	//Subsititution
	$temperature_range = preg_replace('/â€“/', '-', $temperature_range );
	$instruction_set = preg_replace('/X86/', 'x86', $instruction_set );
	$clock_multiplier = preg_replace('/([0-9])$/', '$1x', $clock_multiplier );

	// Cache
	$l1_data_cache  = preg_replace('/Ext /', 'External, ', $l1_data_cache  );
	$l1_instruction_cache  = preg_replace('/Ext /', 'External, ', $l1_instruction_cache  );
	$l1_unified_cache  = preg_replace('/Ext /', 'External, ', $l1_unified_cache  );
	$l2_cache  = preg_replace('/Ext /', 'External, ', $l2_cache  );
	$l3_cache  = preg_replace('/Ext /', 'External, ', $l3_cache  );


	//Die
	$package_size	= preg_replace('/mm\^2/', ' mm<sup>2</sup>', $package_size	);
	$package_size	= preg_replace('/mm\^3/', ' mm<sup>3</sup>', $package_size	);
	$package_size	= preg_replace('/cm\^2/', ' cm<sup>2</sup>', $package_size	);
	$package_size	= preg_replace('/cm\^3/', ' cm<sup>3</sup>', $package_size	);
	$package_size	= preg_replace('/in\^2/', ' in<sup>2</sup>', $package_size	);
	$package_size	= preg_replace('/in\^3/', ' in<sup>3</sup>', $package_size	);
	$package_size	= preg_replace('/\s\s+/', ' ', $package_size	);
	$die_size 		= preg_replace('/mm\^2/', ' mm<sup>2</sup>', $die_size);
	$die_size 		= preg_replace('/cm\^2/', ' cm<sup>2</sup>', $die_size);
	$die_size 		= preg_replace('/\s\s+/', ' ', $die_size );

	$transistor_count = preg_replace('/([0-9])M$/', '$1 million', $transistor_count  );
	$transistor_count = preg_replace('/([0-9])k$/', '$1 thousand', $transistor_count );


	// Speed MHz's
	$frequency_min = preg_replace('/MHz/', ' MHz', $frequency_min );
	$frequency_min = preg_replace('/GHz/', ' GHz', $frequency_min );
	$frequency_min = preg_replace('/kHz/', ' kHz', $frequency_min );
	$frequency_min = preg_replace('/\s\s+/', ' ', $frequency_min );
	$frequency_ext = preg_replace('/MHz/', ' MHz', $frequency_ext );
	$frequency_ext = preg_replace('/GHz/', ' GHz', $frequency_ext );
	$frequency_ext = preg_replace('/kHz/', ' kHz', $frequency_ext );
	$frequency_ext = preg_replace('/\s\s+/', ' ',	$frequency_ext );
	$frequency_max_typ = preg_replace('/MHz/', ' MHz', $frequency_max_typ );
	$frequency_max_typ = preg_replace('/GHz/', ' GHz', $frequency_max_typ );
	$frequency_max_typ = preg_replace('/kHz/', ' kHz', $frequency_max_typ );
	$frequency_max_typ = preg_replace('/\s\s+/', ' ', $frequency_max_typ );
	$actual_bus_frequency = preg_replace('/MHz/', ' MHz', $actual_bus_frequency );
	$actual_bus_frequency = preg_replace('/GHz/', ' GHz', $actual_bus_frequency );
	$actual_bus_frequency = preg_replace('/kHz/', ' kHz', $actual_bus_frequency );
	$actual_bus_frequency = preg_replace('/\s\s+/', ' ', $actual_bus_frequency );
	$effective_bus_frequency = preg_replace('/MHz/', ' MHz', $effective_bus_frequency );
	$effective_bus_frequency = preg_replace('/GHz/', ' GHz', $effective_bus_frequency );
	$effective_bus_frequency = preg_replace('/kHz/', ' kHz', $effective_bus_frequency );
	$effective_bus_frequency = preg_replace('/\s\s+/', ' ',  $effective_bus_frequency );
	$bus_bandwidth = preg_replace('/([0-9])([A-Z])iB\/s$/', '$1 $2iB\/s', $bus_bandwidth );



	$frequency_ext_text = '';
	if( !($frequency_ext === '') ){
		$frequency_ext_text="<tr>\n\t\t\t\t\t<td class='table_param'>Frequency (ext):</td>\n\t\t\t\t\t<td class='table_value'>$frequency_ext</td>\n\t\t\t\t</tr>";
	}else{
		$frequency_ext_text="";
	}

	$bus_comments_text = '';
	if( !($bus_comments === '') ){
		$bus_comments_text="<tr>\n\t\t\t\t\t<td class='table_param'>Bus comments:</td>\n\t\t\t\t\t<td class='table_value'>$bus_comments</td>\n\t\t\t\t</tr>";
	}else{
		$bus_comments_text="";
	}

	$effective_bus_frequency_text = '';
	if( !($effective_bus_frequency === '?') ){
		$effective_bus_frequency_text="<tr>\n\t\t\t\t\t<td class='table_param'>Bus frequency, effective:</td>\n\t\t\t\t\t<td class='table_value'>$effective_bus_frequency</td>\n\t\t\t\t</tr>";
	}else{
		$effective_bus_frequency_text="";
	}

	$vcc_secondary_text = '';
	if( !($vcc_secondary === '?') ){
		$vcc_secondary_text="<tr>\n\t\t\t\t\t<td class='table_param'>Secondary voltage:</td>\n\t\t\t\t\t<td class='table_value'>$vcc_secondary</td>\n\t\t\t\t</tr>";
	}else{
		$vcc_secondary_text="";
	}

	$vcc_tertiary_text = '';
	if( !($vcc_tertiary === '?') ){
		$vcc_tertiary_text="<tr>\n\t\t\t\t\t<td class='table_param'>Tersiary voltage:</td>\n\t\t\t\t\t<td class='table_value'>$vcc_tertiary</td>\n\t\t\t\t</tr>";
	}else{
		$vcc_tertiary_text="";
	}

	$instruction_set_extensions_text = '';
	if( !($instruction_set_extensions === '?') ){
		$instruction_set_extensions_text="<tr>\n\t\t\t\t\t<td class='table_param'>Instruction set extensions:</td>\n\t\t\t\t\t<td class='table_value'>$instruction_set_extensions</td>\n\t\t\t\t</tr>";
	}else{
		$instruction_set_extensions_text="";
	}

	$additional_instructions_text = '';
	if( !($additional_instructions === '?') ){
		$additional_instructions_text="<tr>\n\t\t\t\t\t<td class='table_param'>Additional instructions:</td>\n\t\t\t\t\t<td class='table_value'>$additional_instructions</td>\n\t\t\t\t</tr>";
	}else{
		$additional_instructions_text="";
	}

	$metal_layers_text = '';
	if( !($metal_layers === '?') ){
		$metal_layers_text="<tr>\n\t\t\t\t\t<td class='table_param'>Metal layers:</td>\n\t\t\t\t\t<td class='table_value'>$metal_layers</td>\n\t\t\t\t</tr>";
	}else{
		$metal_layers_text="";
	}

	$metal_type_text = '';
	if( !($metal_type === '?') ){
		$metal_type_text="<tr>\n\t\t\t\t\t<td class='table_param'>Metal type:</td>\n\t\t\t\t\t<td class='table_value'>$metal_type</td>\n\t\t\t\t</tr>";
	}else{
		$metal_type_text="";
	}

	//Data
	$l1_data_cache  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $l1_data_cache );
	$l1_instruction_cache  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $l1_instruction_cache );
	$l1_unified_cache  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $l1_unified_cache );
	$l2_cache  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $l2_cache );
	$l3_cache  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $l3_cache  );
	$rom_internal  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $rom_internal );
	$ram_internal = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $ram_internal );
	$ram_max = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $ram_max );
	$virtual_memory_max  = preg_replace('/([0-9])([A-Z])iB$/', '$1 $2iB', $virtual_memory_max );
	
	$l1_data_cache  = preg_replace('/([0-9])B$/', '$1 Bytes', $l1_data_cache );
	$l1_instruction_cache  = preg_replace('/([0-9])B$/', '$1 Bytes', $l1_instruction_cache  );
	$l1_unified_cache  = preg_replace('/([0-9])B$/', '$1 Bytes', $l1_unified_cache );
	$rom_internal  = preg_replace('/([0-9])B$/', '$1 Bytes', $rom_internal  );
	$ram_internal = preg_replace('/([0-9])B$/', '$1 Bytes', $ram_internal);
	$l1_data_cache  = preg_replace('/([0-9])b$/', '$1 Bits', $l1_data_cache );
	$l1_instruction_cache  = preg_replace('/([0-9])b$/', '$1 Bits', $l1_instruction_cache);
	$l1_unified_cache  = preg_replace('/([0-9])b$/', '$1 Bits', $l1_unified_cache  );
	$rom_internal  = preg_replace('/([0-9])b$/', '$1 Bits', $rom_internal  );
	$ram_internal = preg_replace('/([0-9])b$/', '$1 Bits', $ram_internal);


	// temp
	$temperature_range = preg_replace('/C/', ' C', $temperature_range );
	$temperature_range = preg_replace('/F/', ' F', $temperature_range );
	$temperature_range = preg_replace('/ - /', ' to ', $temperature_range );
	$temperature_range = preg_replace('/ – /', ' to ', $temperature_range );
	$temperature_range = preg_replace('/–/', ' to ', $temperature_range );
	$temperature_range = preg_replace('/0-/', '0 to ', $temperature_range );
	$temperature_range = preg_replace('/5-/', '5 to ', $temperature_range );
	$temperature_range = preg_replace('/  / /g', $temperature_range );
	

	if( $temperature_grade === '' ){
		if( $temperature_range === '0 to 70 C' ){
			$temperature_grade='Commercial';
		}elseif( $temperature_range === '-40 to 85 C' ){
			$temperature_grade='Industrial';
		}elseif( $temperature_range === '-55 to 125 C' ){
			$temperature_grade='Millitary';
		}else{
			$temperature_grade='?';
		}
	}

	// buses
	$architecture = preg_replace('/([0-9])$/', '$1-bit', $architecture);
	$data_bus_ext = preg_replace('/([0-9])$/', '$1-bit', $data_bus_ext );
	$address_bus = preg_replace('/([0-9])$/', '$1-bit', $address_bus );
	
	// power
	$power_min = preg_replace('/uW/', ' µW', $power_min );
	$power_min = preg_replace('/([a-z]?)W/', ' $1W', $power_min);
	$power_min = preg_replace('/\s\s+/', ' ', $power_min );

	$power_typ = preg_replace('/uW/', ' µW', $power_typ );
	$power_typ = preg_replace('/([a-z]?)W/', ' $1W', $power_typ );
	$power_typ = preg_replace('/\s\s+/', ' ', $power_typ );
	
	$power_max = preg_replace('/uW/', ' µW', $power_max );
	$power_max = preg_replace('/([a-z]?)W/', ' $1W', $power_max);
	$power_max = preg_replace('/\s\s+/', ' ', $power_max );

	$power_thermal_design = preg_replace('/uW/', ' µW', $power_thermal_design );
	$power_thermal_design = preg_replace('/([a-z]?)W/', ' $1W', $power_thermal_design);
	$power_thermal_design = preg_replace('/\s\s+/', ' ', $power_thermal_design );




	// Alternative labels
	if( $alternative_label_1 === '?' ){
		$alt_labels = '?';
	}elseif( $alternative_label_2 === '?' ){
		$alt_labels = "$alternative_label_1";
	}elseif( $alternative_label_3 === '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2";
	}elseif( $alternative_label_4 === '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label3";
	}elseif( $alternative_label_5 === '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4";
	}elseif( $alternative_label_6 === '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4, $alternative_label_5";
	}else{
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4, $alternative_label_5, $alternative_label_6";
	}
	if( $alt_labels === '?' ){
		$alt_labels='';
	}else{
		$alt_labels="</tr><tr>\n\t\t\t<td class='table_param'>Alternative Lables:</td>\n\t\t\t\t<td class='table_value'>$alt_labels</td>";
	}


	// References
	$reference_1 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_1);
	$reference_2 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_2);
	$reference_3 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_3);
	$reference_4 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_4);
	$reference_5 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_5);
	$reference_6 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_6);
	$reference_7 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_7);
	$reference_8 = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $reference_8);



	if( !( $reference_1 || $reference_2 || $reference_3 || $reference_4 || $reference_5 || $reference_6 || $reference_7 || $reference_8) ){
		$ref_warning = "<p class=\"warning_message\">This page has no references, if you have any please <a href=\"$script_name_g?page=contrib\">add one</a></p>";
		$refs = "$ref_warning";
	}elseif( $reference_1 ){
		$refs = "&oplus; $reference_1";
		if( $reference_2 ){
			$refs .= "\n<br />&oplus; $reference_2";
		}
		if( $reference_3 ){
			$refs .= "\n<br />&oplus; $reference_3";
		}
		if( $reference_4 ){
			$refs .= "\n<br />&oplus; $reference_4";
		}
		if( $reference_5 ){
			$refs .= "\n<br />&oplus; $reference_5";
		}
		if( $reference_6 ){
			$refs .= "\n<br />&oplus; $reference_6";
		}
		if( $reference_7 ){
			$refs .= "\n<br />&oplus; $reference_7";
		}
		if( $reference_8 ){
			$refs .= "\n<br />&oplus; $reference_8";
		}
	}


	// Cache display
	$CACHE_TEXT = '';

	$CACHE_TEXT .= <<<Endhtml
			<table width="100%">
Endhtml;
	if( $l1_data_cache === "none" && $l1_instruction_cache === "none" && $l1_unified_cache === "none" && $l2_cache === "none" && $l3_cache === "none"){
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>Cache:</td>
								<td class='table_value'>none</td>
							</tr>
Endhtml;
	}elseif( $l1_data_cache === "none" && $l1_instruction_cache === "none" && $l1_unified_cache === "none" ){
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L1 cache:</td>
								<td class='table_value'>none</td>
							</tr>
Endhtml;
	}else{
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L1 data cache:</td>
								<td class='table_value'>$l1_data_cache</td>
							</tr>
Endhtml;
		if( !($l1_data_cache === "none") ){
		$CACHE_TEXT .= <<<Endhtml
							<tr> 
					  			<td class='table_param'>L1 data cache specs</td>
								<td class='table_value'>$l1_data_associativity</td>
							</tr>
Endhtml;
		}
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L1 instruction cache:</td>
								<td class='table_value'>$l1_instruction_cache</td>
							</tr>
Endhtml;
		if( !($l1_instruction_cache === "none") ){
		$CACHE_TEXT .= <<<Endhtml
							<tr> 
					  			<td class='table_param'>L1 instruction cache specs:</td>
								<td class='table_value'>$l1_instruction_associativity</td>
							</tr>
Endhtml;
		}
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L1 unified cache:</td>
								<td class='table_value'>$l1_unified_cache</td>
							</tr>
Endhtml;
		if( !($l1_unified_cache === "none") ){
		$CACHE_TEXT .= <<<Endhtml
							<tr> 
					  			<td class='table_param'>L1 unified cache specs:</td>
								<td class='table_value'>$l1_unified_associativity</td>
							</tr>
Endhtml;
		}
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L2 cache:</td>
								<td class='table_value'>$l2_cache</td>
							</tr>
Endhtml;
		if( !($l2_cache === "none") ){
		$CACHE_TEXT .= <<<Endhtml
							<tr> 
					  			<td class='table_param'>L2 cache specs:</td>
								<td class='table_value'>$l2_associativity</td>
							</tr>
Endhtml;
		}
		$CACHE_TEXT .= <<<Endhtml
							<tr>
					  			<td class='table_param'>L3 cache:</td>
								<td class='table_value'>$l3_cache</td>
							</tr>
Endhtml;
		if( !($l3_cache === "none") ){
		$CACHE_TEXT .= <<<Endhtml
							<tr> 
					  			<td class='table_param'>L3 cache specs:</td>
								<td class='table_value'>$l3_associativity</td>
							</tr>
Endhtml;
		}
	}
	$CACHE_TEXT .= <<<Endhtml
		</table>
Endhtml;

	// Missing Info level
	if( $missing_info_level > 3 ){
		$missing_info_message = "\t<p class=\"warning_message\">This page is missing basic information about the chip, if you can fill in any details, please <a href=\"$script_name_g?page=contrib\">add them</a> with references</p>\n";
	}elseif( !($ref_warning === '') ){
		$missing_info_message = $ref_warning;
	}


	$html_code .= <<<Endhtml
	<h3><a href="$script_name_g?page=m&amp;manuf=$manuf">$manuf</a> - <a href="$script_name_g?page=f&amp;family=$family">$family</a></h3>
	
	<div class="body_content_indent">

	<h1>$manuf - $part</h1>
	
	$missing_info_message

	<table>
		<tr>
			<td>
	<table>
	  <tr>
	  <td colspan="2" width="700">
		<table width="100%">
			<tr>
				<td class='table_param'>Chip type:</td>
				<td class='table_value'>$chip_type</td>
			</tr><tr>
				<td class='table_param'>Family:</td>
				<td class='table_value'>$family</td>
			$sub_family_text
			$model_number_text
			$alt_labels_text
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
					<td class='table_param'>Core:</td>
					<td class='table_value'>$core</td>
				</tr>
				<tr>
					<td class='table_param'>Designer:</td>
					<td class='table_value'>$core_designer</td>
				</tr>
				<tr>
					<td class='table_param'>Number of Cores:</td>
					<td class='table_value'>$core_count</td>
				</tr>
				$threads_text
				<tr>
			  		<td class='table_param'>CPUID:</td>
					<td class='table_value'>$cpuid</td>
				</tr>
				<tr>
					<td class='table_param'>Core stepping:</td>
					<td class='table_value'>$core_stepping</td>
				</tr>
				<tr>
			  		<td class='table_param'>Pipeline:</td>
					<td class='table_value'>$pipeline</td>
				</tr>
				<tr>
					<td class='table_param'>Multiprocessing:</td>
					<td class='table_value'>$multiprocessing</td>
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
					<td class='table_value'>$architecture</td>
				</tr>
				<tr>
			  		<td class='table_param'>External data bus:</td>
					<td class='table_value'>$data_bus_ext</td>
				</tr>
				<tr>
			  		<td class='table_param'>Address bus:</td>
					<td class='table_value'>$address_bus</td>
				</tr>
				$bus_comments_text
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
				$frequency_min_text
				<tr>
		  			<td class='table_param_long'>Frequency:</td>
					<td class='table_value'>$frequency_max_typ</td>
				</tr>
				$frequency_ext_text
				<tr>
		  			<td class='table_param_long'>Clock multiplier:</td>
					<td class='table_value'>$clock_multiplier</td>
				</tr>
				<tr>
		  			<td class='table_param_long'>Bus frequency, actual:</td>
					<td class='table_value'>$actual_bus_frequency</td>
				</tr>
				$effective_bus_frequency_text
				<tr>
		  			<td class='table_param_long'>Bus bandwidth:</td>
					<td class='table_value'>$bus_bandwidth</td>
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
								<td class='table_value'>$ram_max</td>
							</tr>
							<tr>
					  			<td class='table_param'>RAM external type:</td>
								<td class='table_value'>$ram_type</td>
							</tr>
							<tr>
					  			<td class='table_param'>Internal RAM:</td>
								<td class='table_value'>$ram_internal</td>
							</tr>
							<tr>
					  			<td class='table_param'>Virtual memory:</td>
								<td class='table_value'>$virtual_memory_max</td>
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
								<td class='table_value'>$rom_internal</td>
							</tr>
							<tr>	
					  			<td class='table_param'>ROM type:</td>
								<td class='table_value'>$rom_type</td>
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
					<td class='table_td_blank'></td>
					<td>
						$CACHE_TEXT
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
					<td class='table_value'>$package</td>
				</tr>
				<tr>		
		  			<td class='table_param'>Socket:</td>
					<td class='table_value'>$socket</td>
				</tr>
				<tr>
		  			<td class='table_param'>Package size:</td>
					<td class='table_value'>$package_size</td>	
				</tr>
				<tr>
		  			<td class='table_param'>Package weight:</td>
					<td class='table_value'>$package_weight</td>
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
					<td class='table_value'>$vcc_core_typ</td>
				</tr>
				<tr>
		  			<td class='table_param'>Suppy voltage range:</td>
					<td class='table_value'>$vcc_core_range</td>
				</tr>
				<tr>	
		  			<td class='table_param'>I/O voltage:</td>
					<td class='table_value'>$vcc_i_o</td>
				</tr>
				$i_o_compatibillity_text	
				$vcc_secondary_text
				$vcc_tertiary_text
				<tr>
		  			<td class='table_param'>Power(min):</td>
					<td class='table_value'>$power_min</td>	
				</tr>
				<tr>
		  			<td class='table_param'>Power(typ):</td>
					<td class='table_value'>$power_typ</td>	
				</tr>
				<tr>
		  			<td class='table_param'>Power(max):</td>
					<td class='table_value'>$power_max </td>
				</tr>
				<tr>
		  			<td class='table_param'>Thermal Power:</td>
					<td class='table_value'>$power_thermal_design</td>
				</tr>
				<tr>	
		  			<td class='table_param'>Temp range:</td>
					<td class='table_value'>$temperature_range</td>
				</tr>
				<tr>	
		  			<td class='table_param'>Temp grade:</td>
					<td class='table_value'>$temperature_grade</td>
				</tr>
				<tr>
		  			<td class='table_param'>Low power features:</td>
					<td class='table_value'>$low_power_features</td>
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
					<td class='table_value'>$isa </td>
				</tr>
				<tr>
		  			<td class='table_param'>Instruction set:</td>
					<td class='table_value'>$instruction_set</td>	
				</tr>
				$instruction_set_extensions_text
				$additional_instructions_text
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
					<td class='table_value'>$process_technology	</td>
				</tr>
				$metal_layers_text
				$metal_type_text
				<tr>
		  			<td class='table_param'>Transistors:</td>
					<td class='table_value'>$transistor_count</td>
				</tr>
				<tr>	
		  			<td class='table_param'>Die Size:</td>
					<td class='table_value'>$die_size </td>
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
					<td class='table_value'>$fpu</td>
				</tr>
				<tr>
		  			<td class='table_param'>On chip peripherals:</td>
					<td class='table_value'>$on_chip_peripherals</td>
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
					<td class='table_value'>$release_date </td>
				</tr>
				<tr>
		  			<td class='table_param'>Introduction price:</td>
					<td class='table_value'>$initial_price</td>
				</tr>
				$production_type_text
				$clone_text
				<tr>
		  			<td class='table_param'>Typical application:</td>
					<td class='table_value'>$applications</td>
				</tr>
				$military_spec_text
				$features_text
				$comments_text
			</table>
		</td>
	</tr>
	</table>
			</td>
			<td style="vertical-align:top;">
				<table>
					<tr>
						<td>
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_preferred_1"></a>
				<a class="addthis_button_preferred_2"></a>
				<a class="addthis_button_preferred_3"></a>
				<a class="addthis_button_preferred_4"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js//pubid=xa-51560129043ae9a8"></script>
				<!-- AddThis Button END -->
						</td>
					</tr><tr>
						$ic_photo_front_text
					</tr><tr>
						$ic_photo_back_text
					</tr><tr>
						$ic_photo_die_text
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table>
	  <tr>
	  	<td colspan="2" class='table_sec'>References</td>
	  </tr>
	  <tr>
		<td class='table_td_blank'></td>
		<td>
			<table width="100%">
				<tr>
		  			<td class='table_value'>$refs</td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>	

	<table>
		<tr>
			<td>
				$ic_photo_front_2_text
			</td><td>
				$ic_photo_back_2_text
			</td>
		</tr><tr>
			<td>
				$ic_photo_front_3_text
			</td><td>
				$ic_photo_back_3_text
			</td>
		</tr><tr>
			<td>
				$ic_photo_front_4_text
			</td><td>
				$ic_photo_back_4_text
			</td>
		</tr>
	</table>

	
	
	</div>

Endhtml;

	
	// fix odd chars
	// $html_code =~ s/Î¼/µ/g;
	// $html_code =~ s/â€œ/\"/g;
	// $html_code =~ s/â€/\"/g;
	// $html_code =~ s/â€“/-/g;
	// $html_code =~ s/â€™/\'/g;
	// $html_code =~ s/â€¦/.../g;
	// $html_code =~ s/–/-/g;
	// $html_code =~ s/\“/\"/g;
	// $html_code =~ s/\”/\"/g;


	return $html_code;
}








function display_chips_page() { // page=cat&type=chips
	global $html_title_g, $html_keywords_g;
	$html_code = "";
	
	$html_title_g = 'cpu-db.info - Chip List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database';

	$hashish = get_manuf_type_family_hash();
	$text_tmp = '';



	$table_results = get_manuf_type_family_hash();

	// print_array($table_results);
	foreach ( array_keys($table_results) as $key1 ){
	  $html_code .= "<h1>$key1</h1>\n";

	  foreach ( array_keys($table_results[$key1]) as $key2 ){
		if( $key2 === 'CPU' || $key2 === 'BSP' || $key2 === 'MCU' || $key2 === 'DSP' || $key2 === 'FPU' ){ 
			$html_code .= "<h3>$key2</h3>\n";
			foreach ( array_keys($table_results[$key1][$key2]) as $key3 ){
				// echo ">> $key3 <br />\n";
				$html_code .= "<a href=\"$script_name_g?page=mf&amp;manuf=$key1&amp;family=$key3\">$key3</a>, ";
			}
			$html_code = preg_replace("/, $/","<br /><br />\n",$html_code);
		}
	  }
	}
	// for my $k1 ( sort keys %hashish ) {
		// if( $k1 ne '' ){
			// $html_code .= "<h3>$k1</h3>\n<div style=\"padding-left: 10px;\">";
			// for my $k2 ( sort keys $hashish{ $k1 } ) {
				// if( $k2 eq 'CPU' || $k2 eq 'BSP' || $k2 eq 'MCU' || $k2 eq 'DSP' ){ 
					// $html_code .= "$k2: ";
					// $text_tmp = '';
					// for my $k3 ( sort keys $hashish{ $k1 }{ $k2 } ) {
						// if( $k3 ne '' ){
							// $text_tmp .= "<a href=\"$script_name_g?page=mf&amp;manuf=$k1&amp;family=$k3\">$k3</a>, ";
						// }
					// }
					// $text_tmp =~ s/, $//;
					// $html_code .= "$text_tmp";
					// $html_code .= "<br />\n";
				// }
			// }
		// $html_code .= "</div><br />\n";
		// }
	// }

	return $html_code;
}






function display_manuf_family_page($manuf, $family) { // page=mf
	global $html_title_g, $html_keywords_g;

	$html_title_g = "cpu-db.info - $manuf - $family";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf, $family";
	
	$chip_list = array();

	$chip_list = get_manuf_family_chip_list($manuf, $family);
	
	$html_code = "<h1>$manuf - $family</h1>\n";
	$html_code .= <<<Endhtml
	<table>
		<tr>
Endhtml;
	$html_code .=  "\t\t\t<td style=\"width: 175px;\"><b>Part number</b></td><td style=\"width: 75px;\"><b>Type</b></td><td style=\"width: 100px;\"><b>Speed</b></td>\n";
	$html_code .=  "\t\t</tr><tr>\n";


	foreach ( $chip_list as $row ){
		$html_code .=  "\t\t\t<td><a href=\"$script_name_g?page=c&amp;manuf=$manuf&amp;part=$row[0]\">$row[0]</a></td><td>$row[1]</td><td>$row[2]</td>\n";
		$html_code .=  "\t\t</tr><tr>\n";
	}
	// foreach $row ( @{ $chip_list } ) {
		// $html_code .=  "\t\t\t<td><a href=\"$script_name_g?page=c&amp;manuf=$manuf&amp;part=$row->[0]\">$row->[0]</a></td><td>$row->[1]</td><td>$row->[2]</td>\n";
		// $html_code .=  "\t\t</tr><tr>\n";

	// }

	$html_code .= <<<Endhtml
		</tr>
	</table>
Endhtml;
	return $html_code;
}




function display_family_page( $family ) { // page=f&family=$family
	global $html_title_g, $html_keywords_g;

	$html_code = '';
	$manuf_list = array();

	$html_title_g = "cpu-db.info - $family Family";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $family, family";

	$manuf_list = get_manufs_of_family_list($family);

	$html_code .= "	<h1>$family</h1>\n";
	$html_code .= "	<h3>List of manufacturers</h3>\n";

	foreach ($manuf_list as $manuf){
		$html_code .= "\t\t<a href=\"$script_name_g?page=mf&amp;manuf=$manuf&amp;family=$family\">$manuf - $family</a> <br />\n";
	}
	// foreach my $manuf (sort @manuf_list){
		// $html_code .= "\t\t<a href=\"$script_name_g?page=mf&amp;manuf=$manuf&amp;family=$family\">$manuf - $family</a> <br />\n";
	// }

	return $html_code;
}




function display_manuf_list() { // page=cat&type=manuf
	global $html_title_g, $html_keywords_g;

	$html_code = '';
	$manuf_array = array();

	$manuf_array = get_manuf_list_alphabetical();

	// print_r($manuf_array);

	$html_title_g = 'cpu-db.info - Manufacture List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, manufacturer';
	
	$html_code .= "\t<h1>Manufacturer list</h1>\n";

	$alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	$text_tmp = '';
	$set = 0;

	foreach ($manuf_array as $manuf) {
		// echo "$manuf <br />\n";
		if( preg_match( '/^[0-9]/', $manuf) ) {
			$text_tmp .= "\t<a href=\"$script_name_g?page=m&amp;manuf=$manuf\">$manuf</a> <br />\n";
			$set = 1;
		}
	}
	if( $set == 1 ){
		$html_code .= "\t<b>0-9:</b><br />\n";
		$html_code .= $text_tmp;
		$html_code .= "\t<br />\n";
	}

	foreach ($alphabet as $letter) {
		$set = 0;
		$text_tmp = '';
		foreach ($manuf_array as $manuf) {
			if( preg_match("/^$letter/i", $manuf) ) {
				$text_tmp .= "\t<span style=\"padding-left: 10px;\"><a href=\"$script_name_g?page=m&amp;manuf=$manuf\">$manuf</a></span><br />\n";
				$set = 1;
			}
		}
		if( $set == 1 ){
			$html_code .= "\t<b>$letter:</b><br />\n";
			$html_code .= $text_tmp;
			$html_code .= "\t<br />\n";
		}
	}

	return $html_code;
}


function display_home_page() { // home page
	$html_code = '';

	$html_code .= <<<Endhtml
		<pre>
	cpu-db.info is an attempt to make a free and open resource for CPU, MCU, DSP, BSP and FPU information.

	Goals:
		Completeness
		Accuracy

	Database repository:
		The repositoy can be accessed using GIT, and the database is 
		stored as Comma-Seperated-Value spreadsheets.  The repository 
		is located in <a href="https://github.com/zymos/cpu-db">github.com/zymos/cpu-db</a>
		
	Download:
		<a href="https://github.com/zymos/cpu-db/tarball/master">cpu-db.tar.gz</a>
		<a href="https://github.com/zymos/cpu-db/zipball/master">cpu-db.zip</a>

	Get involved:
		To add/edit the database checkout.
		<a href="$script_name_g?page=contrib">Contribute</a>

	Contact:
		<a href="$script_name_g?page=contact">Contact</a>

		</pre><br />
Endhtml;

	return $html_code;
}


function display_manuf_page($manuf) { // page=m&manuf=$manuf
	global $html_title_g, $html_keywords_g;
	$table_results = array();

	$html_title_g = "cpu-db.info - $manuf";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf";

	// $html_code = " $manuf ";
	$table_results = get_manuf_type_family_hash();

	// print_array($table_results);
	$key1 = $manuf;
	$html_code .= "<h1>$key1</h1>\n";

	foreach ( array_keys($table_results[$key1]) as $key2 ){
		if( $key2 === 'CPU' || $key2 === 'BSP' || $key2 === 'MCU' || $key2 === 'DSP' || $key2 === 'FPU' ){ 
			$html_code .= "<h3>$key2</h3>\n";
			foreach ( array_keys($table_results[$manuf][$key2]) as $key3 ){
				// echo ">> $key3 <br />\n";
				$html_code .= "<a href=\"$script_name_g?page=mf&amp;manuf=$key1&amp;family=$key3\">$key3</a>, ";
			}
			$html_code = preg_replace("/, $/","<br /><br />\n",$html_code);
		}
	}
	// for my $k2 ( sort keys $hashish{ $k1 } ) {
			// if( $k2 eq 'CPU' || $k2 eq 'BSP' || $k2 eq 'MCU' || $k2 eq 'DSP' ){ 
				// $html_code .= "$k2: ";
				// for my $k3 ( sort keys $hashish{ $k1 }{ $k2 } ) {
					// $html_code .= "<a href=\"$script_name_g?page=mf&amp;manuf=$k1&amp;family=$k3\">$k3</a>, ";
				// }
				// $html_code .= "<br />\n";
			// }
	// }
	return $html_code;
}




function display_download_page() { // page=download
	global $html_title_g, $html_keywords_g;
		
	$html_code = '';

	$html_title_g = 'cpu-db.info - Download Database';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, download';

	$html_code .= <<<Endhtml

	<h1>Download the Database</h1>

	<pre>
	Download compressed archive:
		<a href="https://github.com/zymos/cpu-db/tarball/master">cpu-db.tar.gz</a>
		<a href="https://github.com/zymos/cpu-db/zipball/master">cpu-db.zip</a>

	Download GIT repository:
		git clone https://github.com/zymos/cpu-db
			or
		git clone git://github.com/zymos/cpu-db.git

	Browse GIT repository:
		<a href="https://github.com/zymos/cpu-db">https://github.com/zymos/cpu-db</a>
	</pre>

Endhtml;
	
	return $html_code;
}




function display_contrib_upload_page() { // page=contrib_upload
	global $html_title_g, $html_keywords_g;
	$html_code = '';
	
	$html_title_g = 'cpu-db.info - Upload DB Update';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, upload';

	$html_code .= <<<Endhtml
<form id="emf-form" target="_self" enctype="multipart/form-data" method="post" action="http://www.emailmeform.com/builder/form/9G6SkPo2sr44d" name="emf-form">
  <table style="text-align:left;" cellpadding="2" cellspacing="0" border="0" bgcolor="#FFFFFF">
    <tr>
      <td style="" colspan="2">
        <font face="Verdana" size="2" color="#000000"><b style="font-size:20px;">Upload DB update</b><br />
        <label style="font-size:15px;">If you want to update the cpu-db you can upload your updated CSV file here.<br />
        <br />
        Only upload spreadsheets in CSV format, and only one file per manufacturer. i.e. cpu-db.AMD.csv. Compressing the file is OK.<br /></label><br /></font>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_0" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Name</b></font>
      </td>
      <td id="td_element_field_0" style="">
        <input id="element_0" name="element_0" value="" size="30" class="validate[optional]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_1" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Email</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_1" style="">
        <input id="element_1" name="element_1" class="validate[required,custom[email]]" value="" size="30" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_2" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>File Upload</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_2" style="">
        <input id="element_2" name="element_2" class="validate[required]" type="file" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_3" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Chip manufacturer</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_3" style="">
        <input id="element_3" name="element_3" value="" size="30" class="validate[required]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_4" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Comments</b></font>
      </td>
      <td id="td_element_field_4" style="">
        <textarea id="element_4" name="element_4" cols="45" rows="10" class="validate[optional]">
</textarea>
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <script type="text/javascript">
//<![CDATA[
        var RecaptchaOptions = {
                theme: 'clean',
                custom_theme_widget: 'emf-recaptcha_widget'
                };
        //]]>
        </script> <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6LchicQSAAAAAGksQmNaDZMw3aQITPqZEsX77lT9">
</script> <noscript><iframe src="https://www.google.com/recaptcha/api/noscript?k=6LchicQSAAAAAGksQmNaDZMw3aQITPqZEsX77lT9" height="300" width="500" frameborder="0"></iframe><br />
        <textarea name="recaptcha_challenge_field" rows="3" cols="40">
</textarea> <input type="hidden" name="recaptcha_response_field" value="manual_challenge" /></noscript>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="left">
        <input name="element_counts" value="5" type="hidden" /> <input name="embed" value="forms" type="hidden" /><input value="Submit" type="submit" />
      </td>
    </tr>
  </table>
</form>
<div>
  <font face="Verdana" size="2" color="#000000">Powered by</font><span style="position: relative; padding-left: 3px; bottom: -5px;"><img src=
  "https://www.emailmeform.com/builder/images/footer-logo.png" /></span><font face="Verdana" size="2" color="#000000">EMF</font> <a style="text-decoration:none;" href="http://www.emailmeform.com/"
  target="_blank"><font face="Verdana" size="2" color="#000000">Contact Form</font></a>
</div>

Endhtml;
	
	return $html_code;
}

function display_contrib_page() { // page=contrib
	global $html_title_g, $html_keywords_g;
	$html_code = '';

	$html_title_g = 'cpu-db.info - Contribute to the Database';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, contribute';
	
	$html_code .= <<<Endhtml

	<h1>Contribute to the projects</h1>

	<p>There are two ways to add to the cpu-db.  The recomended method is using GIT.  GIT is a repository that allows tracking changes.  GIT takes a little time to learn, but not too much.  The second method is to edit the database files and upload them to the site.</p>

	<p>Be sure to introduce your self first: <a href="$script_name_g?page=contact">Contact</a></p><br />

	<h3>Contribute using GIT</h3>

	<ul>
		<li>I found this howto: <a href="http://www.lornajane.net/posts/2010/contributing-to-projects-on-github">Contributing to Projects on GitHub</a></li>
		<li>The repository is located here: <a href="https://github.com/zymos/cpu-db">https://github.com/zymos/cpu-db</a></p></li>
	</ul><br />
	
	<h3>Contribute by uploading</h3>

	Steps:
	<ul>
		<li>Download the latest database<br />
		https://github.com/zymos/cpu-db/zipball/master</li>
		<li>Edit the individual CSV spreadsheet for the manufacturer you wish to edit, using your favorite spreadsheet program.  Do not edit cpu-db.csv, the main CSV file. Do not change the columns labels or order witchout contacting us first.</li>
		<li>Save your spreadsheet as a Comma-Seperated-Value (CSV) file.</li>
		<li>Upload your CSV file, you can compress it if you wish:<br />
		<a href="$script_name_g?page=contrib_upload">Upload page</a></li>
		<li>Your file will be emailed to me, and I will add it to the GIT repository</li>
		<li>Make sure to download the latest version of the DB each time before you edit it.  Others may have made changes, and if you don't have the latest, their edits will be lost.</li>
	</ul>


Endhtml;

	return $html_code;
}

function display_contact_confirm_page() { // page=contact_confirm
	global $html_title_g, $html_keywords_g;
	$html_code = '';
	
	$html_title_g = 'cpu-db.info - Email Confirmed';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database';
	
	$html_code .= <<<Endhtml
	
	<h1>Email has been sent.</h1>
Endhtml;

	return $html_code;
}





function display_add_edit_chip_page($manuf, $part, $edit_type) { // page=add_chip or edit_chip
	global $html_title_g, $html_keywords_g;
	global $mysqli;
	
	$html_code = '';

	if( $edit_type === 'edit' ){
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
		
	}else{
		$html_title_g = 'cpu-db.info - Add Chip';
		$html_keywords_g = 'CPU, MCU, DSP, BSP, add chip';



		$html_code .= "<h1>Add a chip</h1>\n";
		$title2 = "Add new chip";
		$add_or_edit = "add";


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
		<div style="color: red; font-weight: bold;">Required fields*</div>
		<br />

		<div style="font-weight: bold;">All info must come from a valid source, and referenced at the bottom.</div><br />

		<div style="font-weight: bold;">No HTML, or code.</div><br />

		<div style="font-weight: bold;">Prefered Units:</div>
		<ul>
			<li>b, B: <i>bit, byte</i> </li>
			<li>um, nm: <i>micrometers, nanometers</i> </li>
			<li>mm^2, mm^3: <i>square millimeters, cubic millimeters</i> </li>
			<li>V, W, C: Volts, <i>Watts, degrees Celsius</i> </li>
			<li>kHz, MHz, GHz: <i>kilo-Hertz, mega-Hertz, giga-Hertz</i> </li>
			<li>KiB, MiB, GiB: <i>kilobytes, megabytes, gigabytes</i> </li>
			<li>MiB/s, GiB/s: <i>megabytes per second, gigabytes per second</i> </li>
			<li>k, M: <i>thousand, million</i> </li>
			<li>currency: <i>dollors US</i> </li>
			<li>date format: <i>13 April 2001</i> </li>
		</ul><br />

		<div style="font-weight: bold;">Element descriptions:</div>
		to be added...<br />
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
			<tr>
				<td class='table_param'>Manufacturer:<span style="color: red; ">*</span></td>
				<td class='table_value'><input type="text" name="manuf" value="$manuf"> e.g. <i>Intel</i></td>
			</tr><tr>
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
&nbsp;&nbsp;<b>Filenames:</b> should be the name of the file uploaded, no links. (required)<br />
&nbsp;&nbsp;<b>Creator:</b> is the author of the picture, It can be real name, or handle. (required)<br />
&nbsp;&nbsp;<b>Source:</b> is a link to the original image, no code. (required)<br />
&nbsp;&nbsp;<b>License:</b> is the license/copyright of the image. (required)<br />
&nbsp;&nbsp;&nbsp;&nbsp; Acceptable licenses (be specific type/version) include date:<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://creativecommons.org/licenses/">Creative Commons. e.g. CC BY-NC-ND 3.0, 13 July 2001 </a><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://en.wikipedia.org/wiki/GNU_General_Public_License">GPL e.g. GPLv3, Aug 1999</a><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://en.wikipedia.org/wiki/Public_domain">Public Domain</a> e.g. Public Domain, 2003<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://opensource.org/licenses">Other acceptable licenses</a><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Standard Copyright is only acceptable with Die Photos, due to limited sources.  All other photos must be Open content.</a><br />
&nbsp;&nbsp;<b>Comments:</b> are optional<br /><br />

&nbsp;&nbsp;<b>front:</b> is the front or top of the chip.<br />
&nbsp;&nbsp;<b>back:</b> is the back or bottom of the chip. <br />
&nbsp;&nbsp;<b>die:</b> is <a href="http://en.wikipedia.org/wiki/Die_%28integrated_circuit%29">die</a> of the chip.<br /><br /><br />

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
				<td class='table_param'>photo_front_creator_1</td>
				<td class='table_value'><input type="text" name="photo_front_creator_1" value="$photo_front_creator_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_source_1</td>
				<td class='table_value'><input type="text" name="photo_front_source_1" value="$photo_front_source_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_license_1</td>
				<td class='table_value'><input type="text" name="photo_front_copyright_1" value="$photo_front_copyright_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_comment_1</td>
				<td class='table_value'><input type="text" name="photo_front_comment_1" value="$photo_front_comment_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>
	
			<tr>
				<td class='table_param'>photo_back_filename_1</td>
				<td class='table_value'><input type="text" name="photo_back_filename_1" value="$photo_back_filename_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_creator_1</td>
				<td class='table_value'><input type="text" name="photo_back_creator_1" value="$photo_back_creator_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_source_1</td>
				<td class='table_value'><input type="text" name="photo_back_source_1" value="$photo_back_source_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_license_1</td>
				<td class='table_value'><input type="text" name="photo_back_copyright_1" value="$photo_back_copyright_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_comment_1</td>
				<td class='table_value'><input type="text" name="photo_back_comment_1" value="$photo_back_comment_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_2</td>
				<td class='table_value'><input type="text" name="photo_front_filename_2" value="$photo_front_filename_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_creator_2</td>
				<td class='table_value'><input type="text" name="photo_front_creator_2" value="$photo_front_creator_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_source_2</td>
				<td class='table_value'><input type="text" name="photo_front_source_2" value="$photo_front_source_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_license_2</td>
				<td class='table_value'><input type="text" name="photo_front_copyright_2" value="$photo_front_copyright_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_comment_2</td>
				<td class='table_value'><input type="text" name="photo_front_comment_2" value="$photo_front_comment_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_2</td>
				<td class='table_value'><input type="text" name="photo_back_filename_2" value="$photo_back_filename_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_creator_2</td>
				<td class='table_value'><input type="text" name="photo_back_creator_2" value="$photo_back_creator_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_source_2</td>
				<td class='table_value'><input type="text" name="photo_back_source_2" value="$photo_back_source_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_license_2</td>
				<td class='table_value'><input type="text" name="photo_back_copyright_2" value="$photo_back_copyright_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_comment_2</td>
				<td class='table_value'><input type="text" name="photo_back_comment_2" value="$photo_back_comment_2" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_3</td>
				<td class='table_value'><input type="text" name="photo_front_filename_3" value="$photo_front_filename_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_creator_3</td>
				<td class='table_value'><input type="text" name="photo_front_creator_3" value="$photo_front_creator_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_source_3</td>
				<td class='table_value'><input type="text" name="photo_front_source_3" value="$photo_front_source_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_license_3</td>
				<td class='table_value'><input type="text" name="photo_front_copyright_3" value="$photo_front_copyright_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_comment_3</td>
				<td class='table_value'><input type="text" name="photo_front_comment_3" value="$photo_front_comment_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_3</td>
				<td class='table_value'><input type="text" name="photo_back_filename_3" value="$photo_back_filename_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_creator_3</td>
				<td class='table_value'><input type="text" name="photo_back_creator_3" value="$photo_back_creator_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_source_3</td>
				<td class='table_value'><input type="text" name="photo_back_source_3" value="$photo_back_source_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_license_3</td>
				<td class='table_value'><input type="text" name="photo_back_copyright_3" value="$photo_back_copyright_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_comment_3</td>
				<td class='table_value'><input type="text" name="photo_back_comment_3" value="$photo_back_comment_3" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_front_filename_4</td>
				<td class='table_value'><input type="text" name="photo_front_filename_4" value="$photo_front_filename_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_creator_4</td>
				<td class='table_value'><input type="text" name="photo_front_creator_4" value="$photo_front_creator_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_source_4</td>
				<td class='table_value'><input type="text" name="photo_front_source_4" value="$photo_front_source_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_license_4</td>
				<td class='table_value'><input type="text" name="photo_front_copyright_4" value="$photo_front_copyright_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_front_comment_4</td>
				<td class='table_value'><input type="text" name="photo_front_comment_4" value="$photo_front_comment_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>photo_back_filename_4</td>
				<td class='table_value'><input type="text" name="photo_back_filename_4" value="$photo_back_filename_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_creator_4</td>
				<td class='table_value'><input type="text" name="photo_back_creator_4" value="$photo_back_creator_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_source_4</td>
				<td class='table_value'><input type="text" name="photo_back_source_4" value="$photo_back_source_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_license_4</td>
				<td class='table_value'><input type="text" name="photo_back_copyright_4" value="$photo_back_copyright_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>photo_back_comment_4</td>
				<td class='table_value'><input type="text" name="photo_back_comment_4" value="$photo_back_comment_4" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'><br /></td>
			</tr>

	
			<tr>
				<td class='table_param'>die_photo_filename_1</td>
				<td class='table_value'><input type="text" name="die_photo_filename_1" value="$die_photo_filename_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>die_photo_creator_1</td>
				<td class='table_value'><input type="text" name="die_photo_creator_1" value="$die_photo_creator_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>die_photo_source_1</td>
				<td class='table_value'><input type="text" name="die_photo_source_1" value="$die_photo_source_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>die_photo_license_1</td>
				<td class='table_value'><input type="text" name="die_photo_copyright_1" value="$die_photo_copyright_1" size="60"></td>
			</tr>
			<tr>
				<td class='table_param'>die_photo_comment_1 </td>
				<td class='table_value'><input type="text" name="die_photo_comment_1" value="$die_photo_comment_1" size="60"></td>
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




function display_contact_page() { // page=contact
	global $html_title_g, $html_keywords_g;
	$html_code = '';

	$html_title_g = 'cpu-db.info - Contact Page';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, contact';

	$html_code .= <<<Endhtml

<form id="emf-form" target="_self" enctype="multipart/form-data" method="post" action="http://www.emailmeform.com/builder/form/dnd31pey831iFfaz0L" name="emf-form">
  <table style="text-align:left;" cellpadding="2" cellspacing="0" border="0" bgcolor="#FFFFFF">
    <tr>
      <td style="" colspan="2">
        <font face="Verdana" size="2" color="#000000"><b style="font-size:20px;">Contact</b><br />
        <label style="font-size:15px;">Please be as descriptive as possible. (English only)<br /></label><br /></font>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_0" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Name</b></font>
      </td>
      <td id="td_element_field_0" style="">
        <input id="element_0" name="element_0" value="" size="30" class="validate[optional]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_1" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Email</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_1" style="">
        <input id="element_1" name="element_1" class="validate[required,custom[email]]" value="" size="30" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_2" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Subject</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_2" style="">
        <input id="element_2" name="element_2" value="" size="30" class="validate[required]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_3" style="" align="left">
        <font face="Verdana" size="2" color="#000000"><b>Message</b></font> <span style="color:red;"><small>*</small></span>
      </td>
      <td id="td_element_field_3" style="">
        <textarea id="element_3" name="element_3" cols="45" rows="10" class="validate[required]">
</textarea>
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <script type="text/javascript">
//<![CDATA[
        var RecaptchaOptions = {
                theme: 'clean',
                custom_theme_widget: 'emf-recaptcha_widget'
                };
        //]]>
        </script> <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6LchicQSAAAAAGksQmNaDZMw3aQITPqZEsX77lT9">
</script> <noscript><iframe src="https://www.google.com/recaptcha/api/noscript?k=6LchicQSAAAAAGksQmNaDZMw3aQITPqZEsX77lT9" height="300" width="500" frameborder="0"></iframe><br />
        <textarea name="recaptcha_challenge_field" rows="3" cols="40">
</textarea> <input type="hidden" name="recaptcha_response_field" value="manual_challenge" /></noscript>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="left">
        <input name="element_counts" value="4" type="hidden" /> <input name="embed" value="forms" type="hidden" /><input value="Submit" type="submit" />
      </td>
    </tr>
  </table>
</form>
<div>
  <font face="Verdana" size="2" color="#000000">Powered by</font><span style="position: relative; padding-left: 3px; bottom: -5px;"><img src=
  "https://www.emailmeform.com/builder/images/footer-logo.png" /></span><font face="Verdana" size="2" color="#000000">EMF</font> <a style="text-decoration:none;" href="http://www.emailmeform.com/"
  target="_blank"><font face="Verdana" size="2" color="#000000">Online Form</font></a>
</div>
Endhtml;

	return $html_code;
}





function display_header() {
	global $mysqli;

	$html_code = '';

	$chip_count = get_chip_count();
	$update_date = get_update_date();

	// $html_code .= "content-type: text/html \n\n"; #HTTP HEADER

	$html_code .= <<<Endhtml
<!DOCTYPE html>
<html>
<head>
	<title>HTML_HEAD_TITLE</title>
	<meta name="description" content="A Database for CPU, MCU, DSP, and BSP information" />
	<meta name=keywords content="HTML_HEAD_KEYWORDS" />
  <style>
    h1 {
		font-size: 30px; 
		font-weight: bold;
	}
	#bode {  
    	margin: 0 auto;  
		border: 1px;
    }  
	#chip_count {
	    position: absolute;
    	top: 20px;
	    right: 20px;
		font-size: 12px; 
	}
	#lists {
    	margin-left: 50px;
		border: 1px;
	}
	#chip_content {
		margin: 0 25px 0 0;
		padding: 0;
		border: 1px;
	}
	#chip_content_params {
		margin: 0 25px 0 0;
		padding: 0;
	  border: 1px;

	}

	.body_content_indent {
		margin-left: 25px;
	}

	.family_table_td {
		vertical-align: top;
		padding: 10px;
		width: 500px;
	}

	.table_param {
		width: 150px;
		font-size: 12px; 
		font-weight: bold;
	}

	.table_param_long {
		width: 200px;
		font-size: 12px; 
		font-weight: bold;
	}

	.table_sec {
		font-size:16px; 
		font-weight:bold;
	}

	.table_value {
		font-size: 12px;
	}

	.table_td_blank {
		width: 25px;
	}

	.warning_message {
		color: red;
		font-size: 12px;
		font-style: italic;
	}

</style>
</head>
<body>
	
<h1 style="color: red;">cpu-db.info (PHP)</h1>
<div id="chip_count">$chip_count chips in db<br />
Endhtml;
	
	if(login_check($mysqli) == true) {
	$html_code .= '<a href="logout.php">Logout</a>';
	// Add your protected page content here!
} else {
	$html_code .= '<a href="login.php">Login/Register</a>';
}

$html_code .= <<<Endhtml
</div>

<a href="http://cpu-db.info">Home</a> | <a href="$script_name_g?page=cat&amp;type=chips">Chips</a> | <a href="$script_name_g?page=cat&amp;type=manuf">Manufacturers</a> | <a href="$script_name_g?page=cat&amp;type=families">Families</a> | <a href="$script_name_g?page=download">Download the db</a> | <a href="$script_name_g?page=contrib">Edit the db</a> | <a href="$script_name_g?page=contact">Contact</a> | <a href="$script_name_g?page=contact">Contact</a>  <br /><br />

	<div id="bode">
Endhtml;
	return $html_code;
}


function display_footer() {
	$html_code = '';

	//# my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime time;
	//# $year += 1900;
	$year = 2013;

	$html_code .= <<<Endhtml

	</div>
	<br />
	<p style="font-size: 12px;">
	Brought to you by <a href="http://www.happytrees.org/chips">CPU Grave Yard</a><br />
	Sites contents under <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike License</a>, unless otherwised noted. 2012-$year cpu-db.info <br />
	</p>

	<!-- GoStats JavaScript Based Code -->
<script type="text/javascript" src="http://gostats.com/js/counter.js"></script>
<script type="text/javascript">_gos='c4.gostats.com';_goa=378322;
_got=6;_goi=28;_gol='GoStats stats counter';_GoStatsRun();</script>
<noscript><a target="_blank" title="GoStats stats counter" 
href="http://gostats.com"><img alt="GoStats stats counter" 
src="http://c4.gostats.com/bin/count/a_378322/t_6/i_28/counter.png" 
style="border-width:0" /></a></noscript>
<!-- End GoStats JavaScript Based Code -->
<br />
</body>
</html>
Endhtml;
	return $html_code;
}


?>
