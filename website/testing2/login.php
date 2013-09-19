<?php
	include 'db_connect.php';
	require_once('recaptcha-php/recaptchalib.php');
?>
<html>
<head>
	<script type="text/javascript" src="sha512.js"></script>
	<script type="text/javascript" src="forms.js"></script>

<script> 
function validateForm() {
	var x=document.forms["reg_form"]["username"].value;
	var y=document.forms["reg_form"]["p"].value;
	if (x==null || x=="") {
		alert("Error: Username and password must be entered ");
		return false;
	}
 	if(x.length<5) {
    	alert("Your username must be at least \n5 characters long. \n Please try again.");
	    return false;
    }
	if (y==null || y=="") {
	   alert("Error: Username and password must be entered");
	   return false;
	}
	if(y.length<5) {
	    alert("Your username must be at least\n5 characters long.\n Please try again.");
    	//Login.txtpass.value = "";
	    //Login.txtpass.focus();
    	return false;
 	}else{
		alert("Error: Please check that you've entered and confirmed your password!");
		return false;
	}
}
</script>

</head>
<body>
<?php
if(isset($_GET['error'])) { 
	echo '<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">';
	echo "\n<h2>Error Logging In!</h2>\n</div><br /><br />\n";
}elseif(isset($_GET['registered'])) { 
	echo '<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">';
	echo "\n<h2>You are now registered, try loggin in...</h2>\n</div><br /><br />\n";
}
?>

<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">
<h1>Login:</h1><br />
<form action="process_login.php" method="post" name="login_form">
   Email: <input type="text" name="email" /><br />
   Password: <input type="password" name="password" id="password"/><br />
<?php
	// echo recaptcha_get_html($pubkey);
	if(isset($_GET['referer'])){
		$referal = $_GET['referer'];
	}else{
		$referal = urlencode($_SERVER['HTTP_REFERER']);
	}
	echo "<input type=\"hidden\" name=\"referer\" value=\"$referal\">\n";
?>

   <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
</form>
</div>
<br /><br />



<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">
<h1>Register:</h1>
<form action="process_registration.php" method="post" name="reg_form">
	Username: <input type="text" name="username" /><br />   
	Email: <input type="text" name="email" /><br />
   Password: <input type="password" name="password" id="password"/><br />
<?php
    // require_once('recaptcha-php/recaptchalib.php');
	echo recaptcha_get_html($pubkey);

	$referal = urlencode($_SERVER['HTTP_REFERER']);
	echo "<input type=\"hidden\" name=\"referer\" value=\"$referal\">\n";
?>

   <input type="button" value="Register" onclick="formhash(this.form, this.form.password);" />
</form>
</div>


</body>
</html>
