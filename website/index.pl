#!/usr/bin/perl 



use File::stat;
use Time::localtime;
use Switch;





#############################
# Config
#

$database_location='cpu-db.csv';








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









#############Import DB (begin) ####################

#open file
sub open_file { 
	my $fileName = $_[0];
	open(FILEVARIABLE, "< $fileName");
	@fileLines= <FILEVARIABLE>;
	close(FILEVARIABLE);
	return @fileLines;
}


sub import_csv_db {
	my $database = $_[0];
	my @file_lines = open_file($database);
	my $line = '';
	my $x = 0;
	my $y = 0;
	foreach $line (@file_lines) {
		$x = 0;
		# print "$line \n";
		foreach $cell (split(',', $line)) {
			$database[$x][$y] = $cell;
			$x++
		}
		$y++;
	}
	return @database;
}




sub bbl_sort {
	# my (@a, @b) = @_;
    my @array =  @_;
	# print_2d(@array);
	my $row_sort = 0;
	# my $array2 =  @{$_[1]};
    my $not_complete = 1;
    my $index;
    my $len = ($#{$array[$row_sort]} - 2);
    # print "|sub=" . scalar @array . " -- " . scalar @array2 . "|";
    while ($not_complete) {
        $not_complete = 0;
        foreach $index (0 .. $len) {
            if ($array[$row_sort][$index] > $array[$row_sort][$index + 1]) {
                my $temp = $array[0][$index + 1];
				my $temp2 = $array[1][$index + 1];
                $array[0][$index + 1] = $array[0][$index];
				$array[1][$index + 1] = $array[1][$index];
                $array[0][$index] = $temp;
				$array[1][$index] = $temp2;
                $not_complete = 1;
				# print @array2[$index]; 
            }
        }
    }
	return (@array);
}



################# Process data (begin) ################

sub get_col_labels {
	my $col=0;
	$col_cnt_g = 0;
	while ( exists($cpu_db[$col][0]) ) {
		# print "$cpu_db[$col][0] ? "; # print &chipData2(1,$col) . ", ";
		switch ( $cpu_db[$col][0] ) {
			case "Manufacturer"		{ $col_manuf_g=$col }
			case "Family"			{ $col_family_g=$col }
			case "Part #"			{ $col_part_g=$col }
			case "Alternative Label 1"		{ $col_alt_lable1_g=$col }
			case "Alternative Label 2"		{ $col_alt_lable2_g=$col }
			case "Alternative Label 3"		{ $col_alt_lable3_g=$col }
			case "Alternative Label 4"		{ $col_alt_lable4_g=$col }
			case "Alternative Label 5"		{ $col_alt_lable5_g=$col }
			case "Empty"			{ $col_empty_g=$col }
			case "Chip Type"		{ $col_chip_type_g=$col }
			case "Sub-Family"		{ $col_sub_family_g=$col }
			case "Model number"		{ $col_model_num_g=$col }
			case "Core"				{ $col_core_g=$col }
			case "Core designer"		{ $col_core_designer_g=$col }
			case "Microarchitecture"		{ $col_microarch_g=$col }
			case "Threads"			{ $col_threads_g=$col }
			case "CPUID"			{ $col_cpuid_g=$col }
			case "Core Count"		{ $col_core_cnt_g=$col }
			case "Architecture"		{ $col_arch_g=$col }
			case "Data Bus (ext)"	{ $col_data_bus_ext_g=$col }
			case "Address Bus"		{ $col_add_bus_g=$col }
			case "Frequency Min"			{ $col_freq_min_g=$col }
			case "Frequency Max/Typ"		{ $col_freq_max_g=$col }
			case "Actual bus frequency"		{ $col_actual_bus_freq_g=$col }
			case "Effective bus frequency"	{ $col_effective_bus_freq_g=$col }
			case "Bus bandwidth"		{ $col_bus_bandwidth_g=$col }
			case "Clock multiplier"		{ $col_clk_multiplier_g=$col }
			case "Core Stepping"		{ $col_core_stepping_g=$col }
			case "L1 data cache"		{ $col_l1_data_cache_g=$col }
			case "L1 data associativity"	{ $col_l1_data_ass_g=$col }
			case "L1 instruction cache"		{ $col_l1_instruction_cache_g=$col }
			case "L1 instruction associativity"	{ $col_l1_instruction_ass_g=$col }
			case "L1 unified cache"		{ $col_l1_unified_cache_g=$col }
			case "L1 unified associativity"		{ $col_l1_unified_ass_g=$col }
			case "L2 cache"				{ $col_l2_cache_g=$col }
			case "L2 associativity"		{ $col_l2_ass_g=$col }
			case "L3 cache"				{ $col_l3_cache_g=$col }
			case "L3 associativity"		{ $col_l3_ass_g=$col }
			case "Boot ROM"				{ $col_boot_rom_g=$col }
			case "ROM Internal"			{ $col_rom_int_g=$col }
			case "ROM Type"				{ $col_rom_type_g=$col }
			case "RAM internal"			{ $col_ram_int_g=$col }
			case "RAM max"				{ $col_ram_max_g=$col }
			case "RAM type"				{ $col_ram_type_g=$col }
			case "Virtual memory max"	{ $col_virtual_mem_max_g=$col }
			case "Package"				{ $col_package_g=$col }
			case "Package Size"			{ $col_package_size_g=$col }
			case "Package Weight"		{ $col_package_weight_g=$col }
			case "Socket"				{ $col_socket_g=$col }
			case "Transistor count"		{ $col_trans_cnt_g=$col }
			case "Process Size"		{ $col_proc_size_g=$col }
			case "Metal Layers"		{ $col_metal_layer_g=$col }
			case "Metal Type"		{ $col_metal_type_g=$col }
			case "Process technology"	{ $col_proc_tech_g=$col }
			case "Die Size"				{ $col_die_size_g=$col }
			case "Vcc range"			{ $col_vcc_range_g=$col }
			case "Vcc(typ)"				{ $col_vcc_typ_g=$col }
			case "Vcc(secondary)"		{ $col_vcc_2_g=$col }
			case "Vcc(tertiary)"		{ $col_vcc_3_g=$col }
			case "Vcc(core)"		{ $col_vcc_core_g=$col }
			case "Vcc(I/O)"			{ $col_vcc_io_g=$col }
			case "Power Min"		{ $col_power_min_g=$col }
			case "Power Typ"		{ $col_power_typ_g=$col }
			case "Power Max"		{ $col_power_max_g=$col }
			case "Power Thermal Design"		{ $col_power_therm_g=$col }
			case "Temperature range"		{ $col_temp_range_g=$col }
			case "Low Power Features"		{ $col_low_power_feat_g=$col }
			case "Instruction set"			{ $col_instruction_set_g=$col }
			case "Instruction set extensions"	{ $col_instruction_set_ext_g=$col }
			case "Additional instructions"		{ $col_additional_instructions_g=$col }
			case "Computer architecture"		{ $col_comp_arch_g=$col }
			case "ISA"		{ $col_isa_g=$col }
			case "FPU"		{ $col_fpu_g=$col }
			case "On-chip peripherals"		{ $col_onchip_peripherals_g=$col }
			case "Features"			{ $col_features_g=$col }
			case "Release date"		{ $col_date_g=$col }
			case "Initial price"	{ $col_price_g=$col }
			case "Applications"		{ $col_applications_g=$col }
			case "Military Spec"	{ $col_mil_g=$col }
			case "Comments"			{ $col_comments_g=$col }
			case "Reference 1"		{ $col_ref1_g=$col }
			case "Reference 2"		{ $col_ref2_g=$col }
			case "Reference 3"		{ $col_ref3_g=$col }
			case "Reference 4"		{ $col_ref4_g=$col }
			case "Reference 5"		{ $col_ref5_g=$col }
			case "Reference 6"		{ $col_ref6_g=$col }
			case "Reference 7"		{ $col_ref7_g=$col }
			case "Reference 8"		{ $col_ref8_g=$col }

			# case ""	{$col_ = $col}
			# case ""	{$col_ = $col}
			# case ""	{$col_ = $col}
			# case ""	{$col_ = $col}
			else {}
		}
		$col++;
	}
	$col_cnt_g = $col;
}

################# Process data (end) ################



sub get_chip_list {
	my $row=0;
	my @manuf_list = ();
	my @family_list = ();
	@manuf_list_g = ();
	@family_list_g = ();
	$total_manuf_count_g=0;
	$total_family_count_g=0;
	$total_chip_count_g=0;
	%manuf_families_g = ();

	while ( exists($cpu_db[0][$row]) ) {
		#Makes a list of manuf and fams
		$manuf_list[$row] = $cpu_db[$col_manuf_g][$row];
		$family_list[$row] = $cpu_db[$col_family_g][$row];
	
		$manuf_families_g{ $cpu_db[$col_manuf_g][$row] }{ $cpu_db[$col_chip_type_g][$row] }{ $cpu_db[$col_family_g][$row] } = 1;

		# print "$manuf_list[$row] $family_list[$row] $manuf_families_g{ $cpu_db[$col_manuf_g][$row] }{ $cpu_db[$col_chip_type_g][$row] }{ $cpu_db[$col_family_g][$row] } \n";

		# print " 	$row $cpu_db[0][$row] $col_manuf_g $col_family_g $manuf_list[$row] $family_list[$row] \n";

		# This makes a list and count of manuf
		if ($manuf_list_count_g{$cpu_db[$col_manuf_g][$row]} eq '') {
			$manuf_list_count_g{$cpu_db[$col_manuf_g][$row]} =1;
		} else {
			$manuf_list_count_g{$cpu_db[$col_manuf_g][$row]}++;
		}

		# Count families for this manufacturer
		# if ( &chipData2($row,$colManuf) eq $data{'manufacturer'} ) {
			# if (&chipData2($row,$colFamily) eq '') {
				# $fam='Other';
			# } else {$fam=&chipData2($row,$colFamily);}
			# if ( $manufFamilyCountGlobal{$fam} eq '' ) {
				# $manufFamilyCountGlobal{$fam} = 1;
			# } else {
				# $manufFamilyCountGlobal{$fam}++;
			# }
		# }
		$row++;
	}
	$total_chip_count_g=$row;

	undef %saw;
	@saw{@manuf_list} = ();
	@manuf_list_g = sort keys %saw;  
	undef %saw;
	@saw{@family_list} = ();
	@family_list_g = sort keys %saw;  
	$total_manuf_count_g=$#manuf_list_g+1;
	$total_family_count_g=$#family_list_g+1;

	@manuf_families = keys %manuf_family_count_g;
	# &sort_manuf_families(%manuf_family_count_g);
}


#######################################################
####################### Display #######################

sub display_chips_page {
	my $html_code = "";

	foreach my $manuf (sort keys %manuf_families_g) {
		if( $manuf ne '' ) {
        	$html_code .= "<h3><a href=\"index.pl?page=m&manuf=$manuf\">$manuf</a></h3>\n";
			$html_code .= "<div id=\"lists\">\n";	
			foreach my $chip_type (sort keys %{$manuf_families_g{ $manuf }}) {
				if( $chip_type ne '' ){
					$html_code .= "  $chip_type<br />\n";
					$html_code .= "<div id=\"lists\">\n";				
					foreach my $family (sort keys %{$manuf_families_g{ $manuf }{ $chip_type }}) {
						if( $family ne '' ){
							$html_code .= "\t<a href=\"index.pl?page=mf&manuf=$manuf&fam=$family\">$family</a>,";
						}
					}
				$html_code .= "</div><br />\n";					
				}
			$html_code .= "<br />\n";
			}
		$html_code .= "</div>\n";			
		}
		$html_code .= "<br />\n";
	}
	return $html_code;
}

sub display_manuf_page {
	my $manuf = $_[0];
	my $row = 0;
	my $html_code = '';
	my $cpu_cnt = 0;
	my $mcu_cnt = 0;
	my $dsp_cnt = 0;
	my $fpu_cnt = 0;
	my $others_cnt = 0;
	my @cpu_list = ();
	my @mcu_list = ();
	my @dsp_list = ();
	my @fpu_list = ();
	my @others_list = ();

	foreach my $chip_type (keys %{$manuf_families_g{ $manuf }}) {
		if( $chip_type ne '' ){
   			foreach my $family (keys %{$manuf_families_g{ $manuf }{ $chip_type }}) {
				if( $family ne '' ){
					if( $chip_type eq 'CPU' ){
						$cpu_list[$cpu_cnt] = $family;
						$cpu_cnt++;
					}elsif( $chip_type eq 'BSP' ){
						$bsp_list[$bsp_cnt] = $family;
						$bsp_cnt++;
					}elsif( $chip_type eq 'MCU' ){
						$mcu_list[$mcu_cnt] = $family;
						$mcu_cnt++;
					}elsif( $chip_type eq 'DSP' ){
						$dsp_list[$dsp_cnt] = $family;
						$dsp_cnt++;
					}elsif( $chip_type eq 'FPU' ){
						$fpu_list[$fpu_cnt] = $family;
						$fpu_cnt++;
					}else{
						$others_list[$others_cnt] = $family;
						$others_cnt++;
					}
				}
			}
		}
	}

	# while( exists($cpu_db[0][$row]) ){
		# if( $cpu_db[$col_manuf_g][$row] eq $manuf ){
			# if( $cpu_db[$col_chip_type_g][$row] eq 'CPU' ){
				# $cpu_list[$cpu_cnt] = $row;
				# $cpu_cnt++;
			# }elsif( $cpu_db[$col_chip_type_g][$row] eq 'MCU' ){
				# $mcu_list[$mcu_cnt] = $row;
				# $mcu_cnt++;
			# }elsif( $cpu_db[$col_chip_type_g][$row] eq 'DSP' ){
				# $dsp_list[$dsp_cnt] = $row;
				# $dsp_cnt++;
			# }elsif( $cpu_db[$col_chip_type_g][$row] eq 'BSP' ){
				# $bsp_list[$bsp_cnt] = $row;
				# $bsp_cnt++;
			# }elsif( $cpu_db[$col_chip_type_g][$row] eq 'FPU' ){
				# $fpu_list[$fpu_cnt] = $row;
				# $fpu_cnt++;
			# }else{
				# $others_list[$others_cnt] = $row;
				# $others_cnt++;
			# }
		# }
		# $row++;
	# }


	$html_code .= "<h1>$manuf</h1><br />\n";

	$html_code .= "<h3>CPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $cpu (@cpu_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$cpu\">$cpu</a><br />\n";
	}
	$html_code .= "</div>\n";
	
	$html_code .= "<br /><br /><h3>MCUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";	
	foreach $mcu (@mcu_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$mcu\">$mcu</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>DSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $dsp (@dsp_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$dsp\">$dsp</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>BSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $bsp (@bsp_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$bsp\">$bsp</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>FPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $fpu (@fpu_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$fpu\">$fpu</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>Other chips</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $others (@others_list){
		$html_code .= "<a href=\"index.pl?page=mf&manuf=$manuf&fam=$others\">$others</a><br />\n";
	}
	$html_code .= "</div>\n";


	return $html_code;
}


