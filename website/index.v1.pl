#!/usr/bin/perl 



use File::stat;
use Time::localtime;
use Switch;

use lib "$ENV{HOME}/lib";
use Text::CSV;
 # use Tie::Array::CSV;

#############################
# Config
#

$database_location='cpu-db.csv';
$todo_file_loc_g='TODO.txt';








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
	# my @file_lines = open_file($database);
	my $line = '';
	my @csv_db;
	my @csv_db_row;

	# tie my @csv_db, 'Tie::Array::CSV', $database;

	my @rows;
 	my @transposed = ();



	open(FILEVARIABLE, "< $database");
	while(my $line = <FILEVARIABLE>) {
    	my @cells = csvsplit($line); # or csvsplit($line, $my_custom_seperator)
		# print "@cells\n";
		push @rows, \@cells;
		# print ".";
	}
	close(FILEVARIABLE);

	# my $csv = Text::CSV->new ( { binary => 1 } );
 
	# open my $fh, "<", "$database" or die "death: $!";
	# while ( my $row = $csv->getline( $fh ) ) {
        # $row->[2] =~ m/pattern/ or next; # 3rd field should match
		# push @rows, $row;
		# print ".";
	# }
	# $csv->eof or $csv->error_diag();
     # close $fh;
	





for my $row (@rows) {
  for my $column (0 .. $#{$row}) {
	push(@{$transposed[$column]}, $row->[$column]);
  }
}
@csv_db = @transposed;
# @csv_db = @rows;

	# my $csv = Text::CSV->new ;

	# open(my $fh, '<', $database);

	# while (<CSV<Plug>NERDCommenterToggle>) {
		# if ($csv->parse($_)) {
			# my @csv_db_row = $csv->fields();
			# @csv_db = (\@csv_db, \@csv_db_row);
			# print "@csv_db_row\n";
		# }
	# }
	
	# while( my $row = $csv->getline( $fh ) ) { 
        # shift @$row;        # throw away first value
		# push @csv_db, $row;
	# }

	# close CSV;

	# my @file_lines = open_file($database);
	# my $x = 0;
	# my $y = 0;
	# foreach $line (@file_lines) {
		# $x = 0;
		# print "$line \n";
		# foreach $cell (split(',', $line)) {
			# $database[$x][$y] = $cell;
			# $x++
		# }
		# $y++;
	# }
	return @csv_db;
}



