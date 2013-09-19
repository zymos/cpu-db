<?php

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////    
////    File Description: generates log
////   
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: Sept 2013
////



// code
include 'globals.php';

function log_it($text){
	global $log_file;

	$the_date = date("Y-m-d H:i:s");

	$log_output = "$the_date :: $text, by " .  $_SESSION['username'] . "\n";
	$fh=fopen($log_file,"a") ;

	fwrite($fh, $log_output);

	fclose($fh);
}


?>