sub display_manuf_family_page {
	my $manuf = $_[0];
	my $family = $_[1];
	my $html_code = '';
	my $row = 0;
	my $cpu_cnt = 0;
	my $mcu_cnt = 0;
	my $dsp_cnt = 0;
	my $fpu_cnt = 0;
	my $others_cnt = 0;
	my @cpu_list = ();
	my @mcu_list = ();
	my @dsp_list = ();
	my @fpu_list = ();
	my @others_list = ();

	while( exists($cpu_db[0][$row]) ){
		if( $cpu_db[$col_manuf_g][$row] eq $manuf && $cpu_db[$col_family_g][$row] eq $family ){
			if( $cpu_db[$col_chip_type_g][$row] eq 'CPU' ){
				$cpu_list[$cpu_cnt] = $row;
				$cpu_cnt++;
			}elsif( $cpu_db[$col_chip_type_g][$row] eq 'MCU' ){
				$mcu_list[$mcu_cnt] = $row;
				$mcu_cnt++;
			}elsif( $cpu_db[$col_chip_type_g][$row] eq 'DSP' ){
				$dsp_list[$dsp_cnt] = $row;
				$dsp_cnt++;
			}elsif( $cpu_db[$col_chip_type_g][$row] eq 'BSP' ){
				$bsp_list[$bsp_cnt] = $row;
				$bsp_cnt++;
			}elsif( $cpu_db[$col_chip_type_g][$row] eq 'FPU' ){
				$fpu_list[$fpu_cnt] = $row;
				$fpu_cnt++;
			}else{
				$others_list[$others_cnt] = $row;
				$others_cnt++;
			}
		}
		$row++;
	}
	
	$html_code .= "<h1><a href=\"index.pl?page=m&manuf=$manuf\">$manuf</a> - <a href=\"index.pl?page=f&fam=$family\">$family</a></h1>\n";

	my $chip = $cpu_db[$col_part_g][$row];
	$html_code .= "<h3>CPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@cpu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";
	
	$html_code .= "<br /><br /><h3>MCUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@mcu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>DSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@dsp_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>BSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@bsp_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>FPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@fpu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>Other chips</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@others_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"index.pl?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";


	return $html_code;
}

