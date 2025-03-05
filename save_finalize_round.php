<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

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
		// asc_formation    --> formationids for playerid
		// asc_assign       --> unitid, roundmoved and roundfired for formationids
		// asc_unitstatus   --> prepvalues for the criticals

		// - select player, update round = round + 1
		// - select all formationids for the playerid
		// - select all unitids (+ moved and fired) from assign with the formationids
		// - select all prepvalues != 0 from unitstatus with unitids

		$finishedUnitsInThisRound = 0;

		$currentRound = "";
		$sql_asc_playerRound = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = ".$pid.";";
		$result_asc_playerRound = mysqli_query($conn, $sql_asc_playerRound);
		if (mysqli_num_rows($result_asc_playerRound) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_playerRound)) {
				$gameid = $row["gameid"];
				$currentRound = $row["round"];
			}
		}
		$nextRound = $currentRound + 1;

		echo "Currentround: " . $currentRound . "<br>";
		echo "Nextround: " . $nextRound . "<br><br>";

		$formationIds = "";
		$sql_asc_formation = "SELECT SQL_NO_CACHE * FROM asc_formation where playerid = ".$pid.";";
		$result_asc_formation = mysqli_query($conn, $sql_asc_formation);
		if (mysqli_num_rows($result_asc_formation) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_formation)) {
				$formationId = $row["formationid"];
				if ($formationIds == "") {
					$formationIds = $formationIds.$formationId;
				} else {
					$formationIds = $formationIds.",".$formationId;
				}
			}
		}

		// select the number of units that are active bid and in the players formations
		$allActiveUnitsCount = 0;
		$sql_allActiveUnitsCount = "";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "SELECT SQL_NO_CACHE a.assignid, a.formationid, a.unitid, a.pilotid, a.round_moved, a.round_fired, s.active_bid, s.unit_status ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "FROM asc_assign a, asc_unit u, asc_unitstatus s ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "WHERE formationid in (".$formationIds.") ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND a.unitid = u.unitid ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND a.unitid = s.unitid ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND s.round = ".$currentRound." "; // round
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND s.gameid = ".$gameid." "; // gameid
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND s.unit_status != 'destroyed' ";
		$sql_allActiveUnitsCount = $sql_allActiveUnitsCount . "AND s.active_bid = 1 ";

		echo $sql_allActiveUnitsCount;
		$result_allActiveUnitsCount = mysqli_query($conn, $sql_allActiveUnitsCount);
		if (mysqli_num_rows($result_allActiveUnitsCount) > 0) {
			while($row_allActiveUnitsCount = mysqli_fetch_assoc($result_allActiveUnitsCount)) {
				$allActiveUnitsCount = $allActiveUnitsCount + 1;
			}
		}

		// select the number of units that are active bid and in the players formations AND have moved and fired
		$allActiveUnitsFinishedCount = 0;
		$sql_allActiveUnitsFinishedCount = "";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "SELECT SQL_NO_CACHE * ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "FROM asc_assign a, asc_unit u, asc_unitstatus s ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "WHERE formationid in (".$formationIds.") ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND a.unitid = u.unitid ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND a.unitid = s.unitid ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND s.round = ".$currentRound." "; // round
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND s.gameid = ".$gameid." "; // gameid
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND s.unit_status != 'destroyed' ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND s.active_bid = 1 ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND a.round_moved > 0 ";
		$sql_allActiveUnitsFinishedCount = $sql_allActiveUnitsFinishedCount . "AND a.round_fired > 0 ";
		echo $sql_allActiveUnitsFinishedCount;
		$result_allActiveUnitsFinishedCount = mysqli_query($conn, $sql_allActiveUnitsFinishedCount);
		if (mysqli_num_rows($result_allActiveUnitsFinishedCount) > 0) {
			while($row_allActiveUnitsFinishedCount = mysqli_fetch_assoc($result_allActiveUnitsFinishedCount)) {
				$allActiveUnitsFinishedCount = $allActiveUnitsFinishedCount + 1;
			}
		}

