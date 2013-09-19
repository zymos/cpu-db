<html>
<head>
	<title>Upload</title>
</head>
<body>
<?php

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
////
////    cpu-db.info
////
////    Description: PHP version of the code for 
////    cpu-db.info, based on the origial perl script
////
////	File discription: upload images
////	
////    Author: ZyMOS
////    License: GPL v3.0
////    Date: Sept 2013
////    
////	resize image class by zorroswordsman at gmail dot com  
////	from http://php.net/manual/en/function.imagecopyresampled.php



/////////////
// Config
$file_size_limit = 2 * 1024 * 1024; // less than 2MiB
$upload_folder = "images/upload/";
$resize_folder = "images/thumbs/";
$thumb_size = 300;


////////////
// code
include 'globals.php';
include 'login_functions.php'; // login functions







function print_upload_info($resize_result){
	global $upload_folder, $final_filename, $resize_folder;
	
	$new_filename = $_POST["new_filename"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$side = $_POST["side"];
	$license = $_POST["license"];
	$author = $_POST["author"];
	$source = $_POST["source"];
	$date = $_POST["date"];
	$comments = $_POST["comments"];

	$file_name = $_FILES["file"]["name"];
	$file_type = $_FILES["file"]["type"];
	$file_size = $_FILES["file"]["size"];
	$file_tmp_name = $_FILES["file"]["tmp_name"];

	$username = $_SESSION['username'];

	$file_size = round($file_size / 1024);

	// $final_filename = create_new_filename();
	list($width, $height, $type, $attr) = getimagesize($upload_folder . $final_filename);

	$up_date = date("Y-m-d");
	
	$thumb_filename = $resize_folder . "thumb_" . $final_filename;
	
	// echo "$thumb_filename<br />\n";
	
	if( file_exists($resize_folder . "thumb_" . $final_filename) ){
		$resize_result_text = '';
		$resize_img_text = '<i>Image thumbnail:</i><br /><img src="' . $thumb_filename . '">';
	}else{
		$resize_result_text = "<div style=\"color: red;\">Thumbnail creation failed.</div>\n<div>This is a problem with the script and hopefully someone will notice and fix it, sorry for the trouble.</div><br />\n";
		$resize_img_text = '';
	}

	echo <<<Endhtml
	
		<div style="border-style: solid; border-width: 1px; padding: 10px;">
			<h2>Upload Success</h2>

			$resize_result_text
			<table>
				<tr>
					<td width="500">
			<b>new_filename:</b> $new_filename<br />
			<b>Manufacturer:</b> $manuf<br />
			<b>Part number:</b> $part<br />
			<b>Image view:</b> $side<br />
			<b>License:</b> $license<br />
			<b>Author:</b> $author<br />
			<b>Source:</b> $source<br />
			<b>Creation date:</b> $date<br />
			<b>Comments:</b> <br /> <pre>$comments</pre>
					</td><td>
				$resize_img_text
					</td>
				</tr><tr>
					<td colspan="2">
			<b>Original file name:</b> $file_name<br />
			<b>File type:</b> $file_type<br />
			<b>File size:</b> $file_size KiB<br />
			<b>Image size:</b> $width x $height<br />

			<b>Uploader username:</b> $username<br />
			<b>Upload date:</b> $up_date<br />
			<b>Saved filename:</b> $final_filename<br />

			<b>Uploaded image:</b> <a href="$upload_folder$final_filename">$final_filename</a><br />
					</td>
				</tr>
			</table>
			<br />
		</div>
Endhtml;

}








function create_new_filename(){
	global $upload_folder;

	$final_filename = '';

	$new_filename = $_POST["new_filename"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$side = $_POST["side"];
	$license = $_POST["license"];
	$author = $_POST["author"];
	$source = $_POST["source"];
	$date = $_POST["date"];
	$comments = $_POST["comments"];

	$file_name = $_FILES["file"]["name"];
	$file_type = $_FILES["file"]["type"];
	$file_size = $_FILES["file"]["size"];
	$file_tmp_name = $_FILES["file"]["tmp_name"];

	$username = $_SESSION['username'];

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if( $file_type == "image/gif" ){
		$new_ext = "gif";
	}elseif($file_type == "image/jpeg"){
		$new_ext = "jpg";
	}elseif($file_type == "image/jpg"){
		$new_ext = "jpg";
	}elseif($file_type == "image/pjpeg"){
		$new_ext = "jpg";
	}elseif($file_type == "image/x-png"){
		$new_ext = "png";
	}elseif($file_type == "image/png"){
		$new_ext = "png";
	}

	$final_filename = "$manuf--$part--$side---$new_filename---$date.$new_ext";
	if( file_exists($upload_folder . $final_filename) ){ 
		$final_filename = "$manuf--$part--$side---$new_filename---$date--v2.$new_ext";
		if( file_exists($upload_folder . $final_filename) ){ 
			$final_filename = "$manuf--$part--$side---$new_filename---$date--v3.$new_ext";
			if( file_exists($upload_folder . $final_filename) ){ 
				$final_filename = "$manuf--$part--$side---$new_filename---$date--v4.$new_ext";
				if( file_exists($upload_folder . $final_filename) ){ 
					$final_filename = "$manuf--$part--$side---$new_filename---$date--v5.$new_ext";
					if( file_exists($upload_folder . $final_filename) ){ 
						$final_filename = "$manuf--$part--$side---$new_filename---$date--v6.$new_ext";
						if( file_exists($upload_folder . $final_filename) ){ 
							$final_filename = "$manuf--$part--$side---$new_filename---$date--v7.$new_ext";
							if( file_exists($upload_folder . $final_filename) ){ 
								$final_filename = "$manuf--$part--$side---$new_filename---$date--v8.$new_ext";
							}
						}
					}
				}
			}
		}
	}

	$final_filename = preg_replace ('/[^\p{L}\p{N}-.]/u', '_', $final_filename);
	return $final_filename;
}








function check_it(){
	global $file_size_limit, $upload_folder, $final_filename;

	$check_results=true;
	$error_text = '';

	$new_filename = $_POST["new_filename"];
	$manuf = $_POST["manuf"];
	$part = $_POST["part"];
	$side = $_POST["side"];
	$license = $_POST["license"];
	$author = $_POST["author"];
	$source = $_POST["source"];
	$date = $_POST["date"];
	$comments = $_POST["comments"];

	$file_name = $_FILES["file"]["name"];
	$file_type = $_FILES["file"]["type"];
	$file_size = $_FILES["file"]["size"];
	$file_tmp_name = $_FILES["file"]["tmp_name"];

	$username = $_SESSION['username'];

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	list($width, $height, $type, $attr) = getimagesize($file_tmp_name);


	if (! (($file_type == "image/gif")
	|| ($file_type == "image/jpeg")
	|| ($file_type == "image/jpg")
	|| ($file_type == "image/pjpeg") // progressive jpeg
	|| ($file_type == "image/x-png")
	|| ($file_type == "image/png"))){
		$error_text .= "Invalid file type: $file_type<br />\n";
		$check_results=false;
	}
	if( ! in_array($extension, $allowedExts) ){
		$error_text .= "Invalid file extension: $extension<br />\n";
		$check_results= false ;
	}
	if( ! ($width >= 1000 || $height >= 1000 ) ){
		$error_text .= "File is not 1000px or more: image size is $width x $height<br />\n";
		$check_results=false;		
	}
	if ($file_size > $file_size_limit){
		$error_text .= "File is over $file_size_limit Bytes<br />\n";
		$check_results=false;
	}
	if ($_FILES["file"]["error"] > 0){
   		$error_text .= "File error: Return Code: " . $_FILES["file"]["error"] . "<br />\n";
		$check_results=false;
	}
	if( strlen($new_filename ) < 1 ){
		$error_text .= "Invalid new_filename : $new_filename <br />\n";
		$check_results=false;
	} 
	if( strlen($manuf ) < 2 ){
		$error_text .= "Invalid manuf : $manuf <br />\n";
		$check_results=false;
	} 
	if( strlen($part ) < 3 ){
		$error_text .= "Invalid part : $part <br />\n";
		$check_results=false;
	} 
	if( $side === "false" ){
		$error_text .= "Invalid side : $side <br />\n";
		$check_results=false;
	} 
	if( $license === "false" ){
		$error_text .= "Invalid license : $license <br />\n";
		$check_results=false;
	} 
	if( strlen($author ) < 3 ){
		$error_text .= "Invalid author : $author <br />\n";
		$check_results=false;
	} 
	if( strlen($source ) < 4 ){
		$error_text .= "Invalid source : $source <br />\n";
		$check_results=false;
	} 
	if( ! preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ){
		$error_text .= "Invalid date format: $date <br />\n";
		$check_results=false;
	} 
	// if(login_check($mysqli) == false) {
		// $error_text .= "Not logged in.<br />\n";
		// $check_results=false;
	// } 
	if( file_exists($upload_folder . $final_filename) ){ 
		$error_text .= "File already exists: " . create_new_filename() . "<br />\n";
		$check_results=false;
	} 


	if( ! $check_results ){
		echo <<<Endhtml
		<div style="border-style: solid; border-width: 1px; padding: 10px;">
			<h2 style="color: red;">Upload Error</h2>
			$error_text
			<br />
		</div>
Endhtml;
	}

	return $check_results;
}



function upload_it(){
	global $upload_folder, $final_filename;

	$file_tmp_name = $_FILES["file"]["tmp_name"];
	
	if(	move_uploaded_file($file_tmp_name, $upload_folder . $final_filename) ){
		$success = true;
	}else{
		$success = false;
	}
	
	return $success;
}






// Imaging
class imaging
{

    // Variables
    private $img_input;
    private $img_output;
    private $img_src;
    private $format;
    private $quality = 90;
    private $x_input;
    private $y_input;
    private $x_output;
    private $y_output;
    private $resize;

    // Set image
    public function set_img($img)
    {

        // Find format
        $ext = strtoupper(pathinfo($img, PATHINFO_EXTENSION));

        // JPEG image
        if(is_file($img) && ($ext == "JPG" OR $ext == "JPEG"))
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromJPEG($img);
            $this->img_src = $img;
           

        }

        // PNG image
        elseif(is_file($img) && $ext == "PNG")
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromPNG($img);
            $this->img_src = $img;

        }

        // GIF image
        elseif(is_file($img) && $ext == "GIF")
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromGIF($img);
            $this->img_src = $img;

        }

        // Get dimensions
        $this->x_input = imagesx($this->img_input);
        $this->y_input = imagesy($this->img_input);

    }

    // Set maximum image size (pixels)
    public function set_size($size = 100)
    {

        // Resize
        if($this->x_input > $size && $this->y_input > $size)
        {

            // Wide
            if($this->x_input >= $this->y_input)
            {

                $this->x_output = $size;
                $this->y_output = ($this->x_output / $this->x_input) * $this->y_input;

            }

            // Tall
            else
            {

                $this->y_output = $size;
                $this->x_output = ($this->y_output / $this->y_input) * $this->x_input;

            }

            // Ready
            $this->resize = TRUE;

        }

        // Don't resize
        else { $this->resize = FALSE; }

    }

    // Set image quality (JPEG only)
    public function set_quality($quality)
    {

        if(is_int($quality))
        {

            $this->quality = $quality;

        }

    }

    // Save image
    public function save_img($path)
    {

        // Resize
        if($this->resize)
        {

            $this->img_output = ImageCreateTrueColor($this->x_output, $this->y_output);
            ImageCopyResampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);

        }

        // Save JPEG
        if($this->format == "JPG" OR $this->format == "JPEG")
        {

            if($this->resize) { imageJPEG($this->img_output, $path, $this->quality); }
            else { copy($this->img_src, $path); }

        }

        // Save PNG
        elseif($this->format == "PNG")
        {

            if($this->resize) { imagePNG($this->img_output, $path); }
            else { copy($this->img_src, $path); }

        }

        // Save GIF
        elseif($this->format == "GIF")
        {

            if($this->resize) { imageGIF($this->img_output, $path); }
            else { copy($this->img_src, $path); }

        }

    }

    // Get width
    public function get_width()
    {

        return $this->x_input;

    }

    // Get height
    public function get_height()
    {

        return $this->y_input;

    }

    // Clear image cache
    public function clear_cache()
    {

        @ImageDestroy($this->img_input);
        @ImageDestroy($this->img_output);

    }
}



function resize_it(){
	global $thumb_size, $final_filename, $resize_folder, $upload_folder;

	// Image
	$src = $upload_folder . $final_filename;
	$thumb_filename = $resize_folder . "thumb_" . $final_filename;

	// echo "resize -- $src<br />$thumb_filename<br />\n";

	// Begin
	$img = new imaging;
	$img->set_img($src);
	$img->set_quality(90);


	// Small thumbnail
	$img->set_size($thumb_size);
	$img->save_img($thumb_filename);

	// Finalize
	$img->clear_cache();
}





echo "<h1>Image Upload</h1><br />\n";

$final_filename = create_new_filename();
$check_results = check_it();

if( $check_results ){
	$upload_results = upload_it();
	if( $upload_results ){
		resize_it();
		print_upload_info($resize_result);
	}
}


// $filename_thumb = resize_it($filename_saved);

?>
</body>
</html>
