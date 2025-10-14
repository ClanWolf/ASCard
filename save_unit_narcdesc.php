<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

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
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	// -----------------------------------------------------------------------------------------------------------------
	// https://www.php.net/manual/en/mysqli.begin-transaction.php

	if (!empty($gameId) && !empty($unitId) && !empty($roundNo)) {
		echo "SAVING DATA...<br><br>";

		$sql = "UPDATE asc_unitstatus SET narc_desc='".$narcDesc."' WHERE playerid=".$playerId." AND gameid=".$gameId." AND unitid=".$unitId." AND round=".$roundNo;
		echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "Record (asc_unitstatus) updated successfully.";
			echo "</p>";
			mysqli_commit($conn);
			//echo "<script>top.location.reload();</script>";
		} else {
			echo "Error (asc_options) updating record: " . mysqli_error($conn);
			echo "</p>";
		}
	} else {
		echo "Missing data! Nothing was stored!<br>";
	}
	echo "</body>\n";
	echo "</html>\n";
?>