sub display_home_page {
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
		<a href="index.pl?p=db-access">Database Access</a>

	Contact:
		to be added

		</pre><br />
Endhtml

	return $html_code;
}

sub display_single_chip_info_g {
	my $manuf = $_[0];
	my $part = $_[1];
	my $html_code = '';
	my $row = 0;
	my $family = '';
	my $alt_lable1 = '';
	my $alt_lable2 = '';
	my $alt_lable3 = '';
	my $alt_lable4 = '';
	my $alt_lable5 = '';
	my $empty = '';
	my $chip_type = '';
	my $sub_family = '';
	my $model_num = '';
	my $core = '';
	my $core_designer = '';
	my $microarch = '';
	my $threads = '';
	my $cpuid = '';
	my $core_cnt = '';
	my $arch = '';
	my $data_bus_ext = '';
	my $add_bus = '';
	my $freq_min = '';
	my $freq_max = '';
	my $actual_bus_freq = '';
	my $effective_bus_freq = '';
	my $bus_bandwidth = '';
	my $clk_multiplier = '';
	my $core_stepping = '';
	my $l1_data_cache = '';
	my $l1_data_ass = '';
	my $l1_instruction_cache = '';
	my $l1_instruction_ass = '';
	my $l1_unified_cache = '';
	my $l1_unified_ass = '';
	my $l2_cache = '';
	my $l2_ass = '';
	my $l3_cache = '';
	my $l3_ass = '';
	my $boot_rom = '';
	my $rom_int = '';
	my $rom_type = '';
	my $ram_int = '';
	my $ram_max = '';
	my $ram_type = '';
	my $virtual_mem_max = '';
	my $package = '';
	my $package_size = '';
	my $package_weight = '';
	my $socket = '';
	my $trans_cnt = '';
	my $proc_size = '';
	my $metal_layer = '';
	my $metal_type = '';
	my $proc_tech = '';
	my $die_size = '';
	my $vcc_range = '';
	my $vcc_typ = '';
	my $vcc_2 = '';
	my $vcc_3 = '';
	my $vcc_core = '';
	my $vcc_io = '';
	my $power_min = '';
	my $power_typ = '';
	my $power_max = '';
	my $power_therm = '';
	my $temp_range = '';
	my $low_power_feat = '';
	my $instruction_set = '';
	my $instruction_set_ext = '';
	my $additional_instructions = '';
	my $comp_arch = '';
	my $isa = '';
	my $fpu = '';
	my $onchip_peripherals = '';
	my $features = '';
	my $date = '';
	my $price = '';
	my $applications = '';
	my $mil = '';
	my $comments = '';
	my $ref1 = '';
	my $ref2 = '';
	my $ref3 = '';
	my $ref4 = '';
	my $ref5 = '';
	my $ref6 = '';
	my $ref7 = '';
	my $ref8 = '';

	# $html_code .= "$manuf $part<br />";
	while( exists($cpu_db[0][$row]) ){
			# $html_code .= ".";
			# $html_code .= "~$cpu_db[$col_manuf_g][$row]~ eq ~$manuf~ && ~$cpu_db[$col_part_g][$row]~ eq ~$part~<br />";
		if( $cpu_db[$col_manuf_g][$row] eq $manuf && $cpu_db[$col_part_g][$row] eq $part ){
			# $html_code .= ".";

			if( $cpu_db[$col_manuf_g][$row] eq '' ){
				$manuf = '?';
			}else{
				$manuf = $cpu_db[$col_manuf_g][$row];
			}
			if( $cpu_db[$col_family_g][$row] eq '' ){
				$family = '?';
			}else{
				$family = $cpu_db[$col_family_g][$row];
			}
			if( $cpu_db[$col_part_g][$row] eq '' ){
				$part = '?';
			}else{
				$part = $cpu_db[$col_part_g][$row];
			}
			if( $cpu_db[$col_alt_lable1_g][$row] eq '' ){
				$alt_lable1 = '?';
			}else{
				$alt_lable1 = $cpu_db[$col_alt_lable1_g][$row];
			}
			if( $cpu_db[$col_alt_lable2_g][$row] eq '' ){
				$alt_lable2 = '?';
			}else{
				$alt_lable2 = $cpu_db[$col_alt_lable2_g][$row];
			}
			if( $cpu_db[$col_alt_lable3_g][$row] eq '' ){
				$alt_lable3 = '?';
			}else{
				$alt_lable3 = $cpu_db[$col_alt_lable3_g][$row];
			}
			if( $cpu_db[$col_alt_lable4_g][$row] eq '' ){
				$alt_lable4 = '?';
			}else{
				$alt_lable4 = $cpu_db[$col_alt_lable4_g][$row];
			}
			if( $cpu_db[$col_alt_lable5_g][$row] eq '' ){
				$alt_lable5 = '?';
			}else{
				$alt_lable5 = $cpu_db[$col_alt_lable5_g][$row];
			}
			if( $cpu_db[$col_empty_g][$row] eq '' ){
				$empty = '?';
			}else{
				$empty = $cpu_db[$col_empty_g][$row];
			}
			if( $cpu_db[$col_chip_type_g][$row] eq '' ){
				$chip_type = '?';
			}else{
				$chip_type = $cpu_db[$col_chip_type_g][$row];
			}
			if( $cpu_db[$col_sub_family_g][$row] eq '' ){
				$sub_family = '?';
			}else{
				$sub_family = $cpu_db[$col_sub_family_g][$row];
			}
			if( $cpu_db[$col_model_num_g][$row] eq '' ){
				$model_num = '?';
			}else{
				$model_num = $cpu_db[$col_model_num_g][$row];
			}
			if( $cpu_db[$col_core_g][$row] eq '' ){
				$core = '?';
			}else{
				$core = $cpu_db[$col_core_g][$row];
			}
			if( $cpu_db[$col_core_designer_g][$row] eq '' ){
				$core_designer = '?';
			}else{
				$core_designer = $cpu_db[$col_core_designer_g][$row];
			}
			if( $cpu_db[$col_microarch_g][$row] eq '' ){
				$microarch = '?';
			}else{
				$microarch = $cpu_db[$col_microarch_g][$row];
			}
			if( $cpu_db[$col_threads_g][$row] eq '' ){
				$threads = '?';
			}else{
				$threads = $cpu_db[$col_threads_g][$row];
			}
			if( $cpu_db[$col_cpuid_g][$row] eq '' ){
				$cpuid = '?';
			}else{
				$cpuid = $cpu_db[$col_cpuid_g][$row];
			}
			if( $cpu_db[$col_core_cnt_g][$row] eq '' ){
				$core_cnt = '?';
			}else{
				$core_cnt = $cpu_db[$col_core_cnt_g][$row];
			}
			if( $cpu_db[$col_arch_g][$row] eq '' ){
				$arch = '?';
			}else{
				$arch = $cpu_db[$col_arch_g][$row];
			}
			if( $cpu_db[$col_data_bus_ext_g][$row] eq '' ){
				$data_bus_ext = '?';
			}else{
				$data_bus_ext = $cpu_db[$col_data_bus_ext_g][$row];
			}
			if( $cpu_db[$col_add_bus_g][$row] eq '' ){
				$add_bus = '?';
			}else{
				$add_bus = $cpu_db[$col_add_bus_g][$row];
			}
			if( $cpu_db[$col_freq_min_g][$row] eq '' ){
				$freq_min = '?';
			}else{
				$freq_min = $cpu_db[$col_freq_min_g][$row];
			}
			if( $cpu_db[$col_freq_max_g][$row] eq '' ){
				$freq_max = '?';
			}else{
				$freq_max = $cpu_db[$col_freq_max_g][$row];
			}
			if( $cpu_db[$col_actual_bus_freq_g][$row] eq '' ){
				$actual_bus_freq = '?';
			}else{
				$actual_bus_freq = $cpu_db[$col_actual_bus_freq_g][$row];
			}
			if( $cpu_db[$col_effective_bus_freq_g][$row] eq '' ){
				$effective_bus_freq = '?';
			}else{
				$effective_bus_freq = $cpu_db[$col_effective_bus_freq_g][$row];
			}
			if( $cpu_db[$col_bus_bandwidth_g][$row] eq '' ){
				$bus_bandwidth = '?';
			}else{
				$bus_bandwidth = $cpu_db[$col_bus_bandwidth_g][$row];
			}
			if( $cpu_db[$col_clk_multiplier_g][$row] eq '' ){
				$clk_multiplier = '?';
			}else{
				$clk_multiplier = $cpu_db[$col_clk_multiplier_g][$row];
			}
			if( $cpu_db[$col_core_stepping_g][$row] eq '' ){
				$core_stepping = '?';
			}else{
				$core_stepping = $cpu_db[$col_core_stepping_g][$row];
			}
			if( $cpu_db[$col_l1_data_cache_g][$row] eq '' ){
				$l1_data_cache = '?';
			}else{
				$l1_data_cache = $cpu_db[$col_l1_data_cache_g][$row];
			}
			if( $cpu_db[$col_l1_data_ass_g][$row] eq '' ){
				$l1_data_ass = '?';
			}else{
				$l1_data_ass = $cpu_db[$col_l1_data_ass_g][$row];
			}
			if( $cpu_db[$col_l1_instruction_cache_g][$row] eq '' ){
				$l1_instruction_cache = '?';
			}else{
				$l1_instruction_cache = $cpu_db[$col_l1_instruction_cache_g][$row];
			}
			if( $cpu_db[$col_l1_instruction_ass_g][$row] eq '' ){
				$l1_instruction_ass = '?';
			}else{
				$l1_instruction_ass = $cpu_db[$col_l1_instruction_ass_g][$row];
			}
			if( $cpu_db[$col_l1_unified_cache_g][$row] eq '' ){
				$l1_unified_cache = '?';
			}else{
				$l1_unified_cache = $cpu_db[$col_l1_unified_cache_g][$row];
			}
			if( $cpu_db[$col_l1_unified_ass_g][$row] eq '' ){
				$l1_unified_ass = '?';
			}else{
				$l1_unified_ass = $cpu_db[$col_l1_unified_ass_g][$row];
			}
			if( $cpu_db[$col_l2_cache_g][$row] eq '' ){
				$l2_cache = '?';
			}else{
				$l2_cache = $cpu_db[$col_l2_cache_g][$row];
			}
			if( $cpu_db[$col_l2_ass_g][$row] eq '' ){
				$l2_ass = '?';
			}else{
				$l2_ass = $cpu_db[$col_l2_ass_g][$row];
			}
			if( $cpu_db[$col_l3_cache_g][$row] eq '' ){
				$l3_cache = '?';
			}else{
				$l3_cache = $cpu_db[$col_l3_cache_g][$row];
			}
			if( $cpu_db[$col_l3_ass_g][$row] eq '' ){
				$l3_ass = '?';
			}else{
				$l3_ass = $cpu_db[$col_l3_ass_g][$row];
			}
			if( $cpu_db[$col_boot_rom_g][$row] eq '' ){
				$boot_rom = '?';
			}else{
				$boot_rom = $cpu_db[$col_boot_rom_g][$row];
			}
			if( $cpu_db[$col_rom_int_g][$row] eq '' ){
				$rom_int = '?';
			}else{
				$rom_int = $cpu_db[$col_rom_int_g][$row];
			}
			if( $cpu_db[$col_rom_type_g][$row] eq '' ){
				$rom_type = '?';
			}else{
				$rom_type = $cpu_db[$col_rom_type_g][$row];
			}
			if( $cpu_db[$col_ram_int_g][$row] eq '' ){
				$ram_int = '?';
			}else{
				$ram_int = $cpu_db[$col_ram_int_g][$row];
			}
			if( $cpu_db[$col_ram_max_g][$row] eq '' ){
				$ram_max = '?';
			}else{
				$ram_max = $cpu_db[$col_ram_max_g][$row];
			}
			if( $cpu_db[$col_ram_type_g][$row] eq '' ){
				$ram_type = '?';
			}else{
				$ram_type = $cpu_db[$col_ram_type_g][$row];
			}
			if( $cpu_db[$col_virtual_mem_max_g][$row] eq '' ){
				$virtual_mem_max = '?';
			}else{
				$virtual_mem_max = $cpu_db[$col_virtual_mem_max_g][$row];
			}
			if( $cpu_db[$col_package_g][$row] eq '' ){
				$package = '?';
			}else{
				$package = $cpu_db[$col_package_g][$row];
			}
			if( $cpu_db[$col_package_size_g][$row] eq '' ){
				$package_size = '?';
			}else{
				$package_size = $cpu_db[$col_package_size_g][$row];
			}
			if( $cpu_db[$col_package_weight_g][$row] eq '' ){
				$package_weight = '?';
			}else{
				$package_weight = $cpu_db[$col_package_weight_g][$row];
			}
			if( $cpu_db[$col_socket_g][$row] eq '' ){
				$socket = '?';
			}else{
				$socket = $cpu_db[$col_socket_g][$row];
			}
			if( $cpu_db[$col_trans_cnt_g][$row] eq '' ){
				$trans_cnt = '?';
			}else{
				$trans_cnt = $cpu_db[$col_trans_cnt_g][$row];
			}
			if( $cpu_db[$col_proc_size_g][$row] eq '' ){
				$proc_size = '?';
			}else{
				$proc_size = $cpu_db[$col_proc_size_g][$row];
			}
			if( $cpu_db[$col_metal_layer_g][$row] eq '' ){
				$metal_layer = '?';
			}else{
				$metal_layer = $cpu_db[$col_metal_layer_g][$row];
			}
			if( $cpu_db[$col_metal_type_g][$row] eq '' ){
				$metal_type = '?';
			}else{
				$metal_type = $cpu_db[$col_metal_type_g][$row];
			}
			if( $cpu_db[$col_proc_tech_g][$row] eq '' ){
				$proc_tech = '?';
			}else{
				$proc_tech = $cpu_db[$col_proc_tech_g][$row];
			}
			if( $cpu_db[$col_die_size_g][$row] eq '' ){
				$die_size = '?';
			}else{
				$die_size = $cpu_db[$col_die_size_g][$row];
			}
			if( $cpu_db[$col_vcc_range_g][$row] eq '' ){
				$vcc_range = '?';
			}else{
				$vcc_range = $cpu_db[$col_vcc_range_g][$row];
			}
			if( $cpu_db[$col_vcc_typ_g][$row] eq '' ){
				$vcc_typ = '?';
			}else{
				$vcc_typ = $cpu_db[$col_vcc_typ_g][$row];
			}
			if( $cpu_db[$col_vcc_2_g][$row] eq '' ){
				$vcc_2 = '?';
			}else{
				$vcc_2 = $cpu_db[$col_vcc_2_g][$row];
			}
			if( $cpu_db[$col_vcc_3_g][$row] eq '' ){
				$vcc_3 = '?';
			}else{
				$vcc_3 = $cpu_db[$col_vcc_3_g][$row];
			}
			if( $cpu_db[$col_vcc_core_g][$row] eq '' ){
				$vcc_core = '?';
			}else{
				$vcc_core = $cpu_db[$col_vcc_core_g][$row];
			}
			if( $cpu_db[$col_vcc_io_g][$row] eq '' ){
				$vcc_io = '?';
			}else{
				$vcc_io = $cpu_db[$col_vcc_io_g][$row];
			}
			if( $cpu_db[$col_power_min_g][$row] eq '' ){
				$power_min = '?';
			}else{
				$power_min = $cpu_db[$col_power_min_g][$row];
			}
			if( $cpu_db[$col_power_typ_g][$row] eq '' ){
				$power_typ = '?';
			}else{
				$power_typ = $cpu_db[$col_power_typ_g][$row];
			}
			if( $cpu_db[$col_power_max_g][$row] eq '' ){
				$power_max = '?';
			}else{
				$power_max = $cpu_db[$col_power_max_g][$row];
			}
			if( $cpu_db[$col_power_therm_g][$row] eq '' ){
				$power_therm = '?';
			}else{
				$power_therm = $cpu_db[$col_power_therm_g][$row];
			}
			if( $cpu_db[$col_temp_range_g][$row] eq '' ){
				$temp_range = '?';
			}else{
				$temp_range = $cpu_db[$col_temp_range_g][$row];
			}
			if( $cpu_db[$col_low_power_feat_g][$row] eq '' ){
				$low_power_feat = '?';
			}else{
				$low_power_feat = $cpu_db[$col_low_power_feat_g][$row];
			}
			if( $cpu_db[$col_instruction_set_g][$row] eq '' ){
				$instruction_set = '?';
			}else{
				$instruction_set = $cpu_db[$col_instruction_set_g][$row];
			}
			if( $cpu_db[$col_instruction_set_ext_g][$row] eq '' ){
				$instruction_set_ext = '?';
			}else{
				$instruction_set_ext = $cpu_db[$col_instruction_set_ext_g][$row];
			}
			if( $cpu_db[$col_additional_instructions_g][$row] eq '' ){
				$additional_instructions = '?';
			}else{
				$additional_instructions = $cpu_db[$col_additional_instructions_g][$row];
			}
			if( $cpu_db[$col_comp_arch_g][$row] eq '' ){
				$comp_arch = '?';
			}else{
				$comp_arch = $cpu_db[$col_comp_arch_g][$row];
			}
			if( $cpu_db[$col_isa_g][$row] eq '' ){
				$isa = '?';
			}else{
				$isa = $cpu_db[$col_isa_g][$row];
			}
			if( $cpu_db[$col_fpu_g][$row] eq '' ){
				$fpu = '?';
			}else{
				$fpu = $cpu_db[$col_fpu_g][$row];
			}
			if( $cpu_db[$col_onchip_peripherals_g][$row] eq '' ){
				$onchip_peripherals = '?';
			}else{
				$onchip_peripherals = $cpu_db[$col_onchip_peripherals_g][$row];
			}
			if( $cpu_db[$col_features_g][$row] eq '' ){
				$features = '?';
			}else{
				$features = $cpu_db[$col_features_g][$row];
			}
			if( $cpu_db[$col_date_g][$row] eq '' ){
				$date = '?';
			}else{
				$date = $cpu_db[$col_date_g][$row];
			}
			if( $cpu_db[$col_price_g][$row] eq '' ){
				$price = '?';
			}else{
				$price = $cpu_db[$col_price_g][$row];
			}
			if( $cpu_db[$col_applications_g][$row] eq '' ){
				$applications = '?';
			}else{
				$applications = $cpu_db[$col_applications_g][$row];
			}
			if( $cpu_db[$col_mil_g][$row] eq '' ){
				$mil = '?';
			}else{
				$mil = $cpu_db[$col_mil_g][$row];
			}
			if( $cpu_db[$col_comments_g][$row] eq '' ){
				$comments = '';
			}else{
				$comments = $cpu_db[$col_comments_g][$row];
			}
			if( $cpu_db[$col_ref1_g][$row] eq '' ){
				$ref1 = '?';
			}else{
				$ref1 = $cpu_db[$col_ref1_g][$row];
			}
			if( $cpu_db[$col_ref2_g][$row] eq '' ){
				$ref2 = '';
			}else{
				$ref2 = $cpu_db[$col_ref2_g][$row];
			}
			if( $cpu_db[$col_ref3_g][$row] eq '' ){
				$ref3 = '';
			}else{
				$ref3 = $cpu_db[$col_ref3_g][$row];
			}
			if( $cpu_db[$col_ref4_g][$row] eq '' ){
				$ref4 = '';
			}else{
				$ref4 = $cpu_db[$col_ref4_g][$row];
			}
			if( $cpu_db[$col_ref5_g][$row] eq '' ){
				$ref5 = '';
			}else{
				$ref5 = $cpu_db[$col_ref5_g][$row];
			}
			if( $cpu_db[$col_ref6_g][$row] eq '' ){
				$ref6 = '';
			}else{
				$ref6 = $cpu_db[$col_ref6_g][$row];
			}
			if( $cpu_db[$col_ref7_g][$row] eq '' ){
				$ref7 = '';
			}else{
				$ref7 = $cpu_db[$col_ref7_g][$row];
			}
			if( $cpu_db[$col_ref8_g][$row] eq '' ){
				$ref8 = '';
			}else{
				$ref8 = $cpu_db[$col_ref8_g][$row];
			}

		}
		$row++;
	}


	$html_code .= <<Endhtml;
	<h3><a href="index.pl?page=m&manuf=$manuf">$manuf</a> - <a href="index.pl?page=f&fam=$family">$family</a></h3>
	
	<h1>$part</h1>
	<pre>		
	
	Alternative Lables: $alt_lable1, $alt_lable2, $alt_lable3, $alt_lable4, $alt_lable5
			
	Chip type: $chip_type
	Sub-family: $sub_family 
	Model Number: $model_num
			
	Architecture
		Archecture: $comp_arch 
		Microarchecture: $microarch

	Core
		Core: $core 
		Designer: $core_designer
		Number of Cores: $core_cnt 
		Threads: $threads
  		CPUID: $cpuid	
		Core stepping: $core_stepping

	Bus
		Architecture: $arch
		External data bus: $data_bus_ext
		Address bus: $add_bus

	Speed
		Min freqency: $freq_min		
		Max frequency: $freq_max
		Clock multiplier: $clk_multiplier
		Real bus freq: $actual_bus_freq	
		Effective bus freq: $effective_bus_freq
		Bus bandwidth: $bus_bandwidth

	Memory
		Internal ROM: $rom_int	
		ROM type: $rom_type
		Boot ROM: $boot_rom
		Internal RAM: $ram_int
		RAM maximum external: $ram_max 	
		RAM type: $ram_type
		Virtual memory: $virtual_mem_max
		L1 data cache: $l1_data_cache 
		L1 data cache assosiativity: $l1_data_ass
		L1 instruction cache: $l1_instruction_cache 
		L1 instruction cache assosiativity: $l1_instruction_ass
		L1 unified cache: $l1_unified_cache 
		L1 unified cache assosiativity: $l1_unified_ass
		L2 cache: $l2_cache 
		L2 cache assosiativity: $l2_ass
		L3 cache: $l3_cache 
		L2 cache assosiativity: $l3_ass 

	Package
		Package: $package		
		Socket: $socket
		Package size: $package_size	
		Package weight: $package_weight

	Power
		Supply voltage(typ): $vcc_typ	
		Suppy voltage range: $vcc_range
		Core voltage: $vcc_core		
		I/O voltage: $vcc_io
		Secondary voltage: $vcc_2	
		Tersiary voltage: $vcc_3
		Power(min): $power_min		
		Power(typ): $power_typ		
		Power(max): $power_max 
		Thermal Power: $power_therm	
		Temp range: $temp_range
		Low power features: $low_power_feat

	Instruction set
		ISA: $isa 
		Instruction set: $instruction_set	
		Instruction set extensions: $instruction_set_ext 
		Additional instructions: $additional_instructions
	
	Technology
		Process Tech: $proc_tech	
		Metal layers: $metal_layer 
		Metal type: $metal_type
		Transistors: $trans_cnt		
		Die Size: $die_size 

	Features
		FPU: $fpu
		On chip peripherals: $onchip_peripherals
		
	Additional info
		Introduction date: $date 
		Introduction price: $price
		Typical application: $applications
		Military Specs: $mil
		Features: $features
		Comments: $comments

	References
		$ref1
		$ref2
		$ref3
		$ref4
		$ref5
		$ref6
		$ref7
		$ref8 
	</pre>

Endhtml

	return $html_code;
}



