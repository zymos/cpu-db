<?php



include 'login_functions.php';
sec_session_start();


     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];


echo "     USERID=$user_id LOGIN=$login_string   USERNAME=$username";


?>

