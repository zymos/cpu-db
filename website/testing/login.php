<!DOCTYPE html>
<?php
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: login page
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: June 2013
////

include 'globals.php'; // global variables
include 'db_connect2.php';
require_once('lib/recaptcha-php/recaptchalib.php');
include 'display_cpu_db_page_functions.php'; // display page functions







function display_header_mod(){
	global $mysqli, $script_name_g;

	$html_code = '';

	// $chip_count = get_chip_count();
	// $update_date = get_update_date();

	// $html_code .= "content-type: text/html \n\n"; #HTTP HEADER

	// if( $_GET["page"] === 'login'  ){
		// $login_head_code = display_login_head_code();
	// }else{
		// $login_head_code = '';
	// }

	$html_code .= <<<Endhtml
<html>
<head>
	<title>HTML_HEAD_TITLE</title>
	<meta name="description" content="A Database for CPU, MCU, DSP, and BSP information" />
	<meta name=keywords content="HTML_HEAD_KEYWORDS" />
  <style>
    h1 {
		font-size: 30px; 
		font-weight: bold;
	}
	#bode {  
    	margin: 0 auto;  
		border: 1px;
    }  
	#chip_count {
	    position: absolute;
    	top: 20px;
	    right: 20px;
		font-size: 12px; 
	}
	#lists {
    	margin-left: 50px;
		border: 1px;
	}
	#chip_content {
		margin: 0 25px 0 0;
		padding: 0;
		border: 1px;
	}
	#chip_content_params {
		margin: 0 25px 0 0;
		padding: 0;
	  border: 1px;

	}

	.body_content_indent {
		margin-left: 25px;
	}

	.family_table_td {
		vertical-align: top;
		padding: 10px;
		width: 500px;
	}

	.table_param {
		width: 150px;
		font-size: 12px; 
		font-weight: bold;
	}

	.table_param_long {
		width: 200px;
		font-size: 12px; 
		font-weight: bold;
	}

	.table_sec {
		font-size:16px; 
		font-weight:bold;
	}

	.table_value {
		font-size: 12px;
	}

	.table_td_blank {
		width: 25px;
	}

	.warning_message {
		color: red;
		font-size: 12px;
		font-style: italic;
	}

</style>
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
	
<h1 style="color: red;">cpu-db.info (PHP)</h1>
Endhtml;
	
	// if(login_check($mysqli) == true) {
		// $username = $_SESSION['username'];
		// $html_code .= "$username, <a href=\"logout.php\">Logout</a>";
		// Add your protected page content here!
	// } else {
		// $html_code .= '<a href="login.php">Login/Register</a>';
	// }

$html_code .= <<<Endhtml

<a href="http://cpu-db.info">Home</a> | <a href="$script_name_g?page=cat&amp;type=chips">Chips</a> | <a href="$script_name_g?page=cat&amp;type=manuf">Manufacturers</a> | <a href="$script_name_g?page=cat&amp;type=families">Families</a> | <a href="$script_name_g?page=add_chip">Add Chip</a> | <a href="$script_name_g?page=db">Access the db</a> | <a href="$script_name_g?page=about">About</a>  <br /><br />

	<div id="bode">
Endhtml;
	return $html_code;
}







function display_login_page2(){
	global $pubkey, $privkey;

	$html_code = '';


if(isset($_GET['error'])) { 
	$html_code .= '<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">';
	$html_code .= "\n<h2>Error Logging In!</h2>\n</div><br /><br />\n";
}elseif(isset($_GET['registered'])) { 
	$html_code .= '<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">';
	$html_code .= "\n<h2>You are now registered, try loggin in...</h2>\n</div><br /><br />\n";
}


	$html_code .= <<<Endhtml
	<div style="width:550px;padding:10px;border:5px solid gray;margin:0px;">
	<h1>Login:</h1><br />
	<form action="process_login.php" method="post" name="login_form">
	   Email: <input type="text" name="email" /><br />
	   Password: <input type="password" name="password" id="password"/><br />
Endhtml;

	// echo recaptcha_get_html($pubkey);
	if(isset($_GET['referer'])){
		$referal = $_GET['referer'];
	}else{
		$referal = urlencode($_SERVER['HTTP_REFERER']);
	}

	$html_code .= <<<Endhtml
	<input type="hidden" name="referer" value="$referal">
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
Endhtml;


    // require_once('recaptcha-php/recaptchalib.php');
	$html_code .= recaptcha_get_html($pubkey);

	$referal = urlencode($_SERVER['HTTP_REFERER']);

	$html_code .= <<<Endhtml
	<input type="hidden" name="referer" value="$referal">
	<input type="button" value="Register" onclick="formhash(this.form, this.form.password);" />
</form>
</div>
Endhtml;

	return $html_code;
}




//////////////////////////////////
//  Main Code
//

$html_code_g = '';
$html_title_g = 'cpu-db.info - Login page';
$html_keywords_g = 'CPU, MCU, DSP, BSP, database, login';
$script_name_g = 'index.php'; //#$ENV{'SCRIPT_NAME'};



$html_code_g .= display_header_mod();

$html_code_g .= display_login_page2();

$html_code_g .= display_footer();



echo $html_code_g;	

?>
