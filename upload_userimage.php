<?php

// https://www.php-einfach.de/php-tutorial/dateiupload/
// 
// USAGE:
// <form action="upload.php" method="post" enctype="multipart/form-data">
// <input type="file" name="datei"><br>
// <input type="submit" value="Hochladen">
// </form>

$upload_folder = 'upload/';
$filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
$extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
if(!in_array($extension, $allowed_extensions)) {
echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
header("Location: ./login.php?auto=1");
die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");
}
 
//Überprüfung der Dateigröße
$max_size = 500*1024; //500 KB
if($_FILES['datei']['size'] > $max_size) {
	echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
	header("Location: ./login.php?auto=1");
	die("Bitte keine Dateien größer 500kb hochladen");
}
 
//Überprüfung dass das Bild keine Fehler enthält
if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
 $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
 $detected_type = exif_imagetype($_FILES['datei']['tmp_name']);
 if(!in_array($detected_type, $allowed_types)) {
 	echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
 	header("Location: ./login.php?auto=1");
    die("Nur der Upload von Bilddateien ist gestattet");
 }
}
 
//Pfad zum Upload
$new_path = $upload_folder.$filename.'.'.$extension;
 
//Neuer Dateiname falls die Datei bereits existiert
if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
 $id = 1;
 do {
 $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
 $id++;
 } while(file_exists($new_path));
}
 
//Alles okay, verschiebe Datei an neuen Pfad
move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);
echo 'Bild erfolgreich hochgeladen: <a href="'.$new_path.'">'.$new_path.'</a>';
?>
