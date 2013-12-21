#!/usr/bin/perl 
#


# $filename = "cpu-db.RCA.csv";
$filename = "cpu-db.csv";

use Data::Dumper;
use Text::CSV::Slurp;



  my $data = Text::CSV::Slurp->load(file => $filename);
  # my $data = $slurp->load(file => $filename);

# print "<" . $data->[1]->{Manufacturer} . ">\n";


foreach ( @{$data} )
{
	# print "$_->{Manufacturer}, ";
	if( $_->{Manufacturer} ne '' ){
		$manuf->{ $_->{Manufacturer} } = 1;
	}
	if( $_->{Family} ne ''  ){
		$family->{ $_->{Family} } = 1;
	}
	if( $_->{Family} ne '' && $_->{Manufacturer} ne '' ){
		$manuf_family->{ $_->{Manufacturer} }->{ $_->{Family} } = 1;
	}
	if( $_->{Family} ne '' && $_->{Manufacturer} ne '' && $_->{'Chip Type'} ne '' ){
		$manuf_type_family->{ $_->{Manufacturer} }->{ $_->{'Chip Type'} }->{ $_->{Family} } = 1;
	}

    # print "$manuf{ $_->{Manufacturer} }";
}
# print "\n";

# {{manufacturer list
# |0_9_manufacturer_1=
# |a_manufacturer_1=
# }}

# print Dumper($data);
# print Dumper($manuf);
# print Dumper($family);
# print Dumper($manuf_family);
# print Dumper($manuf_type_family);


 
##############################
# Manuf
#
$prev_leter = 'a';
$count = 0;
print "{{manufacturer list\n";
foreach my $value ( sort {lc $a cmp lc $b} keys %{$manuf} ){
	$cur_leter = substr lc $value , 0, 1 ;
	if( $prev_leter eq $cur_leter ){
		$count++;
	}else{
		$count=1;
	}
	$param = $cur_leter . "_manufacturer_" . $count;
	print "|$param=$value\n";
	$prev_leter = $cur_leter;
}
print "}}\n\n";


##########################
# Family List
#
$prev_leter = 'a';
$count = 0;
print "{{family list\n";
foreach my $value ( sort {lc $a cmp lc $b} keys %{$family} ){
	$cur_leter = substr lc $value , 0, 1 ;
	if( $prev_leter eq $cur_leter ){
		$count++;
	}else{
		$count=1;
	}
	$param = $cur_leter . "_family_" . $count;
	print "|$param=$value\n";
	$prev_leter = $cur_leter;
}
print "}}\n\n";


