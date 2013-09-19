<?php
// phpinfo();
function poop() {
	global $r, $table;
	$rs = array();
	
	// $query = "SELECT DISTINCT manufacturer,chip_type,family FROM $table";

	$query = "SELECT DISTINCT manufacturer,chip_type,family FROM cpu_db_table";


	// $query = "SELECT DISTINCT manufacturer FROM $table LIMIT 10";

	$rs = mysql_query($query, $r);
	// $rs = parse_db_query($query);

	if (!$rs) {
		echo "Could not execute query: $query\n";
		trigger_error(mysql_error(), E_USER_ERROR);
	} else {
		echo "Query: $query executed\n"; 
	}


	while ($row = mysql_fetch_assoc($rs)) {
    	echo $row['manufacturer'] . "\n";
	}

	
}


function parse_db_query ( $query ) {
	global $r;
	
	// $query = "SELECT DISTINCT manufacturer,chip_type,family FROM cpu_db_table";
	
	
	$results = array();

	$results = mysql_query( $query, $r);
	if (!$results) {
    	echo "Could not execute query: $query\n";
	    trigger_error(mysql_error(), E_USER_ERROR);
	}
	return $results;
}

function connect_db() {
	global $host, $user, $pass, $db;
	
	$r = mysql_connect($host, $user, $pass);

	if (!$r) {
    	echo "Could not connect to server\n";
	    trigger_error(mysql_error(), E_USER_ERROR);
	} 

	$r2 = mysql_select_db($db);

	if (!$r2) {
    	echo "Cannot select database\n";
	    trigger_error(mysql_error(), E_USER_ERROR); 
	}

	return $r;
}





$db ="cpu_db";
$table ="cpu_db_table";
$user = "cpudb_user";
$pass = "thepasswordforcpudbuser";
$host="localhost";



$r = connect_db();

echo "hello....\n";
$rs = parse_db_query ( $query ) ;
// poop();
while ($row = mysql_fetch_assoc($rs)) {
	echo $row['manufacturer'] . "\n";
}
mysql_close();
?>
