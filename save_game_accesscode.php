<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? $_GET["gid"] : "";
	$rndint = isset($_GET["rndint"]) ? $_GET["rndint"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "UPDATING access code ".$rndint." for game ".$gid."...<br>\n";
	echo "<br>\n";

	if (!empty($gid) && !empty($rndint)) {
		$update_accesscode = "UPDATE asc_game SET accesscode = ".$rndint." WHERE gameid=".$gid;
		if (mysqli_query($conn, $update_accesscode)) {
			echo "<br>";
			echo "Game access code updated successfully<br>";
		} else {
			echo "<br>";
			echo "Error updating accesscode: " . mysqli_error($conn) . "<br>";
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
