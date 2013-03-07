#!/usr/bin/perl 



use File::stat;
use Time::localtime;
use Switch;
use DBI;

use lib "$ENV{HOME}/lib";
use Text::CSV;
 # use Tie::Array::CSV;

#############################
# Config
#

$database_location='cpu-db.csv';
$todo_file_loc_g='TODO.txt';
$db ="cpu_db";
$table ="cpu_db_table";
$user = "cpudb_user";
$pass = "thepasswordforcpudbuser";
$host="localhost";







######################################################
############## Coding ################################
######################################################


################## Import ARGS ##############
sub read_input {
    local ($buffer, @pairs, $pair, $name, $value, %FORM);
    # Read in text
    $ENV{'REQUEST_METHOD'} =~ tr/a-z/A-Z/;
    if ($ENV{'REQUEST_METHOD'} eq "POST")
    {
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
    } else
    {
        $buffer = $ENV{'QUERY_STRING'};
    }
	# $buffer = 'page=manufacturer&manufacturer=AMD&family=AM29000';
    # Split information into name/value pairs
    @pairs = split(/&/, $buffer);
    foreach $pair (@pairs)
    {
        ($name, $value) = split(/=/, $pair);
        $value =~ tr/+/ /;
        $value =~ s/%(..)/pack("C", hex($1))/eg;
        $FORM{$name} = $value;
    }
    %FORM;
}
###############Inport ARGS (end) ##################











######################################################
############# load sql DB (begin) ####################

sub load_sql_db {
	$dbh = DBI->connect("DBI:mysql:$db:$host",$user, $pass);
}

sub get_manuf_list_alphabetical {# page=cat&type=manuf
	my $col = 'manufacturer';
 	my $statement = "SELECT DISTINCT $col FROM $table";
	my $ref = $dbh->selectcol_arrayref($statement);
	my @array = sort @{$ref};
	return @array;
}


sub get_single_chip_info {# page=c
	my $manuf = $_[0];
	my $part = $_[1];
	my $statement = "SELECT manufacturer,family,part,alternative_label_1,alternative_label_2,alternative_label_3,alternative_label_4,alternative_label_5,alternative_label_6,chip_type,sub_family,model_number,core,core_designer,microarchitecture,threads,cpuid,core_count,pipeline,multiprocessing,architecture,data_bus_ext,address_bus,bus_comments,frequency_ext,frequency_min,frequency_max_typ,actual_bus_frequency,effective_bus_frequency,bus_bandwidth,clock_multiplier,core_stepping,l1_data_cache,l1_data_associativity,l1_instruction_cache,l1_instruction_associativity,l1_unified_cache,l1_unified_associativity,l2_cache,l2_associativity,l3_cache,l3_associativity,boot_rom,rom_internal,rom_type,ram_internal,ram_max,ram_type,virtual_memory_max,package,package_size,package_weight,socket,transistor_count,process_size,metal_layers,metal_type,process_technology,die_size,rohs,vcc_core_range,vcc_core_typ,vcc_secondary,vcc_tertiary,vcc_i_o,i_o_compatibillity,power_min,power_typ,power_max,power_thermal_design,temperature_range,temperature_grade,low_power_features,instruction_set,instruction_set_extensions,additional_instructions,computer_architecture,isa,fpu,on_chip_peripherals,features,production_type,clone,release_date,initial_price,applications,military_spec,comments,reference_1,reference_2,reference_3,reference_4,reference_5,reference_6,reference_7,reference_8,photo_front_filename_1,photo_front_copyright_1,photo_front_comment_1,photo_back_filename_1,photo_back_copyright_1,photo_back_comment_1,photo_front_filename_2,photo_front_copyright_2,photo_front_comment_2,photo_back_filename_2,photo_back_copyright_2,photo_back_comment_2,photo_front_filename_3,photo_front_copyright_3,photo_front_comment_3,photo_back_filename_3,photo_back_copyright_3,photo_back_comment_3,photo_front_filename_4,photo_front_copyright_4,photo_front_comment_4,photo_back_filename_4,photo_back_copyright_4,photo_back_comment_4,die_photo_filename_1,die_photo_copyright_1,die_photo_comment_1 FROM $table WHERE manufacturer=\'$manuf\' AND part=\'$part\'";
	my $chip_hash_ref = $dbh->selectrow_hashref($statement);
	return $chip_hash_ref;
}


sub get_manufs_of_family_list {# page=f
	my $family = $_[0];
	my $col_sel = 'manufacturer';
	my $col_sort = 'family';
 	my $statement = "SELECT DISTINCT $col_sel FROM $table WHERE $col_sort = \'$family\' ";
	my $ref = $dbh->selectcol_arrayref($statement);
	my @array = sort @{$ref};
	return @array;
}


sub get_manuf_family_chip_list {# page=mf
	my $manuf = $_[0];
	my $family = $_[1];
 	my $statement = "SELECT part,chip_type,frequency_max_typ FROM $table WHERE manufacturer=\'$manuf\' AND family=\'$family\'";
	my $array_ref = $dbh->selectall_arrayref($statement);
	return $array_ref;
}


sub get_family_list_alphabetical {# page=
	my $col = 'family';
 	my $statement = "SELECT DISTINCT $col FROM $table";
	my $ref = $dbh->selectcol_arrayref($statement);
	my @array = sort @{$ref};
	return @array;
}


sub get_manuf_type_family_hash { # page=
	my $man = '';
	my $type = '';
	my $fam = '';
	my %hashish = ();
	my $query = "SELECT DISTINCT manufacturer, chip_type, family FROM $table";
	my $sth = $dbh->prepare($query);
	$sth->execute();
	while (($man, $type, $fam) = $sth->fetchrow()) {
		$hashish{$man}{$type}{$fam} = 1;
		# print "$man $type $fam\n";
	} 
	return %hashish;
}


sub get_family_list_cpu { # page=
	my $col = 'family';
	my @array = ();
 	my $sth = $dbh->prepare("SELECT DISTINCT $col FROM $table WHERE chip_type = 'CPU'");
 	$sth->execute();
	my $ref = $sth->fetchall_arrayref;
	foreach $row ( @{$ref} ) {
		if(@$row ne ''){
			push(@array, @$row);
		}
	}	
	return @array;
}


sub get_family_list_mcu {# page=
	my $col = 'family';
	my @array = ();
 	my $sth = $dbh->prepare("SELECT DISTINCT $col FROM $table WHERE chip_type = 'MCU'");
 	$sth->execute();
	my $ref = $sth->fetchall_arrayref;
	foreach $row ( @{$ref} ) {
		if(@$row ne ''){
			push(@array, @$row);
		}
	}	
	return @array;
}


sub get_family_list_dsp { # page=
	my $col = 'family';
	my @array = ();
 	my $sth = $dbh->prepare("SELECT DISTINCT $col FROM $table WHERE chip_type = 'DSP'");
 	$sth->execute();
	my $ref = $sth->fetchall_arrayref;
	foreach $row ( @{$ref} ) {
		if(@$row ne ''){
			push(@array, @$row);
		}
	}	
	return @array;
}


sub get_family_list_bsp { # page=
	my $col = 'family';
	my @array = ();
 	my $sth = $dbh->prepare("SELECT DISTINCT $col FROM $table WHERE chip_type = 'BSP'");
 	$sth->execute();
	my $ref = $sth->fetchall_arrayref;
	foreach $row ( @{$ref} ) {
		if(@$row ne ''){
			push(@array, @$row);
		}
	}	
	return @array;
}




