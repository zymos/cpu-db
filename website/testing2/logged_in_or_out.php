<?php
include 'db_connect.php';
include 'login_functions.php';

// Include database connection and functions here.
sec_session_start();
if(login_check($mysqli) == true) {
 
   // Add your protected page content here!
   echo 'true';

} else {
   echo 'false';
}

?>
