<?php
include 'login_functions.php'; // login functions

################################
## login DB
##

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "sec_user"); // The database username.
define("PASSWORD", "eKcGZr59zAa2BEWU"); // The database password. 
define("DATABASE", "cpu_db_secure_login"); // The database name.
 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.

if($mysqli->connect_errno > 0){
	trigger_error('Login Database connection failed: '  . $mysqli->connect_error, E_USER_ERROR);
}



#########################
## Chips DB
##

sec_session_start(); // Our custom secure way of starting a php session. 

if(login_check($mysqli) == true) {
	define("USER_chips", "user_logged"); // The database username.
	define("PASSWORD_chips", "loggedIn9Dde3nNch1B"); // The database password. 
}else{
	define("USER_chips", "cpudb_user"); // The database username.
	define("PASSWORD_chips", "thepasswordforcpudbuser"); // The database password. 
}

define("DATABASE_chips", "cpu_db"); // The database name.
define("HOST_chips", "localhost"); // The host you want to connect to.

// $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.
$db_handle = mysql_connect(HOST_chips, USER_chips, PASSWORD_chips);

if (!$db_handle) {
   	echo "Could not connect to server\n";
    trigger_error(mysql_error(), E_USER_ERROR);
} 

$r2 = mysql_select_db(DATABASE_chips);

if (!$r2) {
   	echo "Cannot select database\n";
    trigger_error(mysql_error(), E_USER_ERROR); 
}


####################
## Google reCatcha
##

$pubkey = '6LeUT-USAAAAACfCac6kd_4-RK4EXFNK1LyHtkHd';
$privkey = '6LeUT-USAAAAAMy183l3HmFpzzt7xbeuwQG50hr3';

?>
