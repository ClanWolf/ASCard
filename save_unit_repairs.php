<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$pid             = isset($_SESSION["playerid"]) ? filter_var($_SESSION["playerid"], FILTER_VALIDATE_INT) : "not found";
	$gid             = isset($_SESSION["gameid"]) ? filter_var($_SESSION['gameid'], FILTER_VALIDATE_INT) : "not found";
	$playerFactionId = isset($_SESSION["factionid"]) ? filter_var($_SESSION['factionid'], FILTER_VALIDATE_INT) : "not found";

	$unitId         = isset($_GET["uid"]) ? $_GET["uid"] : "";
	$unitRepairCost = isset($_GET["unitrepaircost"]) ? $_GET["unitrepaircost"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	// -----------------------------------------------------------------------------------------------------------------
	// https://www.php.net/manual/en/mysqli.begin-transaction.php

	if (!empty($pid) && !empty($unitId) && !empty($unitRepairCost)) {
		echo "PlayerId   : ".$pid."<br>";
		echo "GameId     : ".$gid."<br>";
		echo "UnitId     : ".$unitId."<br>";
		echo "RepairCost : ".$unitRepairCost."<br><br>";

		echo "SAVING DATA...<br><br>";

		$sqlSelectUnitWithStatus = "";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "SELECT * from asc_unitstatus us, asc_unit u ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "WHERE u.playerid=".$pid." ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.playerid=u.playerid ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.unitid=u.unitid ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND us.gameid=".$gid." ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND initial_status=1 ";
		$sqlSelectUnitWithStatus = $sqlSelectUnitWithStatus . "AND u.unitid=".$unitId.";";

		$result_selectUnitWithStatus = mysqli_query($conn, $sqlSelectUnitWithStatus);
		if (mysqli_num_rows($result_selectUnitWithStatus) > 0) {
			while($row = mysqli_fetch_assoc($result_selectUnitWithStatus)) {
				$unitid       = $row["unitid"];
				$unittype     = $row["as_tp"];
				$unitstatusid = $row["unitstatusid"];

				echo "playerid     : ".$pid."<br>";
				echo "gameid       : ".$gid."<br>";
				echo "unitid       : ".$unitid."<br>";
				echo "unittype     : ".$unittype."<br>";
				echo "unitstatusid : ".$unitstatusid."<br><br>";

				$sqlUpdateInitialUnitstatusEntry = "";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "UPDATE asc_unitstatus ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "SET ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "heat = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "armor = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "`structure` = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_engine = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_fc = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_mp = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "crit_weapons = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "unit_status = 'fresh', ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "unit_statusimageurl = 'images/DD_".$unittype."_01.png', ";
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
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "mounted_unitid = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "mounted_on_unitid = 0, ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "repaired = 1 ";
				$sqlUpdateInitialUnitstatusEntry = $sqlUpdateInitialUnitstatusEntry . "WHERE unitstatusid = ".$unitstatusid.";";

				echo $sqlUpdateInitialUnitstatusEntry;

				if (mysqli_query($conn, $sqlUpdateInitialUnitstatusEntry)) {
					echo "<br>";
					echo "Record (asc_unitstatus) updated successfully<br>";

					if ($playerFactionId == 1) {
						$c3FactionId = 36; // 1,36: CW
					} else if ($playerFactionId == 9) {
						$c3FactionId = 32; // 9,32: CJF
					}

					// Insert Score entry
					$sqlinsertscore = "INSERT INTO c3_SCORE (SeasonID, FactionID, AttackID, Description, PCP, VP) VALUES ";
					$sqlinsertscore = $sqlinsertscore . "(1, ".$c3FactionId.", null, 'Unit ".$unitid." repaired by player ".$pid.".', ".$unitRepairCost.", null)";
					if (mysqli_query($conn, $sqlinsertscore)) {
						// Success inserting formations for new player
					} else {
						// Error
						echo "Error: " . $sqlinsertscore . "<br>" . mysqli_error($conn);
					}
					echo "<script>top.location.reload();</script>";
				} else {
					echo "<br>";
					echo "Error (asc_unitstatus) updating records: ".mysqli_error($conn)."<br>";
					die('ERROR 17');
				}
			}
		}
	} else {
		echo "Missing data! Nothing was stored!<br>";
	}
	echo "</body>\n";
	echo "</html>\n";
?>