//		// select the units that are active bid and in the players formations AND have !!!! NOT !!!! moved and fired
//		// To list them in the error message
//		$allActiveUnitIDsNOTFinished = "";
//		$sql_allActiveUnitIDsNOTFinished = "";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "SELECT SQL_NO_CACHE * ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "FROM asc_assign a, asc_unit u, asc_pilot p, asc_unitstatus s ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "WHERE formationid in (".$formationIds.") ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND a.unitid = u.unitid ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND a.unitid = s.unitid ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND s.round = ".$currentRound." "; // round
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND s.gameid = ".$gameid." "; // gameid
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND a.pilotid = p.pilotid ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND s.unit_status != 'destroyed' ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND s.active_bid = 1 ";
//		$sql_allActiveUnitIDsNOTFinished = $sql_allActiveUnitIDsNOTFinished . "AND (a.round_moved = 0 OR a.round_fired = 0) ";
//		echo $sql_allActiveUnitIDsNOTFinished;
//		$result_allActiveUnitIDsNOTFinished = mysqli_query($conn, $sql_allActiveUnitIDsNOTFinished);
//		if (mysqli_num_rows($result_allActiveUnitIDsNOTFinished) > 0) {
//			while($row_allActiveUnitIDsNOTFinished = mysqli_fetch_assoc($result_allActiveUnitIDsNOTFinished)) {
//				$formationId = $row_allActiveUnitIDsNOTFinished["formationid"];
//				$unitId = $row_allActiveUnitIDsNOTFinished["unitid"];
//				$unitModel = $row_allActiveUnitIDsNOTFinished["as_model"];
//				$pilotName = $row_allActiveUnitIDsNOTFinished["name"];
//
//				if ($allActiveUnitIDsNOTFinished == "") {
//					$allActiveUnitIDsNOTFinished = $allActiveUnitIDsNOTFinished.$formationId."|".$unitId."|".$unitModel."|".$pilotName;
//				} else {
//					$allActiveUnitIDsNOTFinished = $allActiveUnitIDsNOTFinished.",".$formationId."|".$unitId."|".$unitModel."|".$pilotName;
//				}
//			}
//		}

		if ($allActiveUnitsCount > 0 && $allActiveUnitsCount == $allActiveUnitsFinishedCount) {
			// all Units did move and fired in this round and the round can be finalized
			$sql_asc_assign = "SELECT SQL_NO_CACHE * FROM asc_assign where formationid in (".$formationIds.");";
			echo $sql_asc_assign;
			$result_asc_assign = mysqli_query($conn, $sql_asc_assign);
			if (mysqli_num_rows($result_asc_assign) > 0) {
				while($row = mysqli_fetch_assoc($result_asc_assign)) {
					$unitId = $row["unitid"];
					$roundMoved = $row["round_moved"];
					$roundFired = $row["round_fired"];

					// Unitstatus
					$sql_asc_unitstatus = "SELECT SQL_NO_CACHE * FROM asc_unitstatus where unitid=".$unitId." and round=".$currentRound." AND gameid=".$gameid.";";
					$result_asc_unitstatus = mysqli_query($conn, $sql_asc_unitstatus);
					if (mysqli_num_rows($result_asc_unitstatus) > 0) {
						while($row = mysqli_fetch_assoc($result_asc_unitstatus)) {
							$heat = $row["heat"];
							$ENGN_PREP = $row["crit_engine_PREP"];
							$FRCTRL_PREP = $row["crit_fc_PREP"];
							$MP_PREP = $row["crit_mp_PREP"];
							$WPNS_PREP = $row["crit_weapons_PREP"];
							$HT_PREP = $row["heat_PREP"];
							$ENGN = $row["crit_engine"];
							$FRCTRL = $row["crit_fc"];
							$MP = $row["crit_mp"];
							$WPNS = $row["crit_weapons"];
							$usedOverHeat = $row["usedoverheat"];

							$armor = $row["armor"];
							$structure = $row["structure"];

							$active_bid = $row["active_bid"];
							$active_narc = $row["active_narc"];
							$active_tag = $row["active_tag"];
							$active_water = $row["active_water"];
							$active_routed = $row["active_routed"];

							$unit_status = $row["unit_status"];
							$unit_statusimageurl = $row["unit_statusimageurl"];
							$mounted_unitid = $row["mounted_unitid"];
							$mounted_on_unitid = $row["mounted_on_unitid"];

							$CV_ENGN = $row["crit_CV_engine"];
							$CV_FRCTRL = $row["crit_CV_firecontrol"];
							$CV_WPNS = $row["crit_CV_weapons"];
							$CV_MOTA = $row["crit_CV_motiveA"];
							$CV_MOTB = $row["crit_CV_motiveB"];
							$CV_MOTC = $row["crit_CV_motiveC"];
							$CV_ENGN_PREP = $row["crit_CV_engine_PREP"];
							$CV_FRCTRL_PREP = $row["crit_CV_firecontrol_PREP"];
							$CV_WPNS_PREP = $row["crit_CV_weapons_PREP"];
							$CV_MOTA_PREP = $row["crit_CV_motiveA_PREP"];
							$CV_MOTB_PREP = $row["crit_CV_motiveB_PREP"];
							$CV_MOTC_PREP = $row["crit_CV_motiveC_PREP"];

							$finalHeat = $heat + $usedOverHeat + $HT_PREP;
							$final_ENGN = $ENGN + $ENGN_PREP;
							$final_FRCTRL = $FRCTRL + $FRCTRL_PREP;
							$final_MP = $MP + $MP_PREP;
							$final_WPNS = $WPNS + $WPNS_PREP;

							$final_CV_ENGN = $CV_ENGN + $CV_ENGN_PREP;
							$final_CV_FRCTRL = $CV_FRCTRL + $CV_FRCTRL_PREP;
							$final_CV_WPNS = $CV_WPNS + $CV_WPNS_PREP;
							$final_CV_MOTA = $CV_MOTA + $CV_MOTA_PREP;
							$final_CV_MOTB = $CV_MOTB + $CV_MOTB_PREP;
							$final_CV_MOTC = $CV_MOTC + $CV_MOTC_PREP;

							if ($final_CV_ENGN > 2) { $final_CV_ENGN = 2; }
							if ($final_CV_FRCTRL > 4) { $final_CV_FRCTRL = 4; }
							if ($final_CV_WPNS > 4) { $final_CV_WPNS = 4; }
							if ($final_CV_MOTA > 2) { $final_CV_MOTA = 2; }
							if ($final_CV_MOTB > 2) { $final_CV_MOTB = 2; }
							if ($final_CV_MOTC > 1) { $final_CV_MOTC = 1; }

							if ($finalHeat > 4) { $finalHeat = 4; }
							if ($final_ENGN > 2) { $final_ENGN = 2; }
							if ($final_FRCTRL > 4) { $final_FRCTRL = 4; }
							if ($final_MP > 4) { $final_MP = 4; }
							if ($final_WPNS > 4) { $final_WPNS = 4; }

							// Check for number for "DO NOT FIRE", if the unit held fire, reduce effective overheat to 0
							//console.log("Fire 1: hold fire");
							//console.log("Fire 2: fired");
							if ($roundFired == 1) { // 1 = hold fire!
								// if ($final_ENGN == 1) {
								// 	$finalHeat = 1;
								// } else
								if ($final_ENGN == 2) {
									$finalHeat = 4;
								} else {
									$finalHeat = 0;
								}
							} else {
								// if ($final_ENGN == 1) {
								// 	if ($finalHeat < 1) {
								// 		$finalHeat = 1;
								// 	}
								// } else
								if ($final_ENGN == 2) {
									$finalHeat = 4;
								}
							}

							$sqlInsertNewUnitStatus = "";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "INSERT INTO asc_unitstatus (unitid,playerid,gameid,round,heat,armor,`structure`,crit_engine,crit_fc,crit_mp,crit_weapons,usedoverheat,";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   crit_engine_PREP,crit_fc_PREP,crit_mp_PREP,crit_weapons_PREP,heat_PREP,     crit_CV_engine,crit_CV_firecontrol,crit_CV_weapons,crit_CV_motiveA,crit_CV_motiveB,crit_CV_motiveC,";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   crit_CV_engine_PREP,crit_CV_firecontrol_PREP,crit_CV_weapons_PREP,crit_CV_motiveA_PREP,crit_CV_motiveB_PREP,crit_CV_motiveC_PREP, ";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   active_bid,active_narc,active_tag,active_water,active_routed,unit_status,unit_statusimageurl,mounted_unitid,mounted_on_unitid) ";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "VALUES ";
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "(".$unitId.",".$pid.",".$gameid.",".$nextRound.",".$finalHeat.",".$armor.",".$structure.",".$final_ENGN.",".$final_FRCTRL.",".$final_MP.",".$final_WPNS.",0,"; // until currentTMM
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   0,0,0,0,0,  ".$final_CV_ENGN.",".$final_CV_FRCTRL.",".$final_CV_WPNS.",".$final_CV_MOTA.",".$final_CV_MOTB.",".$final_CV_MOTC.","; // crit PREP (0-5) -> stay 0!, CV Crit (last Block) -> fill with CV values
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   0,0,0,0,0,0,";  // CV PREP -> stay 0!
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "   ".$active_bid.",".$active_narc.",".$active_tag.",".$active_water.",".$active_routed.",'".$unit_status."','".$unit_statusimageurl."',".$mounted_unitid.",".$mounted_on_unitid;
							$sqlInsertNewUnitStatus = $sqlInsertNewUnitStatus . "); ";
							echo $sqlInsertNewUnitStatus."<br><br>";

							if (mysqli_query($conn, $sqlInsertNewUnitStatus)) {
								echo "<br>";
								echo "Record unitstatus inserted successfully<br>";
								//mysqli_commit($conn);
							} else {
								echo "<br>";
								echo "Error unitstatus insert record: " . mysqli_error($conn) . "<br>";
								echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
								die('ERROR 1');
							}

							$sqlInsertNewUnitStatusArchive = str_replace('asc_unitstatus', 'asc_unitstatus_archive', $sqlInsertNewUnitStatus);

							if (mysqli_query($conn, $sqlInsertNewUnitStatusArchive)) {
								echo "<br>";
								echo "Record unitstatus archive inserted successfully<br>";
								//mysqli_commit($conn);
							} else {
								echo "<br>";
								echo "Error unitstatus archive insert record: " . mysqli_error($conn) . "<br>";
								echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
								die('ERROR 1');
							}
						}
					}

					// Update fired and moved for unitid in asc_assign
					$sqlUpdateUnitMovementFiresStatus = "";
					$sqlUpdateUnitMovementFiresStatus = $sqlUpdateUnitMovementFiresStatus . "UPDATE asc_assign ";
					$sqlUpdateUnitMovementFiresStatus = $sqlUpdateUnitMovementFiresStatus . "SET ";
					$sqlUpdateUnitMovementFiresStatus = $sqlUpdateUnitMovementFiresStatus . "round_moved=0, round_fired=0 ";
					$sqlUpdateUnitMovementFiresStatus = $sqlUpdateUnitMovementFiresStatus . "where unitid=".$unitId.";";

					echo $sqlUpdateUnitMovementFiresStatus;

					if (mysqli_query($conn, $sqlUpdateUnitMovementFiresStatus)) {
						echo "<br>";
						echo "Record (asc_assign) updated successfully<br>";
						//mysqli_commit($conn);
					} else {
						echo "<br>";
						echo "Error (asc_assign) updating record: " . mysqli_error($conn) . "<br>";

						echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
						die('ERROR 2');
					}
				}
			}

			$sqlUpdatePlayerRound = "";
			$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "UPDATE asc_player ";
			$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "SET ";
			$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "round=".$nextRound." ";
			$sqlUpdatePlayerRound = $sqlUpdatePlayerRound . "where playerid=".$pid.";";

			echo $sqlUpdatePlayerRound;

			if (mysqli_query($conn, $sqlUpdatePlayerRound)) {
				echo "<br>";
				echo "Record (asc_player) updated successfully<br>";
				mysqli_commit($conn);

				echo "<script>top.window.location = './gui_message_round_finalized.php'</script>";
				die('ERROR 3');
			} else {
				echo "<br>";
				echo "Error (asc_player) updating record: " . mysqli_error($conn) . "<br>";

				echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
				die('ERROR 4');
			}
		} else {
			// echo "<script>top.window.location = './gui_message_round_finalized_error_02.php?units=".$allActiveUnitIDsNOTFinished."'</script>";
			echo "<script>top.window.location = './gui_message_round_finalized_error_02.php'</script>";
			die('ERROR 5');
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
