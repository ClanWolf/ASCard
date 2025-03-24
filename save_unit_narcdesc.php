<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$narcDesc = isset($_GET["narcdesc"]) ? $_GET["narcdesc"] : "";
	$playerId = isset($_GET["playerid"]) ? $_GET["playerid"] : "";
	$gameId   = isset($_GET["gameid"]) ? $_GET["gameid"] : "";
	$unitId   = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
	$roundNo  = isset($_GET["round"]) ? $_GET["round"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";

	echo "Saving Description...";

	if (!empty($gameId) && !empty($unitId) && !empty($roundNo)) {
		$sql = "UPDATE asc_unitstatus SET narc_desc='".$narcDesc."' WHERE playerid=".$playerId." AND gameid=".$gameId." AND unitid=".$unitId." AND round=".$roundNo;
		echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
			echo "Record (asc_unitstatus) updated successfully.";
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
