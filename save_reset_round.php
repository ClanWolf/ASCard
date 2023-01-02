<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$pid = isset($_GET["pid"]) ? $_GET["pid"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	echo "RESETING ROUND for playerid ".$pid."...<br>";
	echo "<br>";

	if (!empty($pid)) {
		$sqlUpdatePlayerRound = "";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "UPDATE asc_player ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "SET ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "round=1 ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "where playerid=".$pid.";";

		echo $sqlUpdatePlayerRound;

		if (mysqli_query($conn, $sqlUpdatePlayerRound)) {
			echo "<br>";
			echo "Record (asc_player) updated successfully<br>";
			mysqli_commit($conn);

			echo "<script>top.window.location = './gui_message_round_reset.php'</script>";
			die('ERROR 6');
		} else {
			echo "<br>";
			echo "Error (asc_player) updating record: " . mysqli_error($conn) . "<br>";

			echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
			die('ERROR 7');
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
