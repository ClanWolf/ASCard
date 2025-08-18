<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$commandid = isset($_GET["commandid"]) ? filter_var($_GET['commandid'], FILTER_VALIDATE_INT) : "";
	$newcommandname = isset($_GET["newcommandname"]) ? $_GET["newcommandname"] : "";
	$newcommandtype = isset($_GET["newcommandtype"]) ? $_GET["newcommandtype"] : "";
	$newcommandfaction = isset($_GET["newcommandfaction"]) ? $_GET["newcommandfaction"] : "";
	$newcommandbackground = isset($_GET["newcommandbackground"]) ? $_GET["newcommandbackground"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "CommandId:          ".$commandid."<br>";
	echo "New command name:   ".$newcommandname."<br>";
	echo "New command type:   ".$newcommandtype."<br>";
	echo "New faction:        ".$newcommandfaction."<br>";
	echo "Command background: ".$newcommandbackground."<br>";

	echo "Saving Command info...";

	if (!empty($newcommandname)) {
		$sql = "UPDATE asc_command SET commandname='".$newcommandname."',type='".$newcommandtype."',factionid=".$newcommandfaction.",commandbackground='".$newcommandbackground."' WHERE commandid=".$commandid.";";
		echo "<br><br>".$sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br><br>Command updated successfully.";
			mysqli_commit($conn);

			echo "<script>top.window.location = './gui_select_unit.php'</script>";
			die('ERROR 3');
		} else {
			echo "<br><br>ERROR while updating command: " . mysqli_error($conn);
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