sub csvsplit {
        my $line = shift;
        my $sep = (shift or ',');

        return () unless $line;

        my @cells;
        $line =~ s/\r?\n$//;

        my $re = qr/(?:^|$sep)(?:"([^"]*)"|([^$sep]*))/;

        while($line =~ /$re/g) {
                my $value = defined $1 ? $1 : $2;
                push @cells, (defined $value ? $value : '');
        }

        return @cells;
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
        	$html_code .= "<h3><a href=\"$script_name_g?page=m&manuf=$manuf\">$manuf</a></h3>\n";
			$html_code .= "<div id=\"lists\">\n";	
			foreach my $chip_type (sort keys %{$manuf_families_g{ $manuf }}) {
				if( $chip_type ne '' ){
					$html_code .= "  $chip_type<br />\n";
					$html_code .= "<div id=\"lists\">\n";				
					foreach my $family (sort keys %{$manuf_families_g{ $manuf }{ $chip_type }}) {
						if( $family ne '' ){
							$html_code .= "\t<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$family\">$family</a>,";
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
   			foreach my $family (sort keys %{$manuf_families_g{ $manuf }{ $chip_type }}) {
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
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$cpu\">$cpu</a><br />\n";
	}
	$html_code .= "</div>\n";
	
	$html_code .= "<br /><br /><h3>MCUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";	
	foreach $mcu (@mcu_list){
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$mcu\">$mcu</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>DSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $dsp (@dsp_list){
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$dsp\">$dsp</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>BSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $bsp (@bsp_list){
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$bsp\">$bsp</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>FPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $fpu (@fpu_list){
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$fpu\">$fpu</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>Other chips</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $others (@others_list){
		$html_code .= "<a href=\"$script_name_g?page=mf&manuf=$manuf&fam=$others\">$others</a><br />\n";
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
	
	$html_code .= "<h1><a href=\"$script_name_g?page=m&manuf=$manuf\">$manuf</a> - <a href=\"$script_name_g?page=f&fam=$family\">$family</a></h1>\n";

	my $chip = $cpu_db[$col_part_g][$row];
	$html_code .= "<h3>CPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@cpu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";
	
	$html_code .= "<br /><br /><h3>MCUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@mcu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>DSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@dsp_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>BSPs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@bsp_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>FPUs</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@fpu_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
	}
	$html_code .= "</div>\n";

	$html_code .= "<br /><br /><h3>Other chips</h3><br />\n";
	$html_code .= "<div id=\"lists\">\n";
	foreach $row (@others_list){
		my $chip = $cpu_db[$col_part_g][$row];		
		$html_code .= "\t<a href=\"$script_name_g?page=c&manuf=$manuf&part=$chip\">$chip</a><br />\n";
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
		<a href="$script_name_g?p=db-access">Database Access</a>

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
	my $alt_lables = '';
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
	my $refs = '';
	my $missing_info_level=0;

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
				$missing_info_level++;
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
				$missing_info_level++;
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
				$missing_info_level++;
			}else{
				$arch = $cpu_db[$col_arch_g][$row];
			}
			if( $cpu_db[$col_data_bus_ext_g][$row] eq '' ){
				$data_bus_ext = '?';
				$missing_info_level++;
			}else{
				$data_bus_ext = $cpu_db[$col_data_bus_ext_g][$row];
			}
			if( $cpu_db[$col_add_bus_g][$row] eq '' ){
				$add_bus = '?';
				$missing_info_level++;
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
				$missing_info_level++;
			}else{
				$freq_max = $cpu_db[$col_freq_max_g][$row];
			}
			if( $cpu_db[$col_actual_bus_freq_g][$row] eq '' ){
				$actual_bus_freq = '?';
				$missing_info_level++;
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
				$missing_info_level++;
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
				$missing_info_level++;
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
				$ref1 = '';
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

	# Missing Info level
	if( $missing_info_level > 3 ){
		$missing_info_message = "<p class=\"warning_message\">This page is missing basic information about the chip, if you can fill in any details, please add them with references</p><br />\n";
	}

	# Polishing
	# Alternative lables
	if( $alt_lable1 eq '?' ){
		$alt_lables = '?';
	}elsif( $alt_lable2 eq '?' ){
		$alt_lables = "$alt_lable1";
	}elsif( $alt_lable3 eq '?' ){
		$alt_lables = "$alt_lable1, $alt_lable2";
	}elsif( $alt_lable4 eq '?' ){
		$alt_lables = "$alt_lable1, $alt_lable2, $alt_lable3";
	}elsif( $alt_lable5 eq '?' ){
		$alt_lables = "$alt_lable1, $alt_lable2, $alt_lable3, $alt_lable4";
	}else{
		$alt_lables = "$alt_lable1, $alt_lable2, $alt_lable3, $alt_lable4, $alt_lable5";
	}

	# References
	if( not( $ref1 || $ref2 || $ref3 || $ref4 || $ref5 || $ref6 || $ref7 || $ref8) ){
		$refs = "<p class=\"warning_message\">The info on this page has no references, if you have any please add one</p>";
	}elsif( $ref1 ){
		$refs = "$ref1";
		if( $ref2 ){
			$refs .= "\n<br />$ref2";
		}
		if( $ref3 ){
			$refs .= "\n<br />$ref3";
		}
		if( $ref4 ){
			$refs .= "\n<br />$ref4";
		}
		if( $ref5 ){
			$refs .= "\n<br />$ref5";
		}
		if( $ref6 ){
			$refs .= "\n<br />$ref6";
		}
		if( $ref7 ){
			$refs .= "\n<br />$ref7";
		}
		if( $ref8 ){
			$refs .= "\n<br />$ref8";
		}
	}
	$refs =~ s/\“/\"/;
	$refs =~ s/\”/\"/;

	$html_code .= <<Endhtml;
	<h3><a href="$script_name_g?page=m&manuf=$manuf">$manuf</a> - <a href="$script_name_g?page=f&fam=$family">$family</a></h3>
	
	<div class="body_content_indent">

	<h1>$manuf - $part</h1>
	
	$missing_info_message

	<table>
	  <tr>
	  <td colspan="2">
		<table width="100%">
			<tr>
				<td class='table_param'>Chip type:</td>
				<td class='table_value'>$chip_type</td>
			</tr><tr>
				<td class='table_param'>Sub-family:</td>
				<td class='table_value'>$sub_family</td>
			</tr><tr>
				<td class='table_param'>Model Number:</td>
				<td class='table_value'>$model_num</td>
			</tr>
			<tr>
				<td class='table_param'>Alternative Lables:</td>
				<td class='table_value'>$alt_lables</td>
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
					<td class='table_value'>$core </td>
				</tr>
				<tr>
					<td class='table_param'>Designer:</td>
					<td class='table_value'>$core_designer</td>
				</tr>
				<tr>
					<td class='table_param'>Number of Cores:</td>
					<td class='table_value'>$core_cnt</td>
				</tr>
				<tr>
					<td class='table_param'>Threads:</td>
					<td class='table_value'>$threads</td>
				</tr>
				<tr>
			  		<td class='table_param'>CPUID:</td>
					<td class='table_value'>$cpuid	</td>
				</tr>
				<tr>
					<td class='table_param'>Core stepping:</td>
					<td class='table_value'>$core_stepping</td>
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
					<td class='table_value'>$arch</td>
				</tr>
				<tr>
			  		<td class='table_param'>External data bus:</td>
					<td class='table_value'>$data_bus_ext</td>
				</tr>
				<tr>
			  		<td class='table_param'>Address bus:</td>
					<td class='table_value'>$add_bus</td>
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
				<tr>
					<td class='table_param_long'>Freqency(min):</td>
					<td class='table_value'>$freq_min</td>		
				</tr>
				<tr>
		  			<td class='table_param_long'>Frequency(max):</td>
					<td class='table_value'>$freq_max</td>
				</tr>
				<tr>
		  			<td class='table_param_long'>Clock multiplier:</td>
					<td class='table_value'>$clk_multiplier</td>
				</tr>
				<tr>
		  			<td class='table_param_long'>Bus frequency, actual(max):</td>
					<td class='table_value'>$actual_bus_freq</td>
				</tr>
				<tr>	
		  			<td class='table_param_long'>Bus frequency, effective(max):</td>
					<td class='table_value'>$effective_bus_freq</td>
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
								<td class='table_value'>$ram_int</td>
							</tr>
							<tr>
					  			<td class='table_param'>Virtual memory:</td>
								<td class='table_value'>$virtual_mem_max</td>
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
								<td class='table_value'>$rom_int</td>
							</tr>
							<tr>	
					  			<td class='table_param'>ROM type:</td>
								<td class='table_value'>$rom_type</td>
							</tr>
							<tr>
					  			<td class='table_param'>Boot ROM:</td>
								<td class='table_value'>$boot_rom</td>
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
						<table width="100%">
							<tr>
					  			<td class='table_param'>L1 data cache:</td>
								<td class='table_value'>$l1_data_cache</td>
							</tr>
							<tr> 
					  			<td class='table_param'>L1 data cache assosiativity:</td>
								<td class='table_value'>$l1_data_ass</td>
							</tr>
							<tr>
					  			<td class='table_param'>L1 instruction cache:</td>
								<td class='table_value'>$l1_instruction_cache</td> 
							</tr>
							<tr>
					  			<td class='table_param'>L1 instruction cache assosiativity:</td>
								<td class='table_value'>$l1_instruction_ass</td>
							</tr>
							<tr>
					  			<td class='table_param'>L1 unified cache:</td>
								<td class='table_value'>$l1_unified_cache</td>
							</tr>
							<tr> 
					  			<td class='table_param'>L1 unified cache assosiativity:</td>
								<td class='table_value'>$l1_unified_ass</td>
							</tr>
							<tr>
					  			<td class='table_param'>L2 cache:</td>
								<td class='table_value'>$l2_cache </td>
							</tr>
							<tr>
					  			<td class='table_param'>L2 cache assosiativity:</td>
								<td class='table_value'>$l2_ass</td>
							</tr>
							<tr>
					  			<td class='table_param'>L3 cache:</td>
								<td class='table_value'>$l3_cache</td> 
							</tr>
							<tr>
					  			<td class='table_param'>L2 cache assosiativity:</td>
								<td class='table_value'>$l3_ass</td>
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
					<td class='table_value'>$vcc_typ	</td>
				</tr>
				<tr>
		  			<td class='table_param'>Suppy voltage range:</td>
					<td class='table_value'>$vcc_range</td>
				</tr>
				<tr>
		  			<td class='table_param'>Core voltage:</td>
					<td class='table_value'>$vcc_core</td>	
				</tr>
				<tr>	
		  			<td class='table_param'>I/O voltage:</td>
					<td class='table_value'>$vcc_io</td>
				</tr>
				<tr>
		  			<td class='table_param'>Secondary voltage:</td>
					<td class='table_value'>$vcc_2</td>
				</tr>
				<tr>
		  			<td class='table_param'>Tersiary voltage:</td>
					<td class='table_value'>$vcc_3</td>
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
					<td class='table_value'>$power_therm</td>
				</tr>
				<tr>	
		  			<td class='table_param'>Temp range:</td>
					<td class='table_value'>$temp_range</td>
				</tr>
				<tr>
		  			<td class='table_param'>Low power features:</td>
					<td class='table_value'>$low_power_feat</td>
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
					<td class='table_value'>$instruction_set_ext </td>
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
					<td class='table_value'>$proc_tech	</td>
				</tr>
				<tr>
		  			<td class='table_param'>Metal layers:</td>
					<td class='table_value'>$metal_layer </td>
				</tr>
				<tr>
		  			<td class='table_param'>Metal type:</td>
					<td class='table_value'>$metal_type</td>
				</tr>
				<tr>
		  			<td class='table_param'>Transistors:</td>
					<td class='table_value'>$trans_cnt	</td>
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
					<td class='table_value'>$onchip_peripherals</td>
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
					<td class='table_value'>$date </td>
				</tr>
				<tr>
		  			<td class='table_param'>Introduction price:</td>
					<td class='table_value'>$price</td>
				</tr>
				<tr>
		  			<td class='table_param'>Typical application:</td>
					<td class='table_value'>$applications</td>
				</tr>
				<tr>
		  			<td class='table_param'>Military Specs:</td>
					<td class='table_value'>$mil</td>
				</tr>
				<tr>
		  			<td class='table_param'>Features:</td>
					<td class='table_value'>$features</td>
				</tr>
				<tr>
		  			<td class='table_param'>Comments:</td>
					<td class='table_value'>$comments</td>
				</tr>
			</table>
		</td>
	</tr>
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
	
	</div>

Endhtml

	return $html_code;
}



sub display_manuf_list{
	my $html_code = '';

	foreach my $manuf (@manuf_list_g){
		if( $manuf ne '' ){
			$html_code .= "<a href=\"$script_name_g?page=m&manuf=$manuf\">$manuf</a> <br />\n";
		}
	}

	return $html_code;

}


sub display_families_list{
	my $html_code = '';
	
	foreach my $fam (@family_list_g){
		if( $fam ne '' ){
			$html_code .= "<a href=\"$script_name_g?page=f&family=$fam\">$fam</a> <br />\n";
		}
	}

	return $html_code;
}


sub display_todo_page{
	my $html_code = '';
		
	open FILE, $todo_file_loc_g;
	print "	<pre>\n";
	while (<FILE>) { 
		print $_; 
	}
	print "	</pre>\n";
	close(FILE);

	return $html_code;
}


sub display_download_page {
	my $html_code = '';
	
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

sub display_contrib_page {
	my $html_code = '';
	
	$html_code .= <<Endhtml;


	<h1>Contribute to the projects</h1>

	I'm new to this so I found this howto: <a href="http://www.lornajane.net/posts/2010/contributing-to-projects-on-github">Contributing to Projects on GitHub</a>


Endhtml

	return $html_code;
}




sub display_contact_page {
	my $html_code = '';
	
	$html_code .= <<Endhtml;


<form id="emf-form" target="_self" enctype="multipart/form-data" method="post" action="http://www.emailmeform.com/builder/form/73zarfUT9KeLqdbcY7VtpeO" name="emf-form">
  <table style="text-align:left;" cellpadding="2" cellspacing="0" border="0" bgcolor="transparent">
    <tr>
      <td style="" colspan="2">
        <font face="Verdana" size="2" color="#000000"><b style="font-size:20px;">Contact Form</b><br />
        <br /></font>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_0" style="" align="">
        <font face="Verdana" size="2" color="#000000"><b>Name</b></font> <span style="color:red;"><small>*</small></span>
      </td>
    </tr>
    <tr>
      <td id="td_element_field_0" style="">
        <input id="element_0" name="element_0" value="" size="30" class="validate[required]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_1" style="" align="">
        <font face="Verdana" size="2" color="#000000"><b>Email</b></font> <span style="color:red;"><small>*</small></span>
      </td>
    </tr>
    <tr>
      <td id="td_element_field_1" style="">
        <input id="element_1" name="element_1" class="validate[required,custom[email]]" value="" size="30" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_2" style="" align="">
        <font face="Verdana" size="2" color="#000000"><b>Subject</b></font> <span style="color:red;"><small>*</small></span>
      </td>
    </tr>
    <tr>
      <td id="td_element_field_2" style="">
        <input id="element_2" name="element_2" value="" size="30" class="validate[required]" type="text" />
        <div style="padding-bottom:8px;color:#000000;"></div>
      </td>
    </tr>
    <tr valign="top">
      <td id="td_element_label_3" style="" align="">
        <font face="Verdana" size="2" color="#000000"><b>Message</b></font> <span style="color:red;"><small>*</small></span>
      </td>
    </tr>
    <tr>
      <td id="td_element_field_3" style="">
        <textarea id="element_3" name="element_3" cols="60" rows="10" class="validate[required]">
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
        <input name="element_counts" value="4" type="hidden" /> <input name="embed" value="forms" type="hidden" /><input value="Send email" type="submit" /><input value="Clear" type="reset" />
      </td>
    </tr>
  </table>
</form>
<div>
  <font face="Verdana" size="2" color="#000000">Powered by</font><span style="position: relative; padding-left: 3px; bottom: -5px;"><img src=
  "https://www.emailmeform.com/builder/images/footer-logo.png" /></span><font face="Verdana" size="2" color="#000000">EMF</font> <a style="text-decoration:none;" href="http://www.emailmeform.com/"
  target="_blank"><font face="Verdana" size="2" color="#000000">Web Forms Builder</font></a>
</div><a style="line-height:20px;font-size:70%;text-decoration:none;" href="http://www.emailmeform.com/report-abuse.html?https://www.emailmeform.com/builder/form/73zarfUT9KeLqdbcY7VtpeO" target=
"_blank"><font face="Verdana" size="2" color="#000000">Report Abuse</font></a>

Endhtml

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

<a href="$script_name_g">Home</a> | <a href="$script_name_g?page=cat&type=chips">Chips</a> | <a href="$script_name_g?page=cat&type=manuf">Manufacturer</a> | <a href="$script_name_g?page=cat&type=families">Families</a> | <a href="$script_name_g?page=download">Download DB</a> | <a href="$script_name_g?page=contrib">Help Out</a> | <a href="$script_name_g?page=contact">Contact</a> <br /><br />

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
	}elsif( $cgi_input{'page'} eq 'download' ){
		$html_code .= display_download_page();
	}elsif( $cgi_input{'page'} eq 'contrib' ){
		$html_code .= display_contrib_page();
	}elsif( $cgi_input{'page'} eq 'contact' ){
		$html_code .= display_contact_page();
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

$script_name_g = $ENV{'SCRIPT_NAME'};


# Gets input args
%cgi_input = &read_input; #get input

$speed_up = not($cgi_input{'page'} eq '' || $cgi_input{'page'} eq 'TODO' || $cgi_input{'page'} eq 'contact' || $cgi_input{'page'} eq 'TODO');

# if(  not($cgi_input{'page'} eq '') ){
	@cpu_db = import_csv_db($database_location);
	&get_col_labels();
	&get_chip_list;
# }


$html_code_g .= main_page();

# $html_code_g .= display_chips_page();
# $html_code_g .= display_manuf_page('Intel');
# $html_code_g .= display_manuf_family_page('Intel','386');
# $html_code_g .= display_single_chip_info_g('Intel','A80186');

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
