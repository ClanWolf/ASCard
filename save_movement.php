<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$index = isset($_GET["index"]) ? $_GET["index"] : "";
	$mvmt  = isset($_GET["mvmt"]) ? $_GET["mvmt"] : "";
	$wpns  = isset($_GET["wpns"]) ? $_GET["wpns"] : "";

	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo $index;
		echo $mvmt;
		echo $wpns;
		echo "<br>";

		$sql = "UPDATE asc_assign SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;
		echo "UPDATE asc_assign<br>SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_assign) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
		}

		// Check if all units have moved in this round

		// select asc_assign.unitid, asc_assign.gameid, asc_assign.round_moved, asc_assign.round_fired, asc_mech.active_bid 
		// from asc_assign, asc_mech, asc_unit, asc_player 
		// where asc_assign.gameid = 1 
		// and asc_mech.active_bid = 1 
		// and asc_assign.unitid is not null 
		// and asc_assign.mechid = asc_mech.mechid 
		// and asc_assign.unitid = asc_unit.unitid
		// and asc_unit.playerid = asc_player.playerid
		// and asc_player.bid_winner = 1

		$sql_checkround = "";
		$sql_checkround = $sql_checkround + " select asc_assign.unitid, asc_assign.gameid, asc_assign.round_moved, asc_assign.round_fired, asc_mech.active_bid ";
		$sql_checkround = $sql_checkround + " from asc_assign, asc_mech, asc_unit, asc_player ";
		$sql_checkround = $sql_checkround + " where asc_assign.gameid = 1 ";
		$sql_checkround = $sql_checkround + " and asc_mech.active_bid = 1 ";
		$sql_checkround = $sql_checkround + " and asc_assign.unitid is not null ";
		$sql_checkround = $sql_checkround + " and asc_assign.mechid = asc_mech.mechid ";
		$sql_checkround = $sql_checkround + " and asc_assign.unitid = asc_unit.unitid ";
		$sql_checkround = $sql_checkround + " and asc_unit.playerid = asc_player.playerid ";
		$sql_checkround = $sql_checkround + " and asc_player.bid_winner = 1 ";
		if (!($stmt = $conn->prepare($sql_checkround))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		$mechCount = 0;
		if ($stmt->execute()) {
			$res = $stmt->get_result();
			while ($row = $res->fetch_assoc()) {
				$UNITID = $row['unitid'];
				$GAMEID = $row['gameid'];
				$ROUNDMOVED = $row['round_moved'];
				$ROUNDFIRED = $row['round_fired'];

				if ($UNITID != null && $GAMEID == 1 && ($ROUNDMOVED == 0 || $ROUNDFIRED == 0)) {
					// anything here is still in an older round than the current one
					$mechCount = $mechCount + 1;
				}
			}
			if ($mechCount == 0) {
				// there are no units left over in the last round
				// advance the round
				$sql3 = "UPDATE asc_assign SET round_moved=0,round_fired=0 WHERE gameid=1";
				echo "UPDATE asc_assign SET round_moved=0,round_fired=0 WHERE gameid=1";

				if (mysqli_query($conn, $sql3)) {
					echo "<br>";
					echo "Record (asc_assign) updated successfully";
					mysqli_commit($conn);
				} else {
					echo "<br>";
					echo "Error (asc_assign) updating record: " . mysqli_error($conn);
				}

				$sql4 = "UPDATE asc_game SET currentround = currentround + 1 WHERE gameid=1";
				echo "UPDATE asc_game SET currentround = currentround + 1 WHERE gameid=1";
				if (mysqli_query($conn, $sql4)) {
					echo "<br>";
					echo "Record (asc_game) updated successfully";
					mysqli_commit($conn);
				} else {
					echo "<br>";
					echo "Error (asc_game) updating record: " . mysqli_error($conn);
				}
			}
		}
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>";
?>
