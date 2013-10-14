<?php
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: mysql query functions
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////

include 'globals.php';



///////////////
// functions





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




function mysql_grab_assoc_1d($query) {
	$result_array = array();
	// $row = array();

	$result = parse_db_query( $query );
	$result_array = mysql_fetch_assoc($result);
	return $result_array;
}







?>
