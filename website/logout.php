<?php



include 'login_functions.php';

sec_session_start();

$log_file = "cpu-db.log";
$the_date = date("Y-m-d H:i:s");
$fh=fopen($log_file,"a") ;


$log_output = "$the_date :: Logout\n";
fwrite($fh, $log_output);

// Unset all session values
$_SESSION = array();
// get session parameters 
$params = session_get_cookie_params();
// Delete the actual cookie.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// Destroy session
session_destroy();
header('Location: ./');

fclose($fh);

?>

