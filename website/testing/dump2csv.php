
<?php

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: dumps the db to a csv file
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////





// Source files
include 'globals.php'; // global variables
include 'db_connect.php'; //connect to the dbs


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



function exportMysqlToCsv($table)
{
	$filename_basic = 'extracted_cpu_db_csv/cpu-db';

    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";

    $manufs = array();
    $manufs = get_manuf_list_alphabetical();
    array_push($manufs, "*");



 foreach($manufs as $manuf){

	if($manuf === "*"){
		$sql_query = "select * from $table";
		$filename = $filename_basic . ".csv";
	}else{
		$sql_query = "select * from $table WHERE manufacturer='$manuf'";
		$filename =  $filename_basic . ".$manuf.csv";
		$filename = str_replace(' ','_',$filename);
	}


	echo "Creating $filename... \n";
    
    // Gets the data from the database
    $result = mysql_query($sql_query);
    $fields_cnt = mysql_num_fields($result);


    $schema_insert = '';
    for ($i = 0; $i < $fields_cnt; $i++)
    {
        $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
            stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
        $schema_insert .= $l;
        $schema_insert .= $csv_separator;
    } // end for
    $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++)
        {
            if ($row[$j] == '0' || $row[$j] != '')
            {
                if ($csv_enclosed == '')
                {
                    $schema_insert .= $row[$j];
                } else
                {
                    $schema_insert .= $csv_enclosed .
                    str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
                }
            } else
            {
                $schema_insert .= '';
            }
            if ($j < $fields_cnt - 1)
            {
                $schema_insert .= $csv_separator;
            }
        } // end for
        $out .= $schema_insert;
        $out .= $csv_terminated;
    } // end while
    file_put_contents($filename, $out);

  }


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




exportMysqlToCsv($table_cpu_db);


$query = "SELECT * INTO OUTFILE 'table.csv' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\n' FROM $table_cpu_db";

//echo $query;

// parse_db_query($query);


?>