sub display_manuf_list{
	my $html_code = '';

	foreach my $manuf (@manuf_list_g){
		if( $manuf ne '' ){
			$html_code .= "<a href=\"index.pl?page=m&manuf=$manuf\">$manuf</a> <br />\n";
		}
	}

	return $html_code;

}


sub display_families_list{
	my $html_code = '';
	
	foreach my $fam (@family_list_g){
		if( $fam ne '' ){
			$html_code .= "<a href=\"index.pl?page=f&family=$fam\">$fam</a> <br />\n";
		}
	}

	return $html_code;
}



sub display_header {
	my $html_code = '';

	$html_code .= "content-type: text/html \n\n"; #HTTP HEADER

	$html_code .= <<Endhtml;
<html>
<head>
  <style>  
	#bode {  
      margin: 0 auto;  
    }  
	#lists {
       margin-left: 50px;
	}	
  </style>
</head>
<body>
	
<h1>cpu-db.info</h1>

<a href="index.pl">Home</a> |<a href="index.pl?page=cat&type=chips">Chips</a> | <a href="index.pl?page=cat&type=manuf">Manufacturer</a> | <a href="index.pl?page=cat&type=families">Families</a><br /><br />

	<div id="bode">
Endhtml
	return $html_code;
}


sub display_footer {
	my $html_code = '';

	$html_code .= <<Endhtml;

	</div>
	<br />
	Copyleft cpu-db.info 2012
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
	}elsif( $cgi_input{'page'} eq 'mf' ){
		$html_code .= display_manuf_family_page($cgi_input{'manuf'},$cgi_input{'fam'});
	}elsif( $cgi_input{'page'} eq 'c' ){
		$html_code .= display_single_chip_info_g($cgi_input{'manuf'},$cgi_input{'part'});
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

@cpu_db = import_csv_db($database_location);
&get_col_labels();
&get_chip_list;

# Gets input args
%cgi_input = &read_input; #get input

$html_code_g .= main_page();

# $html_code_g .= display_chips_page();
# $html_code_g .= display_manuf_page('Intel');
# $html_code_g .= display_manuf_family_page('Intel','386');
# $html_code_g .= display_single_chip_info_g('Intel','A80186');

print $html_code_g;
# print " >> $manuf_families_g{ 'Siemens' }{ 'CPU' }{ 'R3000' } \n";
# print "Count = $col_cnt_g";
print "\n";
