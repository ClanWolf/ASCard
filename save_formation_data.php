<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$formationid  = isset($_GET["formationid"]) ? $_GET["formationid"] : "";
	$newformationname = isset($_GET["newformationname"]) ? $_GET["newformationname"] : "";
	$newformationtype = isset($_GET["newformationtype"]) ? $_GET["newformationtype"] : "";
	$newformation = isset($_GET["newformation"]) ? $_GET["newformation"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "FormationId:        " . $formationid . "<br>";
	echo "New formation name: " . $newformationname . "<br>";
	echo "New formation type: " . $newformationtype . "<br>";
	echo "New formation:      " . $newformation . "<br>";

	echo "Saving Formation info...";

//	if (!empty($formationid)) {
//		$newindex = $currentindex;
//		if ($op == "up") {
//			$newindex++;
//		} else if ($op == "down") {
//			$newindex--;
//		}
//		$sql = "UPDATE asc_formation SET startindex='".$newindex."' WHERE formationid=".$formationid.";";
//		echo $sql;
//
//		if (mysqli_query($conn, $sql)) {
//			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
//			echo "Record (formation start index) updated successfully.";
//			echo "</p>";
//			mysqli_commit($conn);
//
//			echo "<script>\n";
//			echo "	let currentURL = top.location.href;\n";
//			echo "	let newURL = currentURL.replace('stv=1','stv=0');\n";
//			echo "	top.location.replace(newURL);\n";
//			echo "</script>\n";
//		} else {
//			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
//			echo "Error (formation start index) updating record: " . mysqli_error($conn);
//			echo "</p>";
//		}
//	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
