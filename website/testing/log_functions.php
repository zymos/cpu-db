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

function log_it($text, $level){
	global $log_file, $log_verboseness;

	// $level of verboseness in log
	// 	5=everything
	// 	4=errors/warnings
	// 	3=
	// 	2=
	// 	1=
	// 	0=nothing
	
	if( empty($level) ){
		$level_text = '::level_not_set ';
	}else{
		$level_text = '';
	}

	if( empty($_SESSION['username']) ){
		$username = '?';
	}else{
		$username = $_SESSION['username'];
	}

	$the_date = date("Y-m-d H:i:s");

	if( ($log_verboseness >= $level) || empty($level) ){
		$log_output = "$the_date :: $text $level_text [" .  $_SESSION['username'] . "]\n";
	
		$fh=fopen($log_file,"a") ;
		fwrite($fh, $log_output);
		fclose($fh);
	}
}


?>
