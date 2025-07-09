<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? filter_var($_GET["gid"], FILTER_VALIDATE_INT) : "";
	$pid = isset($_GET["pid"]) ? filter_var($_GET["pid"], FILTER_VALIDATE_INT) : "";
	$leaveGame = isset($_GET["leaveCurrentGame"]) ? filter_var($_GET["leaveCurrentGame"], FILTER_VALIDATE_BOOLEAN) : "";
	$joinGame = isset($_GET["joinGame"]) ? filter_var($_GET["joinGame"], FILTER_VALIDATE_BOOLEAN) : "";
	$accessCode = isset($_GET["accessCode"]) ? filter_var($_GET["accessCode"], FILTER_VALIDATE_INT) : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "GameId:     ".$gid."<br>\n";
	echo "PlayerId:   ".$pid."<br>\n";
	echo "LeaveGame:  ".$leaveGame."<br>\n";
	echo "JoinGame:   ".$joinGame." (boolean)<br>\n";
	echo "AccessCode: ".$accessCode."<br>\n";
	echo "---------------------------------------------<br>\n";

	if ($joinGame && $leaveGame) {
		echo "Raise error! Cannot join and leave at the same time!<br>\n";
		die('ERROR 32');
	}

	if ($joinGame && !$accessCode) {
		echo "Raise error! Cannot join without access code!<br>\n";
		die('ERROR 34');
	}

	$joinAsOpfor = -1;
	$newgameid = 0;

	if ($joinGame) {
		// join a new game
		echo "Player ".$pid." to JOIN game ".$gid.".<br>\n";
		// Check access code. If wrong, do nothing, go to error page
		// Select accessCode from the target game
		$sql_asc_accesscode = "SELECT SQL_NO_CACHE accessCode FROM asc_game where gameid=".$gid.";";
		$result_asc_accesscode = mysqli_query($conn, $sql_asc_accesscode);
		if (mysqli_num_rows($result_asc_accesscode) > 0) {
			while($row333 = mysqli_fetch_assoc($result_asc_accesscode)) {
				$foundAccessCode = $row333["accessCode"];
			}
		}
		mysqli_free_result($result_asc_accesscode);

		if ($foundAccessCode == $accessCode) {
			$newgameid == $gid;
			$joinAsOpfor = 1;
		} else {
			echo "<br>";
			echo "Accesscode does not match<br>";
			echo "Raise error! Cannot join without access code!<br>\n";
			echo "<script>top.window.location = './gui_message_joingame_error_01.php'</script>\n";
			die('ERROR 38');
		}
	} else {
		if ($leaveGame) {
			// leave the current game, revert back to the players own game
			// ATTENTION: select owned game for this userId! It is not always the logged in user (e.g. "-" Button when removing user!)
			// Get the gameId of the player, set him back to his own gameId
			if ($leaveCurrentGame) {
				echo "Player ".$pid." LEAVES game ".$gid.", revert to his own game ".$newgameid.".<br>\n";
				$ownedGame = 0;
				$sql_ownedGame = "SELECT SQL_NO_CACHE gameId FROM asc_game where ownerPlayerId".$pid.";";
				$result_ownedGame = mysqli_query($conn, $sql_ownedGame);
				if (mysqli_num_rows($result_ownedGame) > 0) {
					while($row667 = mysqli_fetch_assoc($result_ownedGame)) {
						$ownedGame = $row667["gameId"];
					}
				}
				mysqli_free_result($result_ownedGame);
			}
			$joinAsOpfor = 0;
			$newgameid = $ownedGame; // the game to revert all units to and reset the given player to
		} else {
			// stay in current game, just reset to round 1
			echo "Player ".$pid." stays in the same game ".$gid.", just reset round and units.<br>\n";
			$newgameid = $gid; // gameId stays the same in this case
		}
	}
	echo "<br>\n";
	echo "---------------------------------------------<br>\n";
	echo "newgameid to be stored: ".$newgameid." for player ".$pid."<br>\n";
	echo "joining as opfor      : ".$joinAsOpfor."<br>\n";
	echo "---------------------------------------------<br>\n";

	// ---------------------------------------------------------------------------------------------------------

	exit(0); // doing nothing here, just testing

	if (!empty($pid) || !empty($newgameid)) {
		echo "Reseting playerid ".$pid.".\n";

		$sqlDeleteUnitstatusEntries = "";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "DELETE from asc_unitstatus ";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "WHERE playerid=".$pid." ";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "AND gameid=".$newgameid." ";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "AND initial_status=0; ";

		echo $sqlDeleteUnitstatusEntries;

		if (mysqli_query($conn, $sqlDeleteUnitstatusEntries)) {
			echo "<br>\n";
			echo "Records (asc_unitstatus) deleted successfully<br>\n";
		} else {
			echo "<br>\n";
			echo "Error (asc_unitstatus) deleting records: " . mysqli_error($conn) . "<br>\n";
			echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>\n";
			die('ERROR 17');
		}

		$sqlSelectUnitWithStatus = "";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "SELECT * from asc_unitstatus us, asc_unit u ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "WHERE u.playerid=".$pid." ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.playerid=u.playerid ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.unitid=u.unitid ";
		//$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.gameid=".$newgameid." "; // delete all unitstatus entries, there is only one game per user
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND initial_status=1;";

		$result_selectUnitWithStatus = mysqli_query($conn, $sqlSelectUnitWithStatus);
		if (mysqli_num_rows($result_selectUnitWithStatus) > 0) {
			while($row = mysqli_fetch_assoc($result_selectUnitWithStatus)) {
				$unittype = $row["as_tp"];
				$unitstatusid = $row["unitstatusid"];

				$sqlUpdateInitialUnitstatusEntry = "";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "UPDATE asc_unitstatus ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "SET ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "round = 1, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "gameid = ".$newgameid.", ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "heat = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "armor = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "`structure` = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_engine = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_fc = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_mp = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_weapons = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "usedoverheat = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_engine_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_fc_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_mp_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_weapons_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "heat_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_engine = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_firecontrol = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_weapons = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveA = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveB = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveC = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_engine_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_firecontrol_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_weapons_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveA_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveB_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_CV_motiveC_PREP = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "active_bid = 1, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "active_narc = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "unit_status = 'fresh', ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "mounted_unitid = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "mounted_on_unitid = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "unit_statusimageurl = 'images/DD_".$unittype."_01.png' ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "WHERE unitstatusid = ".$unitstatusid;

				echo $sqlUpdateInitialUnitstatusEntry;

				if (mysqli_query($conn, $sqlUpdateInitialUnitstatusEntry)) {
					echo "<br>";
					echo "Records (asc_unitstatus) updated successfully<br>";
				} else {
					echo "<br>";
					echo "Error (asc_unitstatus) updating records: ".mysqli_error($conn)."<br>";
					echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
					die('ERROR 17');
				}
			}
		}

		// Update player
		$sqlUpdatePlayerRound = "";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "UPDATE asc_player ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "SET ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "round=1, ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "active_ingame=1, ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "teamid=1, ";
		if ($joinAsOpfor != -1) {
			$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "opfor=".$joinAsOpfor.", ";
		}
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "gamedId=".$newgameid." ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "WHERE playerid=".$pid.";";

		echo $sqlUpdatePlayerRound;

		if (mysqli_query($conn, $sqlUpdatePlayerRound)) {
			echo "<br>";
			echo "Record (asc_player) updated successfully<br>";
		} else {
			echo "<br>";
			echo "Error (asc_player) updating record: ".mysqli_error($conn)."<br>";
			echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
			die('ERROR 7');
		}

		// Update Assignment
		$sqlUpdateAssignment = "";
		$sqlUpdateAssignment = $sqlUpdateAssignment . "UPDATE asc_assign ";
		$sqlUpdateAssignment = $sqlUpdateAssignment . "SET ";
		$sqlUpdateAssignment = $sqlUpdateAssignment . "round_moved=0, ";
		$sqlUpdateAssignment = $sqlUpdateAssignment . "round_fired=0 ";
		$sqlUpdateAssignment = $sqlUpdateAssignment . "where playerid=".$pid.";";

		echo $sqlUpdateAssignment;

		if (mysqli_query($conn, $sqlUpdateAssignment)) {
			echo "<br>";
			echo "Record (assignment) updated successfully<br>";
			mysqli_commit($conn);

			echo "<script>top.window.location = './gui_message_round_reset.php'</script>";
		} else {
			echo "<br>";
			echo "Error (assignment) updating record: ".mysqli_error($conn)."<br>";
			echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
			die('ERROR 7');
		}
	} else {
		echo "NOT reseting, no playerid and/or gameid";
	}

	echo "</p>\n";

	echo "</body>\n";
	echo "</html>\n";
?>
