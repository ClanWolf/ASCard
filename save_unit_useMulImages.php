<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$playerId  = isset($_GET["playerId"]) ? $_GET["playerId"] : "";
	$useMulImages  = isset($_GET["useMulImages"]) ? $_GET["useMulImages"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";

	if (!empty($playerId)) {
		$sql = "UPDATE asc_options SET UseMULImages=".$useMulImages." WHERE playerid=".$playerId;
		//echo "Enable MULImages: " . $useMulImages . " for playerId: " . $playerId;
		//echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
			echo "Record (asc_options) updated successfully.";
			echo "</p>";
			mysqli_commit($conn);
			//echo "<script>top.location.reload();</script>";
		} else {
			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
			echo "Error (asc_options) updating record: " . mysqli_error($conn);
			echo "</p>";
		}

	}
	echo "</body>\n";
	echo "</html>\n";
?>
