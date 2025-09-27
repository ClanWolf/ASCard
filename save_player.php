<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$pid = $_SESSION['playerid'];

	$pidtosave  = isset($_GET["pidts"]) ? $_GET["pidts"] : "";
	$playerName = isset($_GET["pn"]) ? $_GET["pn"] : "";
	$pemail     = isset($_GET["em"]) ? $_GET["em"] : "";
	$newPw      = isset($_GET["np"]) ? $_GET["np"] : "";
	$newImage   = isset($_GET["ni"]) ? $_GET["ni"] : "";
	$newFaction = isset($_GET["nf"]) ? $_GET["nf"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($pidtosave)) {
		echo "SAVING DATA...<br>";

		echo $pidtosave."<br>";
		echo $playerName."<br>";
		echo $pemail."<br>";
		echo $newPw."<br>";
		echo $newImage."<br>";
		echo $newFaction."<br>";

//			playerid
//			npc
//			confirmed
//			login_enabled
//			name
//			email
//			password
//			password_god
//			password_phoenix
//			admin
//			godadmin
//			image
//			factionid
//			hostedgameid
//			gameid
//			teamid
//			commandid
//			opfor
//			bid_pv
//			bid_tonnage
//			bid_winner
//			round
//			active_ingame
//			last_unit_opened
//			last_login
//			Updated

		if ($newPw !== "") {
			$sql = "UPDATE asc_player SET name='".$playerName."',email='".$pemail."',password_phoenix='".$newPw."',image='".$newImage."',factionid=".$newFaction." WHERE playerid=".$pidtosave;
		} else {
			$sql = "UPDATE asc_player SET name='".$playerName."',email='".$pemail."',image='".$newImage."',factionid=".$newFaction." WHERE playerid=".$pidtosave;
		}

		echo "Statement: " . $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_player) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_player) updating record: " . mysqli_error($conn);
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
