<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$pid = $_SESSION['playerid'];

	$unitId         = isset($_GET["unitId"]) ? $_GET["unitId"] : "";
	$assignId       = isset($_GET["assignId"]) ? $_GET["assignId"] : "";
	$pilotId        = isset($_GET["pilotId"]) ? $_GET["pilotId"] : "";
	$newUnitName    = isset($_GET["nun"]) ? $_GET["nun"] : "";
	$newUnitSkill   = isset($_GET["nus"]) ? $_GET["nus"] : "";
	$newPV          = isset($_GET["npv"]) ? $_GET["npv"] : "";
	$newUnitNUmber  = isset($_GET["nunbr"]) ? $_GET["nunbr"] : "";
	$newFormationId = isset($_GET["nf"]) ? $_GET["nf"] : "";
	$newPilotName   = isset($_GET["npn"]) ? $_GET["npn"] : "";
	$newPilotImage  = isset($_GET["npi"]) ? $_GET["npi"] : "";
	$newRank        = isset($_GET["nr"]) ? $_GET["nr"] : "";
	$newSPAs        = isset($_GET["nspa"]) ? $_GET["nspa"] : "";
	$newSPASum      = isset($_GET["nspasum"]) ? $_GET["nspasum"] : "";
	$newChain       = isset($_GET["nch"]) ? $_GET["nch"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($unitId) && !empty($assignId) && !empty($pilotId)) {
		echo "SAVING DATA...<br><br>";

		echo "UnitId: " . $unitId."<br>";
		echo "AssignId: " . $assignId."<br>";
		echo "PilotId: " . $pilotId."<br>";
		echo "UnitName: " . $newUnitName."<br>";
		echo "UnitSkill: " . $newUnitSkill."<br>";
		echo "PV: " . $newPV."<br>";
		echo "UnitNumber: " . $newUnitNUmber."<br>";
		echo "FormationId: " . $newFormationId."<br>";
		echo "PilotName: " . $newPilotName."<br>";
		echo "PilotImage: " . $newPilotImage."<br>";
		echo "Rank: " . $newRank."<br>";
		echo "SPAs: " . $newSPAs."<br>";
		echo "SPASum: " . $newSPASum."<br>";
		echo "Chain: " . $newChain ."<br>";

		// -------------------------------------------------------------------------------------------------------------

		$sql_assign = "UPDATE asc_assign SET formationid=".$newFormationId." WHERE assignid=".$assignId.";";
		echo "<br><br>Statement: " . $sql_assign;

		if (mysqli_query($conn, $sql_assign)) {
			echo "<br>";
			echo "Record (asc_assign) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
		}

		// -------------------------------------------------------------------------------------------------------------

		if ($newPilotImage != "") {
			$sql_pilot = "UPDATE asc_pilot SET name='".$newPilotName."',rank='".$newRank."',pilot_imageurl='images/pilots/".$newPilotImage."',SPA='".$newSPAs."',SPA_cost_sum=".$newSPASum." WHERE pilotid=".$pilotId.";";
		} else {
			$sql_pilot = "UPDATE asc_pilot SET name='".$newPilotName."',rank='".$newRank."',SPA='".$newSPAs."',SPA_cost_sum=".$newSPASum." WHERE pilotid=".$pilotId.";";
		}
		echo "<br><br>Statement: " . $sql_pilot;

		if (mysqli_query($conn, $sql_pilot)) {
			echo "<br>";
			echo "Record (asc_pilot) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_pilot) updating record: " . mysqli_error($conn);
		}

		// -------------------------------------------------------------------------------------------------------------

		// Check if all units are destroyed
//		$sql4 = "SELECT SQL_NO_CACHE * FROM asc_unitstatus WHERE playerid=".$pid." AND active_bid=1 AND gameid=".$gameid." AND round=".$currRound." AND unit_status NOT LIKE '%destroyed%'";
//		echo "Statement: " . $sql4;
//		$result4 = mysqli_query($conn, $sql4);
//		if (mysqli_num_rows($result4) > 0) {
//			// There are units left that are not destroyed so the player is still in game
//			$sql7 = "UPDATE asc_player SET active_ingame=1 WHERE playerid=".$pid;
//			echo "Statement: " . $sql7;

//			if (mysqli_query($conn, $sql7)) {
//				echo "<br>";
//				echo "Record (player active in game) updated successfully";
//				mysqli_commit($conn);
//			} else {
//				echo "<br>";
//				echo "Error (player active in game) updating record: " . mysqli_error($conn);
//			}
//		} else {
//			// All units of this player in this game have been destroyed
//			$sql5 = "UPDATE asc_player SET active_ingame=0 WHERE playerid=".$pid;
//			echo "Statement: " . $sql5;

//			if (mysqli_query($conn, $sql5)) {
//				echo "<br>";
//				echo "Record (player active in game) updated successfully";
//				mysqli_commit($conn);
//			} else {
//				echo "<br>";
//				echo "Error (player active in game) updating record: " . mysqli_error($conn);
//			}
//		}
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}



//https://www.php.net/manual/en/mysqli.begin-transaction.php

//<?php
//
///* Tell mysqli to throw an exception if an error occurs */
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//
//$mysqli = mysqli_connect("localhost", "my_user", "my_password", "world");
//
///* The table engine has to support transactions */
//mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS language (
//    Code text NOT NULL,
//    Speakers int(11) NOT NULL
//    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
//
///* Start transaction */
//mysqli_begin_transaction($mysqli);
//
//try {
//    /* Insert some values */
//    mysqli_query($mysqli, "INSERT INTO language(Code, Speakers) VALUES ('DE', 42000123)");
//
//    /* Try to insert invalid values */
//    $language_code = 'FR';
//    $native_speakers = 'Unknown';
//    $stmt = mysqli_prepare($mysqli, 'INSERT INTO language(Code, Speakers) VALUES (?,?)');
//    mysqli_stmt_bind_param($stmt, 'ss', $language_code, $native_speakers);
//    mysqli_stmt_execute($stmt);
//
//    /* If code reaches this point without errors then commit the data in the database */
//    mysqli_commit($mysqli);
//} catch (mysqli_sql_exception $exception) {
//    mysqli_rollback($mysqli);
//
//    throw $exception;
//}


	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
