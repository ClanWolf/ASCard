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
		// asc_formation    --> formationids (formerly unitids) for playerid
		// asc_assign       --> mechid, roundmoved and roundfired for formationids (former unitids)
		// asc_mechstatus   --> prepvalues for the criticals mit mechids

		// - select player, update round = round + 1
		// - select all formationids (former unitids) for the playerid
		// - select all mechids (+ moved and fired) from assign with the formationids (former unitids)
		// - select all prepvalues != 0 from mechstatus with mechids

		$finishedMechsInThisRound = 0;

		$currentRound = "";
		$sql_asc_playerRound = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = ".$pid.";";
		$result_asc_playerRound = mysqli_query($conn, $sql_asc_playerRound);
		if (mysqli_num_rows($result_asc_playerRound) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_playerRound)) {
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

		// select the number of mechs that are active bid and in the players units
		$allActiveMechsCount = 0;
		$sql_allActiveMechsCount = "";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "SELECT SQL_NO_CACHE a.assignid, a.unitid, a.mechid, a.pilotid, a.round_moved, a.round_fired, m.active_bid, m.mech_status ";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "FROM asc_assign a, asc_mech m ";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "WHERE unitid in (".$formationIds.") ";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "AND a.mechid = m.mechid ";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "AND m.mech_status != 'destroyed' ";
		$sql_allActiveMechsCount = $sql_allActiveMechsCount . "AND m.active_bid = 1 ";

		echo $sql_allActiveMechsCount;
		$result_allActiveMechsCount = mysqli_query($conn, $sql_allActiveMechsCount);
		if (mysqli_num_rows($result_allActiveMechsCount) > 0) {
			while($row_allActiveMechsCount = mysqli_fetch_assoc($result_allActiveMechsCount)) {
				$allActiveMechsCount = $allActiveMechsCount + 1;
			}
		}

		// select the number of mechs that are active bid and in the players units AND have moved and fired
		$allActiveMechsFinishedCount = 0;
		$sql_allActiveMechsFinishedCount = "";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "SELECT SQL_NO_CACHE * ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "FROM asc_assign a, asc_mech m ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "WHERE unitid in (".$formationIds.") ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "AND a.mechid = m.mechid ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "AND m.mech_status != 'destroyed' ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "AND m.active_bid = 1 ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "AND a.round_moved > 0 ";
		$sql_allActiveMechsFinishedCount = $sql_allActiveMechsFinishedCount . "AND a.round_fired > 0 ";
		echo $sql_allActiveMechsFinishedCount;
		$result_allActiveMechsFinishedCount = mysqli_query($conn, $sql_allActiveMechsFinishedCount);
		if (mysqli_num_rows($result_allActiveMechsFinishedCount) > 0) {
			while($row_allActiveMechsFinishedCount = mysqli_fetch_assoc($result_allActiveMechsFinishedCount)) {
				$allActiveMechsFinishedCount = $allActiveMechsFinishedCount + 1;
			}
		}

		// select the mechs that are active bid and in the players units AND have !!!! NOT !!!! moved and fired
		// To list them in the error message
		$allActiveMechIDsNOTFinished = "";
		$sql_allActiveMechIDsNOTFinished = "";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "SELECT SQL_NO_CACHE * ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "FROM asc_assign a, asc_mech m, asc_pilot p ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "WHERE unitid in (".$formationIds.") ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "AND a.mechid = m.mechid ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "AND a.pilotid = p.pilotid ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "AND m.mech_status != 'destroyed' ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "AND m.active_bid = 1 ";
		$sql_allActiveMechIDsNOTFinished = $sql_allActiveMechIDsNOTFinished . "AND (a.round_moved = 0 OR a.round_fired = 0) ";
		echo $sql_allActiveMechIDsNOTFinished;
		$result_allActiveMechIDsNOTFinished = mysqli_query($conn, $sql_allActiveMechIDsNOTFinished);
		if (mysqli_num_rows($result_allActiveMechIDsNOTFinished) > 0) {
			while($row_allActiveMechIDsNOTFinished = mysqli_fetch_assoc($result_allActiveMechIDsNOTFinished)) {
				$formationId = $row_allActiveMechIDsNOTFinished["unitid"];
				$mechId = $row_allActiveMechIDsNOTFinished["mechid"];
				$mechModel = $row_allActiveMechIDsNOTFinished["as_model"];
				$pilotName = $row_allActiveMechIDsNOTFinished["name"];

				if ($allActiveMechIDsNOTFinished == "") {
                    $allActiveMechIDsNOTFinished = $allActiveMechIDsNOTFinished.$formationId."|".$mechId."|".$mechModel."|".$pilotName;
                } else {
                    $allActiveMechIDsNOTFinished = $allActiveMechIDsNOTFinished.",".$formationId."|".$mechId."|".$mechModel."|".$pilotName;
                }
			}
		}

		if ($allActiveMechsCount == $allActiveMechsFinishedCount) {
			// all Mechs did move and fired in this round and the round can be finalized
			$sql_asc_assign = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid in (".$formationIds.");";
			echo $sql_asc_assign;
			$result_asc_assign = mysqli_query($conn, $sql_asc_assign);
			if (mysqli_num_rows($result_asc_assign) > 0) {
				while($row = mysqli_fetch_assoc($result_asc_assign)) {
					$mechId = $row["mechid"];
					$roundMoved = $row["round_moved"];
					$roundFired = $row["round_fired"];

					// Mechstatus
					$sql_asc_mechstatus = "SELECT SQL_NO_CACHE * FROM asc_mechstatus where mechid=".$mechId.";";
					$result_asc_mechstatus = mysqli_query($conn, $sql_asc_mechstatus);
					if (mysqli_num_rows($result_asc_mechstatus) > 0) {
						while($row = mysqli_fetch_assoc($result_asc_mechstatus)) {
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

							$finalHeat = $heat + $usedOverHeat + $HT_PREP;
							$final_ENGN = $ENGN + $ENGN_PREP;
							$final_FRCTRL = $FRCTRL + $FRCTRL_PREP;
							$final_MP = $MP + $MP_PREP;
							$final_WPNS = $WPNS + $WPNS_PREP;

							if ($finalHeat > 4) { $finalHeat = 4; }
							if ($final_ENGN > 2) { $final_ENGN = 2; }
							if ($final_FRCTRL > 4) { $final_FRCTRL = 4; }
							if ($final_MP > 4) { $final_MP = 4; }
							if ($final_WPNS > 4) { $final_WPNS = 4; }

							// Check for number for "DO NOT FIRE", if the mech held fire, reduce effective overheat to 0
							//console.log("Fire 1: hold fire");
							//console.log("Fire 2: fired");
							if ($roundFired == 1) { // 1 = hold fire!
								if ($final_ENGN == 1) {
									$finalHeat = 1;
								} else if ($final_ENGN == 2) {
									$finalHeat = 4;
								} else {
									$finalHeat = 0;
								}
							} else {
								if ($final_ENGN == 1) {
									if ($finalHeat < 1) {
										$finalHeat = 1;
									}
								} else if ($final_ENGN == 2) {
									$finalHeat = 4;
								}
							}

							$sqlUpdateMechStatus = "";
							$sqlUpdateMechStatus = $sqlUpdateMechStatus . "UPDATE asc_mechstatus ";
							$sqlUpdateMechStatus = $sqlUpdateMechStatus . "SET ";
							$sqlUpdateMechStatus = $sqlUpdateMechStatus . "crit_engine_PREP=0, crit_fc_PREP=0, crit_mp_PREP=0, crit_weapons_PREP=0, heat_PREP=0, usedoverheat=0, ";
							$sqlUpdateMechStatus = $sqlUpdateMechStatus . "crit_engine=".$final_ENGN.", crit_fc=".$final_FRCTRL.", crit_mp=".$final_MP.", crit_weapons=".$final_WPNS.", heat=".$finalHeat." ";
							$sqlUpdateMechStatus = $sqlUpdateMechStatus . "where mechid=".$mechId.";";
							echo $sqlUpdateMechStatus."<br><br>";
							if (mysqli_query($conn, $sqlUpdateMechStatus)) {
								echo "<br>";
								echo "Record (asc_mechstatus) updated successfully<br>";
								mysqli_commit($conn);
							} else {
								echo "<br>";
								echo "Error (asc_mechstatus) updating record: " . mysqli_error($conn) . "<br>";

								echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
								die('ERROR 1');
							}
						}
					}

					// Update fired and moved for mechid in asc_assign
					$sqlUpdateMechMovementFiresStatus = "";
					$sqlUpdateMechMovementFiresStatus = $sqlUpdateMechMovementFiresStatus . "UPDATE asc_assign ";
					$sqlUpdateMechMovementFiresStatus = $sqlUpdateMechMovementFiresStatus . "SET ";
					$sqlUpdateMechMovementFiresStatus = $sqlUpdateMechMovementFiresStatus . "round_moved=0, round_fired=0 ";
					$sqlUpdateMechMovementFiresStatus = $sqlUpdateMechMovementFiresStatus . "where mechid=".$mechId.";";

					echo $sqlUpdateMechMovementFiresStatus;

					if (mysqli_query($conn, $sqlUpdateMechMovementFiresStatus)) {
						echo "<br>";
						echo "Record (asc_assign) updated successfully<br>";
						mysqli_commit($conn);
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
			echo "<script>top.window.location = './gui_message_round_finalized_error_02.php?mechs=".$allActiveMechIDsNOTFinished."'</script>";
			die('ERROR 5');
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
