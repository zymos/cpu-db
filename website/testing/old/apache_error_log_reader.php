<?php

/**
* A script to emulate the UNIX tail function by displaying the last X number
* of lines in a file.
*
* Useful for large files, such as logs, when you want to process lines in PHP
* or write lines to a database.
*
* @author Dan Ruscoe
* https://github.com/ruscoe/PHP-Tail/blob/master/tail.php
*/

// The name of the file to read
define('FILE_NAME','/var/www/cpu-db.info/cpu-db.info.error.log');

// The number of lines to display
define('LINES_TO_DISPLAY',10);

if (!is_file(FILE_NAME)) {
die("Not a file - ".FILE_NAME."\n");
}

if (LINES_TO_DISPLAY < 1) {
die("Number of lines to display must be greater than 0\n");
}

if (!$lines = get_lines(FILE_NAME,LINES_TO_DISPLAY)) {
die("Could not get lines from file - ".FILE_NAME."\n");
}

foreach ($lines as $line) {
echo $line;
}

exit;

/**
* Returns an array containing X number of rows from the end of a file.
*
* @param string $filename
* @param int $lines_to_display
* @return array
*/

function get_lines($filename,$lines_to_display) {

// Open the file.
if (!$open_file = fopen($filename,'r')) {
return false;
}

$pointer = -2;	// Ignore new line characters at the end of the file

$char = '';

$beginning_of_file = false;

$lines = array();

for ($i=1;$i<=$lines_to_display;$i++) {

if ($beginning_of_file == true) {
continue;
}

/**
* Starting at the end of the file, move the pointer back one
* character at a time until it lands on a new line sequence.
*/

while ($char != "\n") {

// If the beginning of the file is passed
if(fseek($open_file,$pointer,SEEK_END) < 0) {

$beginning_of_file = true;

// Move the pointer to the first character
rewind($open_file);

break;

}

// Subtract one character from the pointer position
$pointer--;

// Move the pointer relative to the end of the file
fseek($open_file,$pointer,SEEK_END);

// Get the current character at the pointer
$char = fgetc($open_file);

}

array_push($lines,fgets($open_file));

// Reset the character.
$char = '';

}

// Close the file.
fclose($open_file);

/**
* Return the array of lines reversed, so they appear in the same
* order they appear in the file.
*/

return array_reverse($lines);

}

?>