############# load sql DB (end) ####################
####################################################









#############Import DB (begin) ####################

#open file
sub open_file { 
	my $fileName = $_[0];
	open(FILEVARIABLE, "< $fileName");
	@fileLines= <FILEVARIABLE>;
	close(FILEVARIABLE);
	return @fileLines;
}







#######################################################
####################### Display #######################

sub display_chips_page { # page=cat&type=chips
	my $html_code = "";
	
	$html_title_g = 'cpu-db.info - Chip List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database';

	my %hashish = get_manuf_type_family_hash();

	for my $k1 ( sort keys %hashish ) {
		if( $k1 ne '' ){
			$html_code .= "<h3>$k1</h3>\n";
			for my $k2 ( sort keys $hashish{ $k1 } ) {
				if( $k2 eq 'CPU' || $k2 eq 'BSP' || $k2 eq 'MCU' || $k2 eq 'DSP' ){ 
					$html_code .= "$k2: ";
					for my $k3 ( sort keys $hashish{ $k1 }{ $k2 } ) {
						$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$k1&family=$k3\">$k3</a>, ";
					}
					$html_code .= "<br />\n";
				}
			}
		}
	}
	return $html_code;
}

sub display_manuf_page { # page=m
	my $manuf = $_[0];

	$html_title_g = "cpu-db.info - $manuf";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf";
	
	my %hashish = get_manuf_type_family_hash();

	my $k1 = 'Intel';
	$html_code .= "<h1>$k1</h1>\n";
	for my $k2 ( sort keys $hashish{ $k1 } ) {
			if( $k2 eq 'CPU' || $k2 eq 'BSP' || $k2 eq 'MCU' || $k2 eq 'DSP' ){ 
				$html_code .= "$k2: ";
				for my $k3 ( sort keys $hashish{ $k1 }{ $k2 } ) {
					$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$k1&family=$k3\">$k3</a>, ";
				}
				$html_code .= "<br />\n";
			}
	}
	return $html_code;
}


sub display_manuf_family_page { # page=mf
	my $manuf = $_[0];
	my $family = $_[1];

	$html_title_g = "cpu-db.info - $manuf - $family";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf, $family";

	my $chip_list = get_manuf_family_chip_list($manuf,$family);
	
	my $html_code = "<h1>$manuf - $family</h1>\n";
	$html_code .= <<Endhtml;
	<table>
		<tr>
Endhtml
	$html_code .=  "\t\t\t<td><b>Part number</b></td><td><b>Type</b></td><td><b>Speed</b></td>\n";
	$html_code .=  "\t\t</tr><tr>\n";
	
	foreach $row ( @{ $chip_list } ) {
		$html_code .=  "\t\t\t<td><a href=\"$script_name_g?page=c&manuf=$manuf&part=$row->[0]\">$row->[0]</a></td><td>$row->[1]</td><td>$row->[2]</td>\n";
		$html_code .=  "\t\t</tr><tr>\n";

	}

	$html_code .= <<Endhtml;
		</tr>
	</table>
Endhtml
	return $html_code;
}



sub display_home_page { # home page
	my $html_code = '';

	$html_code .= <<Endhtml;
		<pre>
	cpu-db.info is an attempt to make a free and open resource for CPU and other IC information.

	Goals:
		Completeness
		Accuracy

	Database repository:
		The repositoy can be accessed using GIT, and the database is 
		stored as Comma-Seperated-Value spreadsheets.  The repository 
		is located in https://github.com/zymos/cpu-db
		
	Download:
		<a href="https://github.com/zymos/cpu-db/tarball/master">cpu-db.tar.gz</a>
		<a href="https://github.com/zymos/cpu-db/zipball/master">cpu-db.zip</a>

	Get involved:
		To add/edit the database checkout.
		<a href="$script_name_g?page=contrib">Contribute</a>

	Contact:
		<a href="$script_name_g?page=contact">Contact</a>

		</pre><br />
Endhtml

	return $html_code;
}

