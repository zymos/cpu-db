<?php


echo "hello";

include 'globals.php';
include 'db_connect2.php';
include 'db_query_functions.php';
include 'debug_functions.php';
include 'display_cpu_db_page_functions.php';
include 'get_info_functions.php';


$images = array();

$images = get_image_filename_list();

print_array($images);


function does_image_exist($filename){

	return in_array($filename, get_image_filename_list());

}


echo "<br />\n";

$filename = 'manuftest--parttest--top---ccc---1999-01-01.jpg';
if(does_image_exist($filename)){
	echo "true";
}else{
	echo "false";
}

echo "<br />\n";

$filename = 'manuftest--parttest--top---ccc--99-1999-01-01.jpg';

if(does_image_exist($filename)){
	echo "true";
}else{
	echo "false";
}

?>

