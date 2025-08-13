<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$formationid = isset($_GET["formationid"]) ? filter_var($_GET['formationid'], FILTER_VALIDATE_INT) : "";
	$newformationname = isset($_GET["newformationname"]) ? $_GET["newformationname"] : "";
	$newformationtype = isset($_GET["newformationtype"]) ? $_GET["newformationtype"] : "";
	$newformation = isset($_GET["newformation"]) ? $_GET["newformation"] : "";
	$formationshort = isset($_GET["formationshort"]) ? $_GET["formationshort"] : "";
	$autobuild = isset($_GET["autobuild"]) ? $_GET["autobuild"] : "";
	$factionid = isset($_GET["factionid"]) ? $_GET["factionid"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "FormationId:        ".$formationid."<br>";
	echo "New formation name: ".$newformationname."<br>";
	echo "New formation type: ".$newformationtype."<br>";
	echo "New formation:      ".$newformation."<br>";
	echo "FormationShort:     ".$formationshort."<br>";
	echo "Autobuild name:     ".$autobuild."<br>";
	echo "FactionId:          ".$factionid."<br>";

	echo "Saving Formation info...";

	if ($autobuild === "true") {
		$formationlong = $newformationname." ".$newformationtype." ".$newformation;
	} else {
		$formationlong = $newformationname;
	}
	if (!empty($newformationname)) {
		$sql = "UPDATE asc_formation SET formationname='".$newformationname."',formationtype='".$newformationtype."',formation='".$newformation."',formationshort='".$formationshort."',formationlong='".$formationlong."',autobuildname=".$autobuild.",factionid=".$factionid." WHERE formationid=".$formationid.";";
		echo "<br><br>".$sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br><br>Formation updated successfully.";
			mysqli_commit($conn);
		} else {
			echo "<br><br>ERROR while updating formation: " . mysqli_error($conn);
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
