<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? $_GET["gid"] : "";
	$gameTitle = isset($_GET["gt"]) ? $_GET["gt"] : "";
	$gameBackground = isset($_GET["gbg"]) ? $_GET["gbg"] : "";
	$gy = isset($_GET["gy"]) ? $_GET["gy"] : "";
	$ge = isset($_GET["ge"]) ? $_GET["ge"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "UPDATING game info ".$gameBackground." for game ".$gameTitle."...<br>\n";
	echo "<br>\n";

	if (!empty($gid)) {
		$update_gameinfo = "UPDATE asc_game SET title = '".$gameTitle."', background='".$gameBackground."', yearInGame='".$gy."', era='".$ge."' WHERE gameid=".$gid;
		if (mysqli_query($conn, $update_gameinfo)) {
			echo "<br>";
			echo "Game info updated successfully<br>";
		} else {
			echo "<br>";
			echo "Error updating game info: " . mysqli_error($conn) . "<br>";
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