sub display_single_chip_info_g { # page=c
	my $manuf = $_[0];
	my $part = $_[1];

	$html_title_g = "cpu-db.info - $manuf $part";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $manuf, $part";

	my $ref_warning = '';
	my $missing_info_level=0;
	my $missing_info_message = '';

	my $chip = get_single_chip_info($manuf,$part);

	my $family = $chip->{ 'family' };
	my $alternative_label_1 = $chip->{ 'alternative_label_1' };
	my $alternative_label_2 = $chip->{ 'alternative_label_2' };
	my $alternative_label_3 = $chip->{ 'alternative_label_3' };
	my $alternative_label_4 = $chip->{ 'alternative_label_4' };
	my $alternative_label_5 = $chip->{ 'alternative_label_5' };
	my $alternative_label_6 = $chip->{ 'alternative_label_6' };
	my $chip_type = $chip->{ 'chip_type' };
	my $sub_family = $chip->{ 'sub_family' };
	my $model_number = $chip->{ 'model_number' };
	my $core = $chip->{ 'core' };
	my $core_designer = $chip->{ 'core_designer' };
	my $microarchitecture = $chip->{ 'microarchitecture' };
	my $threads = $chip->{ 'threads' };
	my $cpuid = $chip->{ 'cpuid' };
	my $core_count = $chip->{ 'core_count' };
	my $pipeline = $chip->{ 'pipeline' };
	my $multiprocessing = $chip->{ 'multiprocessing' };	
	my $architecture = $chip->{ 'architecture' };
	my $data_bus_ext = $chip->{ 'data_bus_ext' };
	my $address_bus = $chip->{ 'address_bus' };
	my $bus_comments = $chip->{ 'bus_comments' }; #new
	my $frequency_ext = $chip->{ 'frequency_ext' }; #new
	my $frequency_min = $chip->{ 'frequency_min' };
	my $frequency_max_typ = $chip->{ 'frequency_max_typ' };
	my $actual_bus_frequency = $chip->{ 'actual_bus_frequency' };
	my $effective_bus_frequency = $chip->{ 'effective_bus_frequency' };
	my $bus_bandwidth = $chip->{ 'bus_bandwidth' };
	my $clock_multiplier = $chip->{ 'clock_multiplier' };
	my $core_stepping = $chip->{ 'core_stepping' };
	my $l1_data_cache = $chip->{ 'l1_data_cache' };
	my $l1_data_associativity = $chip->{ 'l1_data_associativity' };
	my $l1_instruction_cache = $chip->{ 'l1_instruction_cache' };
	my $l1_instruction_associativity = $chip->{ 'l1_instruction_associativity' };
	my $l1_unified_cache = $chip->{ 'l1_unified_cache' };
	my $l1_unified_associativity = $chip->{ 'l1_unified_associativity' };
	my $l2_cache = $chip->{ 'l2_cache' };
	my $l2_associativity = $chip->{ 'l2_associativity' };
	my $l3_cache = $chip->{ 'l3_cache' };
	my $l3_associativity = $chip->{ 'l3_associativity' };
	# my $boot_rom = $chip->{ 'boot_rom' };
	my $rom_internal = $chip->{ 'rom_internal' };
	my $rom_type = $chip->{ 'rom_type' };
	my $ram_internal = $chip->{ 'ram_internal' };
	my $ram_max = $chip->{ 'ram_max' };
	my $ram_type = $chip->{ 'ram_type' };
	my $virtual_memory_max = $chip->{ 'virtual_memory_max' };
	my $package = $chip->{ 'package' };
	my $package_size = $chip->{ 'package_size' };
	my $package_weight = $chip->{ 'package_weight' };
	my $socket = $chip->{ 'socket' };
	my $transistor_count = $chip->{ 'transistor_count' };
	my $process_size = $chip->{ 'process_size' };
	my $metal_layers = $chip->{ 'metal_layers' };
	my $metal_type = $chip->{ 'metal_type' };
	my $process_technology = $chip->{ 'process_technology' };
	my $die_size = $chip->{ 'die_size' };
	my $vcc_core_range = $chip->{ 'vcc_core_range' };
	my $vcc_core_typ = $chip->{ 'vcc_core_typ' };
	my $vcc_secondary = $chip->{ 'vcc_secondary' };
	my $vcc_tertiary = $chip->{ 'vcc_tertiary' };
	my $vcc_i_o = $chip->{ 'vcc_i_o' };
	my $i_o_compatibillity = $chip->{ 'i_o_compatibillity' }; #new
	my $power_min = $chip->{ 'power_min' };
	my $power_typ = $chip->{ 'power_typ' };
	my $power_max = $chip->{ 'power_max' };
	my $power_thermal_design = $chip->{ 'power_thermal_design' };
	my $temperature_range = $chip->{ 'temperature_range' };
	my $temperature_grade = $chip->{ 'temperature_grade' }; #new
	my $low_power_features = $chip->{ 'low_power_features' };
	my $instruction_set = $chip->{ 'instruction_set' };
	my $instruction_set_extensions = $chip->{ 'instruction_set_extensions' };
	my $additional_instructions = $chip->{ 'additional_instructions' };
	my $computer_architecture = $chip->{ 'computer_architecture' };
	my $isa = $chip->{ 'isa' };
	my $fpu = $chip->{ 'fpu' };
	my $on_chip_peripherals = $chip->{ 'on_chip_peripherals' };
	my $features = $chip->{ 'features' };
	my $production_type = $chip->{ 'production_type' }; #new
	my $clone = $chip->{ 'clone' }; #new
	my $release_date = $chip->{ 'release_date' };
	my $initial_price = $chip->{ 'initial_price' };
	my $applications = $chip->{ 'applications' };
	my $military_spec = $chip->{ 'military_spec' };
	my $comments = $chip->{ 'comments' };
	my $reference_1 = $chip->{ 'reference_1' };
	my $reference_2 = $chip->{ 'reference_2' };
	my $reference_3 = $chip->{ 'reference_3' };
	my $reference_4 = $chip->{ 'reference_4' };
	my $reference_5 = $chip->{ 'reference_5' };
	my $reference_6 = $chip->{ 'reference_6' };
	my $reference_7 = $chip->{ 'reference_7' };
	my $reference_8 = $chip->{ 'reference_8' };

	my $photo_front_filename_1 = $chip->{ '$photo_front_filename_1' }; #new
	my $photo_front_copyright_1=$chip->{ '$photo_front_copyright_1' }; #new
	my $photo_front_comment_1 =  $chip->{ '$photo_front_comment_1' }; #new
	my $photo_back_filename_1 =  $chip->{ '$photo_back_filename_1' }; #new
	my $photo_back_copyright_1 = $chip->{ '$photo_back_copyright_1' }; #new
	my $photo_back_comment_1 = 	$chip->{ '$photo_back_comment_1' }; #new
	my $photo_front_filename_2 =$chip->{ '$photo_front_filename_2' }; #new
	my $photo_front_copyright_2=$chip->{ '$photo_front_copyright_2' }; #new
	my $photo_front_comment_2 = $chip->{ '$photo_front_comment_2' }; #new
	my $photo_back_filename_2 = $chip->{ '$photo_back_filename_2' }; #new
	my $photo_back_copyright_2 =$chip->{ '$photo_back_copyright_2' }; #new
	my $photo_back_comment_2 = 	$chip->{ '$photo_back_comment_2' }; #new
	my $photo_front_filename_3 =$chip->{ '$photo_front_filename_3' }; #new
	my $photo_front_copyright_3=$chip->{ '$photo_front_copyright_3' }; #new
	my $photo_front_comment_3 = $chip->{ '$photo_front_comment_3' }; #new
	my $photo_back_filename_3 = $chip->{ '$photo_back_filename_3' }; #new
	my $photo_back_copyright_3 =$chip->{ '$photo_back_copyright_3' }; #new
	my $photo_back_comment_3 = 	$chip->{ '$photo_back_comment_3' }; #new
	my $photo_front_filename_4 =$chip->{ '$photo_front_filename_4' }; #new
	my $photo_front_copyright_4=$chip->{ '$photo_front_copyright_4' }; #new
	my $photo_front_comment_4 = $chip->{ '$photo_front_comment_4' }; #new
	my $photo_back_filename_4 = $chip->{ '$photo_back_filename_4' }; #new
	my $photo_back_copyright_4 =$chip->{ '$photo_back_copyright_4' }; #new
	my $photo_back_comment_4 = 	$chip->{ '$photo_back_comment_4' }; #new
	my $die_photo_filename_1 = 	$chip->{ '$die_photo_filename_1' }; #new
	my $die_photo_copyright_1 = $chip->{ '$die_photo_copyright_1' }; #new
	my $die_photo_comment_1  = 	$chip->{ '$die_photo_comment_1' }; #new
	
	if( $family eq '' ){
		$family='?';
		$missing_info_level++;
	}
	if( $alternative_label_1 eq '' ){
		$alternative_label_1='?';
	}
	if( $alternative_label_2 eq '' ){
		$alternative_label_2='?';
	}
	if( $alternative_label_3 eq '' ){
		$alternative_label_3='?';
	}
	if( $alternative_label_4 eq '' ){
		$alternative_label_4='?';
	}
	if( $alternative_label_5 eq '' ){
		$alternative_label_5='?';
	}
	if( $alternative_label_6 eq '' ){
		$alternative_label_6='?';
	}
	if( $chip_type eq '' ){
		$chip_type='?';
		$missing_info_level++;
	}
	if( $sub_family eq '' ){
		$sub_family_text='';
	}else{
		$sub_family_text="</tr><tr>\n\t\t\t<td class='table_param'>Sub-family:</td>\n\t\t\t\t<td class='table_value'>$frequency_ext</td>";
	}
	if( $model_number eq '' ){
		$model_number_text='';
	}else{
		$model_number_text="</tr><tr>\n\t\t\t<td class='table_param'>Model Number:</td>\n\t\t\t\t<td class='table_value'>$model_number</td>";
	}
	if( $core eq '' ){
		$core='?';
	}
	if( $core_designer eq '' ){
		$core_designer='?';
	}
	if( $microarchitecture eq '' ){
		$microarchitecture='?';
	}
	if( $threads eq '' ){
		$threads_text = '';
	}else{
		$threads_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Threads:</td>\n\t\t\t\t\t<td class='table_value'>$threads</td>\n\t\t\t\t</tr>";
	}
	if( $cpuid eq '' ){
		$cpuid='?';
	}
	if( $core_count eq '' ){
		$core_count='?';
	}
	if( $pipeline eq '' ){
		$pipeline='?';
	}
	if( $multiprocessing eq '' ){
		$multiprocessing='?';
	}
	if( $architecture eq '' ){
		$architecture='?';
		$missing_info_level++;
	}
	if( $data_bus_ext eq '' ){
		$data_bus_ext='?';
	}
	if( $address_bus eq '' ){
		$address_bus='?';
	}
	if( $frequency_max_typ eq '' ){
		$frequency_max_typ='?';
		$missing_info_level++;
	}
	if( $actual_bus_frequency eq '' ){
		$actual_bus_frequency='?';
	}
	if( $effective_bus_frequency eq '' ){
		$effective_bus_frequency='?';
	}
	if( $bus_bandwidth eq '' ){
		$bus_bandwidth='?';
	}
	if( $clock_multiplier eq '' ){
		$clock_multiplier='?';
	}
	if( $core_stepping eq '' ){
		$core_stepping='?';
	}
	if( $l1_data_cache eq '' ){
		$l1_data_cache='?';
	}
	if( $l1_data_associativity eq '' ){
		$l1_data_associativity='?';
	}
	if( $l1_instruction_cache eq '' ){
		$l1_instruction_cache='?';
	}
	if( $l1_instruction_associativity eq '' ){
		$l1_instruction_associativity='?';
	}
	if( $l1_unified_cache eq '' ){
		$l1_unified_cache='?';
	}
	if( $l1_unified_associativity eq '' ){
		$l1_unified_associativity='?';
	}
	if( $l2_cache eq '' ){
		$l2_cache='?';
	}
	if( $l2_associativity eq '' ){
		$l2_associativity='?';
	}
	if( $l3_cache eq '' ){
		$l3_cache='?';
	}
	if( $l3_associativity eq '' ){
		$l3_associativity='?';
	}
	if( $boot_rom eq '' ){
		$boot_rom='?';
	}
	if( $rom_internal eq '' ){
		$rom_internal='?';
	}
	if( $rom_type eq '' ){
		$rom_type='?';
	}
	if( $ram_internal eq '' ){
		$ram_internal='?';
	}
	if( $ram_max eq '' ){
		$ram_max='?';
	}
	if( $ram_type eq '' ){
		$ram_type='?';
	}
	if( $virtual_memory_max eq '' ){
		$virtual_memory_max='?';
	}
	if( $package eq '' ){
		$package='?';
		$missing_info_level++;
	}
	if( $package_size eq '' ){
		$package_size='?';
	}
	if( $package_weight eq '' ){
		$package_weight='?';
	}
	if( $socket eq '' ){
		$socket='?';
	}
	if( $transistor_count eq '' ){
		$transistor_count='?';
	}
	if( $process_size eq '' ){
		$process_size='?';
	}
	if( $metal_layers eq '' ){
		$metal_layers='?';
	}
	if( $metal_type eq '' ){
		$metal_type='?';
	}
	if( $process_technology eq '' ){
		$process_technology='?';
	}
	if( $die_size eq '' ){
		$die_size='?';
	}
	if( $vcc_core_range eq '' ){
		$vcc_core_range='?';
	}
	if( $vcc_core_typ eq '' ){
		$vcc_core_typ='?';
		$missing_info_level++;
	}
	if( $vcc_secondary eq '' ){
		$vcc_secondary='?';
	}
	if( $vcc_tertiary eq '' ){
		$vcc_tertiary='?';
	}
	if( $vcc_i_o eq '' ){
		$vcc_i_o='?';
	}
	if( $power_min eq '' ){
		$power_min='?';
	}
	if( $power_typ eq '' ){
		$power_typ='?';
	}
	if( $power_max eq '' ){
		$power_max='?';
	}
	if( $power_thermal_design eq '' ){
		$power_thermal_design='?';
	}
	if( $temperature_range eq '' ){
		$temperature_range='?';
	}
	if( $low_power_features eq '' ){
		$low_power_features='?';
	}
	if( $instruction_set eq '' ){
		$instruction_set='?';
	}
	if( $instruction_set_extensions eq '' ){
		$instruction_set_extensions='?';
	}
	if( $additional_instructions eq '' ){
		$additional_instructions='?';
	}
	if( $computer_architecture eq '' ){
		$computer_architecture='?';
	}
	if( $isa eq '' ){
		$isa='?';
	}
	if( $fpu eq '' ){
		$fpu='?';
	}
	if( $on_chip_peripherals eq '' ){
		$on_chip_peripherals='?';
	}
	if( $release_date eq '' ){
		$release_date='?';
	}
	if( $initial_price eq '' ){
		$initial_price='?';
	}
	if( $applications eq '' ){
		$applications='?';
	}

	if( $i_o_compatibillity eq '' ){
		$i_o_compatibillity_text='';
	}else{
		$i_o_compatibillity_text = "<tr>\n\t\t\t\t\t<td class='table_param'>I/O compatability:</td>\n\t\t\t\t\t<td class='table_value'>$i_o_compatibillity</td>\n\t\t\t\t</tr>";
	}

	if( $production_type eq '' ){
		if( $part =~ /[Ss]ample/ ){
			$production_type_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Production type:</td>\n\t\t\t\t\t<td class='table_value'>Sample</td>\n\t\t\t\t</tr>";
		}else{
			$production_type_text ='';
		}
	}else{
		$production_type_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Production type:</td>\n\t\t\t\t\t<td class='table_value'>$production_type</td>\n\t\t\t\t</tr>";
	}

	if( $clone eq '' ){
		$clone_text = '';
	}else{
		$clone_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Clone:</td>\n\t\t\t\t\t<td class='table_value'>$clone</td>\n\t\t\t\t</tr>";
	}

	if( $comments eq '' ){
		$comments_text = '';
	}else{
		$comments_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Comments:</td>\n\t\t\t\t\t<td class='table_value'>$comments</td>\n\t\t\t\t</tr>";
	}

	if( $military_spec eq '' ){
		$military_spec_text = '';
	}else{
		$military_spec_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Millitary specs:</td>\n\t\t\t\t\t<td class='table_value'>$military_spec</td>\n\t\t\t\t</tr>";
	}

	if( $features eq '' ){
		$features_text='';
	}else{
		$features_text = "<tr>\n\t\t\t\t\t<td class='table_param'>Features:</td>\n\t\t\t\t\t<td class='table_value'>$features</td>\n\t\t\t\t</tr>";
	}



	# Photo
	# $photo_front_filename_1 = 'ic_photo--top--Zilog--Z0800210PSC--(Z8000-CPU).png';
	# $photo_front_source_1 = 'CPU Grave Yard';
	# $photo_front_copyright_1 = 'Creative Commons BY-SA 3.0';
	# $photo_front_comments_1 = '';
	my $ic_photo_front_text = '';
	if( $photo_front_filename_1 eq '' ){
		$ic_photo_front_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<p style="font-size: 16px;">
							Chip Photo<br />
							</p><p style="font-size: 12px;">
							is unavailable.<br /><br />
							If you have one,<br />
							please <a href="$script_name_g?page=upload">upload</a> it.
							</p>
						</div>
					</td>
Endhtml
	}else{
		my $source_text = '';
		my $copyright_text = '';
		my $comment_text = '';
		if( $photo_front_source_1 eq '' ){
			$source_text = '';
		}else{
			$source_text = "Source: $photo_front_source_1<br />";
		}
		if( $photo_front_copyright_1 eq '' ){
			$copyright_text = '';
		}else{
			$copyright_text = "Licence: $photo_front_copyright_1<br />";
		}
		if( $photo_front_comment_1 eq '' ){
			$comment_text = '';
		}else{
			$comment_text = "Comments: $photo_front_comment_1<br />";
		}
		$ic_photo_front_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<img src="http://cpu-db.info/images/photos/sm/$photo_front_filename_1\_sm.jpg" width="300" />
						</div>
						<div>
							<p style="font-size: 12px;">
							$source_text
							$copyright_text
							$comment_text
							</p>
						</div>
					</td>
Endhtml
	}

	# Back photo
	# $photo_back_filename_1 = 'ic_photo--top--Zilog--Z0800210PSC--(Z8000-CPU).png';
	# $photo_back_source_1 = 'CPU Grave Yard';
	# $photo_back_copyright_1 = 'Creative Commons BY-SA 3.0';
	# $photo_back_comments_1 = '';
	my $ic_photo_back_text = '';
	if( $photo_back_filename_1 eq '' ){
		$ic_photo_back_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<p style="font-size: 16px;">
							Chip Photo<br />
							(bottom)<br /><br />
							</p><p style="font-size: 12px;">
							is unavailable.<br />
							If you have one, please <a href="$script_name_g?page=upload">upload</a> one.
							</p>
						</div>
					</td>
Endhtml
	}else{
		my $source_text = '';
		my $copyright_text = '';
		my $comment_text = '';
		if( $photo_back_source_1 eq '' ){
			$source_text = '';
		}else{
			$source_text = "Source: $photo_back_source_1<br />";
		}
		if( $photo_back_copyright_1 eq '' ){
			$copyright_text = '';
		}else{
			$copyright_text = "Licence: $photo_back_copyright_1<br />";
		}
		if( $photo_back_comment_1 eq '' ){
			$comment_text = '';
		}else{
			$comment_text = "Comments: $photo_back_comment_1<br />";
		}
		$ic_photo_back_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<img src="http://cpu-db.info/images/photos/sm/$photo_back_filename_1\_sm.jpg" width="300" />
						</div>
						<div>
							<p style="font-size: 12px;">
							$source_text
							$copyright_text
							$comment_text
							</p>
						</div>
					</td>
Endhtml
	}

	# die photo
	# $photo_die_filename_1 = 'ic_photo--top--Zilog--Z0800210PSC--(Z8000-CPU).png';
	# $photo_die_source_1 = 'CPU Grave Yard';
	# $photo_die_copyright_1 = 'Creative Commons BY-SA 3.0';
	# $photo_die_comments_1 = '';
	my $ic_photo_die_text = '';
	if( $photo_die_filename_1 eq '' ){
		$ic_photo_die_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<p style="font-size: 16px;">
							Die photo<br />
							</p><p style="font-size: 12px;">
							is unavailable.<br /><br />
							If you have one, please <a href="$script_name_g?page=upload">upload</a> one.
							</p>
						</div>
					</td>
Endhtml
	}else{
		my $source_text = '';
		my $copyright_text = '';
		my $comment_text = '';
		if( $photo_die_source_1 eq '' ){
			$source_text = '';
		}else{
			$source_text = "Source: $photo_die_source_1<br />";
		}
		if( $photo_die_copyright_1 eq '' ){
			$copyright_text = '';
		}else{
			$copyright_text = "Licence: $photo_die_copyright_1<br />";
		}
		if( $photo_die_comment_1 eq '' ){
			$comment_text = '';
		}else{
			$comment_text = "Comments: $photo_die_comment_1<br />";
		}
		$ic_photo_die_text =  <<Endhtml;
					<td style="border: 1px solid black; height: 340px; width:300px;">
						<div style="width:300px; height:300px;display:table-cell;vertical-align:middle;">
							<img src="http://cpu-db.info/images/photos/sm/$photo_die_filename_1\_sm.jpg" width="300" />
						</div>
						<div>
							<p style="font-size: 12px;">
							$source_text
							$copyright_text
							$comment_text
							</p>
						</div>
					</td>
Endhtml
	}


	################
	# Polishing
	#
	
	
	# Voltage
	if( $vcc_core_range =~ "4.75-5.25" || $vcc_core_range =~ "4.75 - 5.25" || $vcc_core_range =~ "4.75 to 5.25" || $vcc_core_range =~ "5V +/- 5%" ){
		$vcc_core_range = "5 V &#177; 5%";
	}elsif( $vcc_core_range =~ "4.5-5.5" || $vcc_core_range =~ "4.5 - 5.5" || $vcc_core_range =~ "4.5 to 5.5" || $vcc_core_range =~ "5V +/- 10%" ){
		$vcc_core_range = "5 V &#177; 10%";
	}elsif( $vcc_core_range =~ "3.135-3.465" || $vcc_core_range =~ "3.135 - 3.465" || $vcc_core_range =~ "3.135 to 3.465" || $vcc_core_range =~ "3.3V +/- 5%" ){
		$vcc_core_range = "3.3 V &#177; 5%";
	}

	$vcc_core_range =~ s/([0-9])-([0-9])/$1 to $2/;
	$vcc_core_range =~ s/([0-9]) - ([0-9])/$1 to $2/;
	$vcc_core_range =~ s/([0-9]) – ([0-9])/$1 to $2/;
	$vcc_core_range =~ s/([0-9])–([0-9])/$1 to $2/;
	$vcc_core_range =~ s/([0-9])V$/$1 V/;	
	$vcc_core_typ =~ s/([0-9])V$/$1 V/;
	$vcc_secondary  =~ s/([0-9])V$/$1 V/;
	$vcc_tertiary  =~ s/([0-9])V$/$1 V/;
	$vcc_i_o   =~ s/([0-9])V$/$1 V/;

	# Subsititution
	$temperature_range =~ s/â€“/-/;
	$instruction_set =~ s/X86/x86/;
	$clock_multiplier =~ s/([0-9])$/$1x/;

	$l1_data_cache  =~ s/Ext /External, /;
	$l1_instruction_cache  =~ s/Ext /External, /;
	$l1_unified_cache  =~ s/Ext /External, /;
	$l2_cache  =~ s/Ext /External, /;
	$l3_cache  =~ s/Ext /External, /;

	# Die
	$package_size	=~ s/mm\^2/ mm<sup>2<\/sup>/;
	$package_size	=~ s/mm\^3/ mm<sup>3<\/sup>/;
	$package_size	=~ s/cm\^2/ cm<sup>2<\/sup>/;
	$package_size	=~ s/cm\^3/ cm<sup>3<\/sup>/;
	$die_size 		=~ s/mm\^2/ cm<sup>2<\/sup>/;
	$transistor_count =~ s/([0-9])M$/$1 million/;
	$transistor_count =~ s/([0-9])k$/$1 thousand/;

	# MHz's
	$frequency_min =~ s/MHz/ MHz/;
	$frequency_min =~ s/kHz/ kHz/; $frequency_min =~ s/  / /g;
	$frequency_ext =~ s/MHz/ MHz/;
	$frequency_ext =~ s/kHz/ kHz/; $frequency_ext =~ s/  / /g;	
	$frequency_max_typ =~ s/MHz/ MHz/;
	$frequency_max_typ =~ s/kHz/ kHz/; $frequency_max_typ =~ s/  / /g;
	$actual_bus_frequency =~ s/MHz/ MHz/;
	$actual_bus_frequency =~ s/kHz/ kHz/;$actual_bus_frequency =~ s/  / /g;
	$effective_bus_frequency =~ s/MHz/ MHz/;
	$effective_bus_frequency =~ s/kHz/ kHz/; $effective_bus_frequency =~ s/  / /g;
	$bus_bandwidth =~ s/([0-9])([A-Z])iB\/s$/$1 $2iB\/s/;
	if( $frequency_ext ne '' ){
		$frequency_ext_text="<tr>\n\t\t\t\t\t<td class='table_param'>Frequency (ext):</td>\n\t\t\t\t\t<td class='table_value'>$frequency_ext</td>\n\t\t\t\t</tr>";
	}else{
		$frequency_ext_text="";
	}
	if( $frequency_min ne '' ){
		$frequency_min_text="<tr>\n\t\t\t\t\t<td class='table_param'>Frequency (min):</td>\n\t\t\t\t\t<td class='table_value'>$frequency_min</td>\n\t\t\t\t</tr>";
	}else{
		$frequency_min_text="";
	}


	# Data
	$l1_data_cache  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$l1_instruction_cache  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$l1_unified_cache  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$l2_cache  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$l3_cache  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$rom_internal  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$ram_internal =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$ram_max =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	$virtual_memory_max  =~ s/([0-9])([A-Z])iB$/$1 $2iB/;
	
	$l1_data_cache  =~ s/([0-9])B$/$1 Bytes/;
	$l1_instruction_cache  =~ s/([0-9])B$/$1 Bytes/;
	$l1_unified_cache  =~ s/([0-9])B$/$1 Bytes/;
	$rom_internal  =~ s/([0-9])B$/$1 Bytes/;
	$ram_internal =~ s/([0-9])B$/$1 Bytes/;
	$l1_data_cache  =~ s/([0-9])b$/$1 Bits/;
	$l1_instruction_cache  =~ s/([0-9])b$/$1 Bits/;
	$l1_unified_cache  =~ s/([0-9])b$/$1 Bits/;
	$rom_internal  =~ s/([0-9])b$/$1 Bits/;
	$ram_internal =~ s/([0-9])b$/$1 Bits/;


	# temp
	$temperature_range =~ s/C/ C/; 
	$temperature_range =~ s/F/ F/; 
	$temperature_range =~ s/ - / to /; 
	$temperature_range =~ s/ – / to /;
	$temperature_range =~ s/–/ to /;
	$temperature_range =~ s/0-/0 to /; 
	$temperature_range =~ s/5-/5 to /; $temperature_range =~ s/  / /g;
	if( $temperature_grade eq '' ){
		if( $temperature_range eq '0 to 70 C' ){
			$temperature_grade='Commercial';
		}elsif( $temperature_range eq '-40 to 85 C' ){
			$temperature_grade='Industrial';
		}elsif( $temperature_range eq '-55 to 125 C' ){
			$temperature_grade='Millitary';
		}else{
			$temperature_grade='?';
		}
	}


	# buses
	$architecture =~ s/([0-9])$/$1-bit/;
	$data_bus_ext =~ s/([0-9])$/$1-bit/;
	$address_bus =~ s/([0-9])$/$1-bit/;
	
	# power
	$power_min =~ s/uW/ µW/;
	$power_min =~ s/([a-z]?)W/ $1W/; $power_min =~ s/  / /g;

	$power_typ =~ s/uW/ µW/;
	$power_typ =~ s/([a-z]?)W/ $1W/; $power_typ =~ s/  / /g;

	$power_max =~ s/uW/ µW/;
	$power_max =~ s/([a-z]?)W/ $1W/; $power_max =~ s/  / /g;

	$power_thermal_design =~ s/uW/ µW/;
	$power_thermal_design =~ s/([a-z]?)W/ $1W/; $power_thermal_design =~ s/  / /g;


	# $ =~ s/MHz/ MHz/; $ =~ s/  / /g;
	# $ =~ s/kHz/ kHz/; $ =~ s/  / /g;

	


	# Alternative labels
	if( $alternative_label_1 eq '?' ){
		$alt_labels = '?';
	}elsif( $alternative_label_2 eq '?' ){
		$alt_labels = "$alternative_label_1";
	}elsif( $alternative_label_3 eq '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2";
	}elsif( $alternative_label_4 eq '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label3";
	}elsif( $alternative_label_5 eq '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4";
	}elsif( $alternative_label_6 eq '?' ){
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4, $alternative_label_5";
	}else{
		$alt_labels = "$alternative_label_1, $alternative_label_2, $alternative_label_3, $alternative_label_4, $alternative_label_5, $alternative_label_6";
	}
	if( $alt_labels eq '?' ){
		$alt_labels='';
	}else{
		$alt_labels="</tr><tr>\n\t\t\t<td class='table_param'>Alternative Lables:</td>\n\t\t\t\t<td class='table_value'>$alt_labels</td>";
	}


	# References
	$reference_1 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_2 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_3 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_4 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_5 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_6 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_7 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;
	$reference_8 =~ s!(http://[^\s]+)!<a href="$1">$1</a>!gi;

	if( not( $reference_1 || $reference_2 || $reference_3 || $reference_4 || $reference_5 || $reference_6 || $reference_7 || $reference_8) ){
		$ref_warning = "<p class=\"warning_message\">This page has no references, if you have any please <a href=\"$script_name_g?page=contrib\">add one</a></p>";
		$refs = "$ref_warning";
	}elsif( $reference_1 ){
		$refs = "$reference_1";
		if( $reference_2 ){
			$refs .= "\n<br />$reference_2";
		}
		if( $reference_3 ){
			$refs .= "\n<br />$reference_3";
		}
		if( $reference_4 ){
			$refs .= "\n<br />$reference_4";
		}
		if( $reference_5 ){
			$refs .= "\n<br />$reference_5";
		}
		if( $reference_6 ){
			$refs .= "\n<br />$reference_6";
		}
		if( $reference_7 ){
			$refs .= "\n<br />$reference_7";
		}
		if( $reference_8 ){
			$refs .= "\n<br />$reference_8";
		}
	}


	# Cache display
	my $CACHE_TEXT = '';

	$CACHE_TEXT .= <<Endhtml;
			<table width="100%">
Endhtml
	if( $l1_data_cache eq "none" && $l1_instruction_cache eq "none" && $l1_unified_cache eq "none" && $l2_cache eq "none" && $l3_cache eq "none"){
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>Cache:</td>
								<td class='table_value'>none</td>
							</tr>
Endhtml
	}elsif( $l1_data_cache eq "none" && $l1_instruction_cache eq "none" && $l1_unified_cache eq "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L1 cache:</td>
								<td class='table_value'>none</td>
							</tr>
Endhtml
	}else{
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L1 data cache:</td>
								<td class='table_value'>$l1_data_cache</td>
							</tr>
Endhtml
		if( $l1_data_cache ne "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr> 
					  			<td class='table_param'>L1 data cache specs</td>
								<td class='table_value'>$l1_data_associativity</td>
							</tr>
Endhtml
		}
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L1 instruction cache:</td>
								<td class='table_value'>$l1_instruction_cache</td>
							</tr>
Endhtml
		if( $l1_instruction_cache ne "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr> 
					  			<td class='table_param'>L1 instruction cache specs:</td>
								<td class='table_value'>$l1_instruction_associativity</td>
							</tr>
Endhtml
		}
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L1 unified cache:</td>
								<td class='table_value'>$l1_unified_cache</td>
							</tr>
Endhtml
		if( $l1_unified_cache ne "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr> 
					  			<td class='table_param'>L1 unified cache specs:</td>
								<td class='table_value'>$l1_unified_associativity</td>
							</tr>
Endhtml
		}
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L2 cache:</td>
								<td class='table_value'>$l2_cache</td>
							</tr>
Endhtml
		if( $l2_cache ne "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr> 
					  			<td class='table_param'>L2 cache specs:</td>
								<td class='table_value'>$l2_associativity</td>
							</tr>
Endhtml
		}
		$CACHE_TEXT .= <<Endhtml;
							<tr>
					  			<td class='table_param'>L3 cache:</td>
								<td class='table_value'>$l3_cache</td>
							</tr>
Endhtml
		if( $l3_cache ne "none" ){
		$CACHE_TEXT .= <<Endhtml;
							<tr> 
					  			<td class='table_param'>L3 cache specs:</td>
								<td class='table_value'>$l3_associativity</td>
							</tr>
Endhtml
		}
	}
	$CACHE_TEXT .= <<Endhtml;
		</table>
Endhtml

	# Missing Info level
	if( $missing_info_level > 3 ){
		$missing_info_message = "\t<p class=\"warning_message\">This page is missing basic information about the chip, if you can fill in any details, please <a href=\"$script_name_g?page=contrib\">add them</a> with references</p>\n";
	}elsif($ref_warning ne ''){
		$missing_info_message = $ref_warning;
	}


	$html_code .= <<Endhtml;
	<h3><a href="$script_name_g?page=m&manuf=$manuf">$manuf</a> - <a href="$script_name_g?page=f&family=$family">$family</a></h3>
	
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
		  			<td class='table_param_long'>Frequency(typ):</td>
					<td class='table_value'>$frequency_max_typ</td>
				</tr>
				$frequency_ext_text
				<tr>
		  			<td class='table_param_long'>Clock multiplier:</td>
					<td class='table_value'>$clock_multiplier</td>
				</tr>
				<tr>
		  			<td class='table_param_long'>Bus frequency, actual(max):</td>
					<td class='table_value'>$actual_bus_frequency</td>
				</tr>
				<tr>	
		  			<td class='table_param_long'>Bus frequency, effective(max):</td>
					<td class='table_value'>$effective_bus_frequency</td>
				</tr>
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
				<tr>
		  			<td class='table_param'>Secondary voltage:</td>
					<td class='table_value'>$vcc_secondary</td>
				</tr>
				<tr>
		  			<td class='table_param'>Tersiary voltage:</td>
					<td class='table_value'>$vcc_tertiary</td>
				</tr>
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
				<tr>
		  			<td class='table_param'>Instruction set extensions:</td>
					<td class='table_value'>$instruction_set_extensions</td>
				</tr>
				<tr>
		  			<td class='table_param'>Additional instructions:</td>
					<td class='table_value'>$additional_instructions</td>
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
					<td class='table_value'>$process_technology	</td>
				</tr>
				<tr>
		  			<td class='table_param'>Metal layers:</td>
					<td class='table_value'>$metal_layers </td>
				</tr>
				<tr>
		  			<td class='table_param'>Metal type:</td>
					<td class='table_value'>$metal_type</td>
				</tr>
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
		  			<td class='table_value'>&oplus; $refs</td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>	

	</div>

Endhtml

	
	# fix odd chars
	$html_code =~ s/Î¼/µ/g;
	$html_code =~ s/â€œ/\"/g;
	$html_code =~ s/â€/\"/g;
	$html_code =~ s/â€“/-/g;
	$html_code =~ s/â€™/\'/g;
	$html_code =~ s/â€¦/.../g;
	$html_code =~ s/–/-/g;
	$html_code =~ s/\“/\"/g;
	$html_code =~ s/\”/\"/g;


	return $html_code;
}



sub display_manuf_list{ # page=cat&type=manuf
	my $html_code = '';
	my @manuf_array = get_manuf_list_alphabetical();

	$html_title_g = 'cpu-db.info - Manufacture List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, manufacturer';
	
	$html_code .= "\t<h1>Manufacturer list</h1>\n";

	foreach $manuf (@manuf_array) {
		$html_code .= "\t<a href=\"$script_name_g?page=m&manuf=$manuf\">$manuf</a> <br />\n";
	}

	return $html_code;
}


sub display_family_page{ # page=f
	my $html_code = '';
	my $family = $_[0];

	$html_title_g = "cpu-db.info - $family Family";
	$html_keywords_g = "CPU, MCU, DSP, BSP, database, $family, family";

	my @manuf_list = get_manufs_of_family_list($family);

	$html_code .= "	<h1>$family</h1>\n";
	$html_code .= "	<h3>List of manufacturers</h3>\n";

	foreach my $manuf (sort @manuf_list){
		$html_code .= "\t\t<a href=\"$script_name_g?page=mf&manuf=$manuf&family=$family\">$manuf - $family</a> <br />\n";
	}

	return $html_code;
}


sub display_families_list{ # page=cat&type=families
	my $html_code = '';
	
	$html_title_g = 'cpu-db.info - CPU Family List';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, family';

	my @fam_list_cpu = get_family_list_cpu();
	my @fam_list_mcu = get_family_list_mcu();
	my @fam_list_dsp = get_family_list_dsp();
	my @fam_list_bsp = get_family_list_bsp();

	#my $ref = $sth->fetchall_arrayref;
	$html_code .= <<Endhtml;
	<h1>Processor Families</h1>
	<table>
		<tr>
			<td class="family_table_td">
Endhtml
	$html_code .= "				<h2>CPU</h2>\n";
	foreach $row ( sort @fam_list_cpu ) {
		if($row ne ''){
			$html_code .= "			<a href=\"$script_name_g?page=f&family=$row\">$row</a><br />\n";
		}
	}
	$html_code .= "			</td><td class=\"family_table_td\">\n";
	$html_code .= "			<h2>MCU</h2>\n";
	foreach $row ( sort @fam_list_mcu ) {
		if($row ne ""){
			$html_code .= "			<a href=\"$script_name_g?page=f&family=$row\">$row</a><br />\n";
		}
	}
	$html_code .= "			</td><td class=\"family_table_td\">\n";
	$html_code .= "			<h2>DSP</h2>\n";
	foreach $row ( sort @fam_list_dsp ) {
		if($row ne ''){
			$html_code .= "			<a href=\"$script_name_g?page=f&family=$row\">$row</a><br />\n";
		}
	}
	$html_code .= "			</td><td class=\"family_table_td\">\n";
	$html_code .= "			<h2>BSP</h2>\n";
	foreach $row ( sort @fam_list_bsp ) {
		if($row ne ''){
			$html_code .= "			<a href=\"$script_name_g?page=f&family=$row\">$row</a><br />\n";
		}
	}
	$html_code .= <<Endhtml;
			</td>
		</tr>
	</table>
Endhtml

	return $html_code;
}


sub display_todo_page{ # page=
	my $html_code = '';

	$html_title_g = 'cpu-db.info - TODO Page';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, todo';

	open FILE, $todo_file_loc_g;
	print "	<pre>\n";
	while (<FILE>) { 
		print $_; 
	}
	print "	</pre>\n";
	close(FILE);

	return $html_code;
}


sub display_download_page { # page=download
	my $html_code = '';

	$html_title_g = 'cpu-db.info - Download Database';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, download';

	$html_code .= <<Endhtml;

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

Endhtml
	
	return $html_code;
}




sub display_contrib_upload_page { # page=contrib_upload
	my $html_code = '';
	
	$html_title_g = 'cpu-db.info - Upload DB Update';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, upload';

	$html_code .= <<Endhtml;
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

Endhtml
	
	return $html_code;
}

sub display_contrib_page { # page=contrib
	my $html_code = '';

	$html_title_g = 'cpu-db.info - Contribute to the Database';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database, contribute';
	
	$html_code .= <<Endhtml;

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


Endhtml

	return $html_code;
}

sub display_contact_confirm_page { # page=contact_confirm
	my $html_code = '';
	
	$html_title_g = 'cpu-db.info - Email Confirmed';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, database';
	
	$html_code .= <<Endhtml;
	
	<h1>Email has been sent.</h1>
Endhtml

	return $html_code;
}


sub display_contact_page { # page=contact
	my $html_code = '';

	$html_title_g = 'cpu-db.info - Contact Page';
	$html_keywords_g = 'CPU, MCU, DSP, BSP, contact';

	$html_code .= <<Endhtml;

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
Endhtml

	return $html_code;
}



sub display_header {
	my $html_code = '';

	$html_code .= "content-type: text/html \n\n"; #HTTP HEADER

	$html_code .= <<Endhtml;
<!DOCTYPE html>
<html>
<head>
	<title>HTML_HEAD_TITLE</title>
	<meta name="description" content="A Database for CPU, MCU, DSP, and BSP information" />
	<meta name=keywords content="HTML_HEAD_KEYWORDS" />
  <style>  
	#bode {  
    	margin: 0 auto;  
		border: 1px;
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
	
<h1>cpu-db.info</h1>

<a href="http://cpu-db.info">Home</a> | <a href="$script_name_g?page=cat&type=chips">Chips</a> | <a href="$script_name_g?page=cat&type=manuf">Manufacturer</a> | <a href="$script_name_g?page=cat&type=families">Families</a> | <a href="$script_name_g?page=download">Download DB</a> | <a href="$script_name_g?page=contrib">Help Out</a> | <a href="$script_name_g?page=contact">Contact</a> <br /><br />

	<div id="bode">
Endhtml
	return $html_code;
}


sub display_footer {
	my $html_code = '';

	$html_code .= <<Endhtml;

	</div>
	<br />
	Copyleft cpu-db.info 2012-2013, brought to you by <a href="http://www.happytrees.org/chips">CPU Grave Yard</a><br />

	<!-- GoStats JavaScript Based Code -->
<script type="text/javascript" src="http://gostats.com/js/counter.js"></script>
<script type="text/javascript">_gos='c4.gostats.com';_goa=378322;
_got=6;_goi=28;_gol='GoStats stats counter';_GoStatsRun();</script>
<noscript><a target="_blank" title="GoStats stats counter" 
href="http://gostats.com"><img alt="GoStats stats counter" 
src="http://c4.gostats.com/bin/count/a_378322/t_6/i_28/counter.png" 
style="border-width:0" /></a></noscript><a target="_blank" href="http://c4.gostats.com/click/378322/web-counter/stats-home" 
style="font: 9px sans-serif" title="GoStats stats counter">stats</a> 
<!-- End GoStats JavaScript Based Code -->
<br />
</body>
</html>
Endhtml
	return $html_code;
}


##################### Display (end) ###################
#######################################################












#######################################################
################## Sorting page #######################

sub main_page {
	my $html_code='';

	$html_code .= display_header();

	if( $cgi_input{'page'} eq '' ){
		$html_code .= display_home_page();
	}elsif( $cgi_input{'page'} eq 'm' ){
		$html_code .= display_manuf_page($cgi_input{'manuf'});
	}elsif( $cgi_input{'page'} eq 'f' ){
		$html_code .= display_family_page($cgi_input{'family'});
	}elsif( $cgi_input{'page'} eq 'mf' ){
		$html_code .= display_manuf_family_page($cgi_input{'manuf'},$cgi_input{'family'});
	}elsif( $cgi_input{'page'} eq 'c' ){
		$html_code .= display_single_chip_info_g($cgi_input{'manuf'},$cgi_input{'part'});
	}elsif( $cgi_input{'page'} eq 'download' ){
		$html_code .= display_download_page();
	}elsif( $cgi_input{'page'} eq 'contrib' ){
		$html_code .= display_contrib_page();
	}elsif( $cgi_input{'page'} eq 'contrib_upload' ){
		$html_code .= display_contrib_upload_page();
	}elsif( $cgi_input{'page'} eq 'GIT_howto' ){
		$html_code .= display_GIT_page();
	}elsif( $cgi_input{'page'} eq 'contact' ){
		$html_code .= display_contact_page();
	}elsif( $cgi_input{'page'} eq 'contact_confirm' ){
		$html_code .= display_contact_confirm_page();
	}elsif( $cgi_input{'page'} eq 'TODO' ){
		$html_code .= display_todo_page();
	}elsif( $cgi_input{'page'} eq 'cat' ){
		if( $cgi_input{'type'} eq 'chips' ){
			$html_code .= display_chips_page();
		}elsif( $cgi_input{'type'} eq 'manuf' ){
			$html_code .= display_manuf_list();
		}elsif( $cgi_input{'type'} eq 'families' ){
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




################ Sorting pages (end) ##################
#######################################################


#######################################################
################## Initialization #####################



$html_code_g = '';
$html_title_g = 'cpu-db.info - a database for information on CPU, MCU, DSP, and BSP';
$html_keywords_g = 'CPU, MCU, DSP, BSP, database';
$script_name_g = ''; #$ENV{'SCRIPT_NAME'};


# Gets input args
%cgi_input = &read_input; #get input
&load_sql_db();

# $speed_up = not($cgi_input{'page'} eq '' || $cgi_input{'page'} eq 'TODO' || $cgi_input{'page'} eq 'contact' || $cgi_input{'page'} eq 'TODO');

# if(  not($cgi_input{'page'} eq '') ){
	# @cpu_db = import_csv_db($database_location);
	# &get_col_labels();
	# &get_chip_list;
# }


$html_code_g .= main_page();
$html_code_g =~ s/HTML_HEAD_TITLE/$html_title_g/;
$html_code_g =~ s/HTML_HEAD_KEYWORDS/$html_keywords_g/;
print $html_code_g;
# print " >> $manuf_families_g{ 'Siemens' }{ 'CPU' }{ 'R3000' } \n";
# print "Count = $col_cnt_g";

# my @array_2d=@cpu_db;
	# for(my $i = 0; $i <= $#array_2d; $i++){
	   # for(my $j = 0; $j <= $#{$array_2d[0]} ; $j++){
		  # print "$array_2d[$i][$j], ";
	   # }
	   # print "\n";
	# 
print "\n";
