<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? $_GET["gid"] : "";
	$locked = isset($_GET["locked"]) ? $_GET["locked"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "UPDATING set status for game ".$gid."...<br>\n";
	echo "<br>\n";

	if (!empty($gid)) {
		$update_gamelock = "UPDATE asc_game SET locked = ".$locked." WHERE gameid=".$gid;
		if (mysqli_query($conn, $update_gamelock)) {
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
