<html>
<head></head>
<body>
<?php

include 'db_connect.php';
include 'login_functions.php';
include 'log.php';


sec_session_start(); // Our custom secure way of starting a php session. 

// require_once('recaptcha-php/recaptchalib.php');

// $resp = recaptcha_check_answer($privkey,
                                // $_SERVER["REMOTE_ADDR"],
                                // $_POST["recaptcha_challenge_field"],
                                // $_POST["recaptcha_response_field"]);


// if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
    // die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")");
// } else {
	if(isset($_POST['email'], $_POST['p'])) { 
	   $email = $_POST['email'];
	   $password = $_POST['p']; // The hashed password.
	   if(login($email, $password, $mysqli) == true) {
		   // Login success
		   $referer = urldecode($_POST['referer']);
		   echo "Success: You have been logged in!<br /><br />\n";
		   echo "<h1>Go <a href=\"$referer\">Back ($referer)</a></h1>\n";
		   echo "<a href=\"$referer\">$referer</a><br /><br />\n";
		   $log_output = "Login: Success";
		   log_it($log_output);
	   } else {
		   // Login failed
		   $log_output = "Login: Failed";
		   log_it($log_output);
		   header('Location: ./login.php?error=1');
	   }
	} else { 
	   // The correct POST variables were not sent to this page.
	   echo 'Invalid Request';
	}
// }
?>
</body>
</html>
