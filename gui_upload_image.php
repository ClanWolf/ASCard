<?php
$target_dir = "images/player/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$resultString = "";

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		$resultString = $resultString . "File is an image - " . $check["mime"] . ". ";

		$x = $check[0];
		$y = $check[1];

		//echo("X: " . $x);
		//echo("Y: " . $y);

		if ($x !== $y) {
			$resultString = $resultString . "File needs to be square. ";
			$uploadOk = 0;
		} else {
			$resultString = $resultString . "File is square. ";
			$uploadOk = 1;
		}

		if ($x > 200) {
			$resultString = $resultString . "File is bigger than 200 px. ";
			$uploadOk = 0;
		} else {
			$resultString = $resultString . "File is smaller than 200 px. ";
			$uploadOk = 1;
		}
	} else {
		$resultString = $resultString . "File is not an image. ";
		$uploadOk = 0;
	}
}

// Check if file already exists
if (file_exists($target_file)) {
	$resultString = $resultString . "ERROR: file already exists. ";
	$uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
	$resultString = $resultString . "ERROR: file is too large. ";
	$uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
	$resultString = $resultString . "ERROR: only JPG, JPEG and PNG files are allowed. ";
	$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	$resultString = $resultString . "File was NOT uploaded. ";
} else {
	// if everything is ok, try to upload file
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$resultString = $resultString . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded. ";
	} else {
		$resultString = $resultString . "ERROR uploading file. ";
	}
}

echo $resultString;

?>
