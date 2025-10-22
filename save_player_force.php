<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$pid = $_SESSION['playerid'];

	$pidtosave  = isset($_GET["pidts"]) ? $_GET["pidts"] : "";
	$opfor = isset($_GET["of"]) ? $_GET["of"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "pid to save: ".$pidtosave."<br>\n";
	echo "opfor: ".$opfor."<br>\n";

	if ($pidtosave !== "" && $opfor !== "") {
		echo "SAVING DATA...<br>\n";

		$sql = "UPDATE asc_player SET opfor=".$opfor." WHERE playerid=".$pidtosave;
		echo "Statement: " . $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>\n";
			echo "Record (asc_player) updated successfully";
			mysqli_commit($conn);

			echo "<script>top.window.location = './gui_edit_game.php'</script>\n";
		} else {
			echo "<br>\n";
			echo "Error (asc_player) updating record: " . mysqli_error($conn);
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
