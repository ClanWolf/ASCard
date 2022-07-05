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

		$unitIds = "";
		$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid = ".$pid.";";
		$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
		if (mysqli_num_rows($result_asc_unit) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_unit)) {
				$unitId = $row["unitid"];
				if ($unitIds == "") {
					$unitIds = $unitIds.$unitId;
				} else {
					$unitIds = $unitIds.",".$unitId;
				}
			}
		}

		$sql_asc_assign = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid in (".$unitIds.");";
		echo $sql_asc_assign;
		$result_asc_assign = mysqli_query($conn, $sql_asc_assign);
		if (mysqli_num_rows($result_asc_assign) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_assign)) {
				$mechId = $row["mechid"];
				$roundMoved = $row["round_moved"];
				$roundFired = $row["round_fired"];

				if ($roundMoved > 0 && $roundFired > 0) {
					$finishedMechsInThisRound = $finishedMechsInThisRound + 1;
				}

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
						// console.log("Fire 1: hold fire");
						// console.log("Fire 2: fired");
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
							die;
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
					die;
						}
			}
		}

		if ($finishedMechsInThisRound > 0) {
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
				die;
			} else {
				echo "<br>";
				echo "Error (asc_player) updating record: " . mysqli_error($conn) . "<br>";

				echo "<script>top.window.location = './gui_message_round_finalized_error_01.php'</script>";
				die;
			}
		} else {
			echo "<script>top.window.location = './gui_message_round_finalized_error_02.php'</script>";
			die;
		}
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
