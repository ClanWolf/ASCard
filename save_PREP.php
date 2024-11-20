<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$index  = isset($_GET["index"]) ? $_GET["index"] : "";
	$desc   = isset($_GET["desc"]) ? $_GET["desc"] : "";
	$value  = isset($_GET["value"]) ? $_GET["value"] : "";

	echo "<!DOCTYPE html>\r\n";
	echo "<html lang='en'>\r\n";
	echo "<body>\r\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\r\n";

	if (!empty($index)) {
		echo "SAVING DATA...<br>\r\n";

		echo "index: " . $index . "<br>\r\n";
		echo "desc:  " . $desc  . "<br>\r\n";
		echo "value: " . $value . "<br>\r\n";
		echo "<br>\r\n";

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
		if ($desc == "CV_ENGN_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_engine_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "CV_FCTL_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_firecontrol_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "CV_WPNS_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_weapons_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "CV_MOTVA_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_motiveA_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "CV_MOTVB_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_motiveB_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "CV_MOTVC_PREP") {
			$sql = "UPDATE asc_mechstatus SET crit_CV_motiveC_PREP=".$value." WHERE mechid=".$index;
		}
		if ($desc == "HT_PREP") {
			$sql = "UPDATE asc_mechstatus SET heat_PREP=".$value." WHERE mechid=".$index;
		}
		echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>\r\n";
			echo "Record (asc_assign) updated successfully\r\n";
			mysqli_commit($conn);
		} else {
			echo "<br>\r\n";
			echo "Error (asc_assign) updating record: ".mysqli_error($conn)."\r\n";
		}
	}
	echo "</p>\r\n";
	echo "</body>\r\n";
	echo "</html>\r\n";
?>
