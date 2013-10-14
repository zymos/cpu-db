<?php
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: logging changes in the db
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////


function log_changes_in_db($manuf, $part){
	global $mysqli;
	// secure_login.edits
	// `user_id`,
	// `manuf`,
	// `part`,
	// `action`,
	// `time` 


	$now = time();
	$mysqli->query("INSERT INTO edits (user_id, manuf, part, time) VALUES ('$user_id', '$manuf', '$part', '$now')");



}





?>
