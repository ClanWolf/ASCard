<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$pid = isset($_GET["pid"]) ? $_GET["pid"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	echo "FINALIZING ROUND for playerid ".$pid."...<br>";
	echo "<br>";

	if (!empty($pid)) {
		// asc_player       --> round = round + 1
		// asc_unit         --> unitids for playerid
		// asc_assign       --> mechid, roundmoved and roundfired for unitids
		// asc_mechstatus   --> prepvalues for the criticals mit mechids

		// - select player, update round = round + 1
		// - select all unitids for the playerid
		// - select all mechids (+ moved and fired) from assign with the unitids
		// - select all prepvalues != 0 from mechstatus with mechids

		$unitIds = "";
		$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid = ".$pid.";";
		$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
		if (mysqli_num_rows($result_asc_unit) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_unit)) {
				$unitid = $row["unitid"];
				$unitIds = $unitIds . "," . $unitid;
			}
		}

		$sql_asc_assign = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid in (".$unitIds.");";
		$result_asc_assign = mysqli_query($conn, $sql_asc_assign);
		if (mysqli_num_rows($result_asc_assign) > 0) {
            while($row = mysqli_fetch_assoc($result_asc_assign)) {
				$mechid = $row["mechid"];
				$round_moved = $row["round_moved"];
				$round_fired = $row["round_fired"];

				// Mechstatus
				$sql_asc_mechstatus = "SELECT SQL_NO_CACHE * FROM asc_mechstatus where mechid=".$mechid.";";
				$result_asc_mechstatus = mysqli_query($conn, $sql_asc_mechstatus);
				if (mysqli_num_rows($result_asc_mechstatus) > 0) {
                    while($row = mysqli_fetch_assoc($result_asc_mechstatus)) {
						$heat = $row["heat"];
						$ENGN_PREP = $row["crit_engine_PREP"];
						$FRCTRL_PREP = $row["crit_fc_PREP"];
						$MP_PREP = $row["crit_mp_PREP"];
                        $WPNS_PREP = $row["crit_weapons_PREP"];
						$ENGN = $row["crit_engine"];
						$FRCTRL = $row["crit_fc"];
						$MP = $row["crit_mp"];
						$WPNS = $row["crit_weapons"];
						$usedOverHeat = $row["usedoverheat"];

						$finalHeat = $heat + $usedOverHeat;
						$final_ENGN = $ENGN + $ENGN_PREP;
						$final_FRCTRL = $FRCTRL + $FRCTRL_PREP;
						$final_MP = $MP + $MP_PREP;
						$final_WPNS = $WPNS + $WPNS_PREP;

						if ($finalHeat > 4) { $finalHeat = 4; }
						if ($final_ENGN > 2) { $final_ENGN = 2; }
						if ($final_FRCTRL > 4) { $final_FRCTRL = 4; }
						if ($final_MP > 4) { $final_MP = 4; }
						if ($final_WPNS > 4) { $final_WPNS = 4; }

						//update mechstatus
					}
				}
			}
		}

//		$sql = "UPDATE asc_assign SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;
//		echo "UPDATE asc_assign<br>SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;
//
//		if (mysqli_query($conn, $sql)) {
//			echo "<br>";
//			echo "Record (asc_assign) updated successfully";
//			mysqli_commit($conn);
//		} else {
//			echo "<br>";
//			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
//		}
//
//		// Check if all units have moved in this round
//
//		// select asc_assign.unitid, asc_assign.gameid, asc_assign.round_moved, asc_assign.round_fired, asc_mech.active_bid
//		// from asc_assign, asc_mech, asc_unit, asc_player
//		// where asc_assign.gameid = 1
//		// and asc_mech.active_bid = 1
//		// and asc_assign.unitid is not null
//		// and asc_assign.mechid = asc_mech.mechid
//		// and asc_assign.unitid = asc_unit.unitid
//		// and asc_unit.playerid = asc_player.playerid
//		// and asc_player.bid_winner = 1
//
//		$sql_checkround = "";
//		$sql_checkround = $sql_checkround + " select asc_assign.unitid, asc_assign.gameid, asc_assign.round_moved, asc_assign.round_fired, asc_mech.active_bid ";
//		$sql_checkround = $sql_checkround + " from asc_assign, asc_mech, asc_unit, asc_player ";
//		$sql_checkround = $sql_checkround + " where asc_assign.gameid = 1 ";
//		$sql_checkround = $sql_checkround + " and asc_mech.active_bid = 1 ";
//		$sql_checkround = $sql_checkround + " and asc_assign.unitid is not null ";
//		$sql_checkround = $sql_checkround + " and asc_assign.mechid = asc_mech.mechid ";
//		$sql_checkround = $sql_checkround + " and asc_assign.unitid = asc_unit.unitid ";
//		$sql_checkround = $sql_checkround + " and asc_unit.playerid = asc_player.playerid ";
//		$sql_checkround = $sql_checkround + " and asc_player.bid_winner = 1 ";
//		if (!($stmt = $conn->prepare($sql_checkround))) {
//			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
//		}
//		$mechCount = 0;
//		if ($stmt->execute()) {
//			$res = $stmt->get_result();
//			while ($row = $res->fetch_assoc()) {
//				$UNITID = $row['unitid'];
//				$GAMEID = $row['gameid'];
//				$ROUNDMOVED = $row['round_moved'];
//				$ROUNDFIRED = $row['round_fired'];
//
//				if ($UNITID != null && $GAMEID == 1 && ($ROUNDMOVED == 0 || $ROUNDFIRED == 0)) {
//					// anything here is still in an older round than the current one
//					$mechCount = $mechCount + 1;
//				}
//			}
//			if ($mechCount == 0) {
//				// there are no units left over in the last round
//				// advance the round
//				$sql3 = "UPDATE asc_assign SET round_moved=0,round_fired=0 WHERE gameid=1";
//				echo "UPDATE asc_assign SET round_moved=0,round_fired=0 WHERE gameid=1";
//
//				if (mysqli_query($conn, $sql3)) {
//					echo "<br>";
//					echo "Record (asc_assign) updated successfully";
//					mysqli_commit($conn);
//				} else {
//					echo "<br>";
//					echo "Error (asc_assign) updating record: " . mysqli_error($conn);
//				}
//
//				$sql4 = "UPDATE asc_game SET currentround = currentround + 1 WHERE gameid=1";
//				echo "UPDATE asc_game SET currentround = currentround + 1 WHERE gameid=1";
//				if (mysqli_query($conn, $sql4)) {
//					echo "<br>";
//					echo "Record (asc_game) updated successfully";
//					mysqli_commit($conn);
//				} else {
//					echo "<br>";
//					echo "Error (asc_game) updating record: " . mysqli_error($conn);
//				}
//			}
//		}
//	} else {
//		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
