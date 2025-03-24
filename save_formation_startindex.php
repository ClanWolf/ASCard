<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$formationid  = isset($_GET["formationid"]) ? $_GET["formationid"] : "";
	$currentindex = isset($_GET["currentindex"]) ? $_GET["currentindex"] : "";
	$op           = isset($_GET["op"]) ? $_GET["op"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";

	echo "FormationId:  " . $formationid . "<br>";
	echo "CurrentIndex: " . $currentindex . "<br>";
	echo "Operation:    " . $op . "<br>";

	echo "Saving Formation start index...";

	if (!empty($formationid)) {
		$newindex = $currentindex;
		if ($op == "up") {
			$newindex++;
		} else if ($op == "down") {
			$newindex--;
		}
		$sql = "UPDATE asc_formation SET startindex='".$newindex."' WHERE formationid=".$formationid.";";
		echo $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
			echo "Record (formation start index) updated successfully.";
			echo "</p>";
			mysqli_commit($conn);
			echo "<script>top.location.reload();</script>";
		} else {
			echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";
			echo "Error (formation start index) updating record: " . mysqli_error($conn);
			echo "</p>";
		}

	}
	echo "</body>\n";
	echo "</html>\n";
?>
