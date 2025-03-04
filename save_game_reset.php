<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? $_GET["gid"] : "";
	$pid = isset($_GET["pid"]) ? $_GET["pid"] : "";
	$leaveCurrentGame = isset($_GET["leaveCurrentGame"]) ? $_GET["leaveCurrentGame"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "RESETING ROUND for playerid ".$pid."...<br>\n";
	echo "<br>\n";

	if (!empty($pid)) {
		echo "<p>\n";
    	if ($leaveCurrentGame) {
			echo "Leave current game!\n";
		} else {
			echo "Stay in game!\n";
		}
		echo "</p>\n";

		echo "Reseting playerid ".$pid.".\n";

		$sqlDeleteUnitstatusEntries = "";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "DELETE from asc_unitstatus ";
		$sqlDeleteUnitstatusEntries = $sqlDeleteUnitstatusEntries . "WHERE playerid=".$pid." ";
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
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.playerid = u.playerid ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.unitid = u.unitid ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND initial_status=1;";

		$result_selectUnitWithStatus = mysqli_query($conn, $sqlSelectUnitWithStatus);
		if (mysqli_num_rows($result_selectUnitWithStatus) > 0) {
			while($row = mysqli_fetch_assoc($result_selectUnitWithStatus)) {
				$unittype = $row["as_tp"];
				$unitstatusid = $row["mechstatusid"];

				$sqlUpdateInitialUnitstatusEntry = "";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "UPDATE asc_unitstatus ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "SET ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "round = 1, ";
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
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "WHERE mechstatusid = ".$unitstatusid;

				echo $sqlUpdateInitialUnitstatusEntry;

				if (mysqli_query($conn, $sqlUpdateInitialUnitstatusEntry)) {
					echo "<br>";
					echo "Records (asc_unitstatus) updated successfully<br>";
				} else {
					echo "<br>";
					echo "Error (asc_unitstatus) updating records: " . mysqli_error($conn) . "<br>";
					echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
					die('ERROR 17');
				}
			}
		}

		// Update player
		$sqlUpdatePlayerRound = "";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "UPDATE asc_player ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "SET ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "round=1 ";
		$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "where playerid=".$pid.";";

		echo $sqlUpdatePlayerRound;

		if (mysqli_query($conn, $sqlUpdatePlayerRound)) {
			echo "<br>";
			echo "Record (asc_player) updated successfully<br>";
		} else {
			echo "<br>";
			echo "Error (asc_player) updating record: " . mysqli_error($conn) . "<br>";
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
			die('ERROR 6');
		} else {
			echo "<br>";
			echo "Error (assignment) updating record: " . mysqli_error($conn) . "<br>";
			echo "<script>top.window.location = './gui_message_round_reset_error_01.php'</script>";
			die('ERROR 7');
		}
	} else {
		echo "Not reseting, no playerid given.";
	}

	echo "</p>\n";

	echo "</body>\n";
	echo "</html>\n";
?>
