

<?php

include 'db_connect.php';
include 'login_functions.php';
// sec_session_start(); // Our custom secure way of starting a php session. 



$log_file = "cpu-db.log";
$the_date = date("Y-m-d H:i:s");
$fh=fopen($log_file,"a") ;


require_once('recaptcha-php/recaptchalib.php');

$resp = recaptcha_check_answer($privkey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);



if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
	$log_output = "$the_date :: Registration: Failed, incorrect CAPTCHA, by USER=" . $_POST['username'] . ", EMAIL=". $_POST['email'] . "\n";
	fwrite($fh, $log_output);
    echo "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
} else {

  if(isset($_POST['email'], $_POST['p'])) { 

	// The hashed password from the form
	$password = $_POST['p']; 
	$email = $_POST['email'];
	$username =$_POST['username'];

	// echo "pass =	$password <br />";
	// Create a random salt
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	// Create salted password (Careful not to over season)
	$password = hash('sha512', $password.$random_salt);
	// echo "pass =	$password <br />";
	// echo "salt =$random_salt 	 <br />";
 
	// Add your insert to database script here. 
	// Make sure you use prepared statements!
	if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {    
	   $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt); 
	   // Execute the prepared query.
	   $insert_stmt->execute();
	   // echo "success<br />$password <br /> $email <br />	$username";
	   $redirect = "Location: ./login.php?registered=1&referer=" . $_POST['referer'];
		$log_output = "$the_date :: Registration: Success, by USER=" . $_POST['username'] . ", EMAIL=". $_POST['email'] . "\n";
		fwrite($fh, $log_output);
	   
	   header($redirect);
	}else{
		$log_output = "$the_date :: Registration: Failed, error, by USER=" . $_POST['username'] . ", EMAIL=". $_POST['email'] . "\n";
		fwrite($fh, $log_output);
		echo "error";
	}
  } else { 
   // The correct POST variables were not sent to this page.
	  	echo 'Invalid Request';
		$log_output = "$the_date :: Registration: Failed, Invalid Request, by USER=" . $_POST['username'] . ", EMAIL=". $_POST['email'] . "\n";
		fwrite($fh, $log_output);

  }
}
fclose($fh);
?>
