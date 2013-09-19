
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
$file_size = 2 * 1024 * 1024; // less than 2MiB
$upload_folder = "images/upload/";
$resize_folder = "images/resize/";
$size = 300;


////////////
// code
include 'globals.php';

function upload_it(){
	global $file_size, $upload_folder, $resize_folder, $_FILES;

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);


	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg") // progressive jpeg
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < $file_size)
	&& in_array($extension, $allowedExts)){
		if ($_FILES["file"]["error"] > 0){
   	 		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  	  	}else{

	  	  	//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    			if (file_exists($upload_folder . $_FILES["file"]["name"])) {
	    	  		echo "Error: the file " . $_FILES["file"]["name"] . " already exists. ";
	     	 	}else{
    				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . round(($_FILES["file"]["size"] / 1024),0) . " kB<br>";
				move_uploaded_file($_FILES["file"]["tmp_name"],
					$upload_folder . $_FILES["file"]["name"]);
				$filename_saved = $_FILES["file"]["name"];
	      			echo "Stored in: " . $upload_folder . $_FILES["file"]["name"];
      			}
    		}
 	}else{
  		echo "Invalid file";
	}
	return $filename_saved;
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



function resize_it($filename_uploaded){
	global $size;

	// Image
	$src = $filename_uploaded;

	// Begin
	$img = new imaging;
	$img->set_img($src);
	$img->set_quality(90);

	$filename_thumb = "thumb_" . $src;

	// Small thumbnail
	$img->set_size($size);
	$img->save_img("thumb_" . $src);

	// Finalize
	$img->clear_cache();

	return $filename_thumb;
}




$filename_saved = upload_it();

$filename_thumb = resize_it($filename_saved);

?>
