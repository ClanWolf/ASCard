<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$index  = isset($_GET["index"]) ? $_GET["index"] : "";
	$desc   = isset($_GET["desc"]) ? $_GET["desc"] : "";
	$value  = isset($_GET["value"]) ? $_GET["value"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo "index: " . $index . "<br>";
		echo "desc:  " . $desc  . "<br>";
		echo "value: " . $value . "<br>";
		echo "<br>";

		if ($desc == "ENGN_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_engine_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "FCTL_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_fc_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "MP_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_mp_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "WPNS_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_weapons_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "HT_PREP") {
			$sql = "UPDATE asc_mechstatus SET heat_PREP=".$value." WHERE mechid=".$index;
		}
		echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_assign) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
		}
	}
	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
