<?php

if(!isset($_FILES['fileToUpload'])){
	die("No files to process");
}
// to get all the about the media info that is uploaded from /mediainfo.php 
$target_directory = 'images/';
$target_file = $target_directory . basename($_FILES['fileToUpload']['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if($imageFileType == 'jpg'){
	
	if(file_exists($target_file)){
		die('File already exists..');
	} else {
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
		echo "<img src='/$target_file' style='height: 500px;'/>"; // image is not loading...
		$cmd = 'mediainfo '.$target_file.' --output=HTML';
		//mediainfo image .jpg --output=HTML
		//mediainfo && ls #  ---output=HTML  can be cmd injected by using file name as cmd & need to be secured by giving temrory name.
		echo $cmd;
		echo system($cmd);
	}
} else {
	die("Invalid format");
}

?>
