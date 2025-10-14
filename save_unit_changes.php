<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

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

		echo "UnitId: ".$unitId."<br>";
		echo "AssignId: ".$assignId."<br>";
		echo "PilotId: ".$pilotId."<br>";
		echo "UnitName: ".$newUnitName."<br>";
		echo "UnitSkill: ".$newUnitSkill."<br>";
		echo "PV: ".$newPV."<br>";
		echo "UnitNumber: ".$newUnitNUmber."<br>";
		echo "FormationId: ".$newFormationId."<br>";
		echo "PilotName: ".$newPilotName."<br>";
		echo "PilotImage: ".$newPilotImage."<br>";
		echo "Rank: ".$newRank."<br>";
		echo "SPAs: ".$newSPAs."<br>";
		echo "SPASum: ".$newSPASum."<br>";
		echo "Chain: ".$newChain ."<br>";

		// -------------------------------------------------------------------------------------------------------------
		// https://www.php.net/manual/en/mysqli.begin-transaction.php

		try {
			mysqli_begin_transaction($conn);
			echo "<br>Transaction started...";
			// ---------------------------------------------------------------------------------------------------------
			// Saving assign
			echo "<br>Saving assign...";

			$sql_assign = 'UPDATE asc_assign SET formationid=? WHERE assignid=?';
			$stmt_assign = mysqli_prepare($conn, $sql_assign);

			echo "<br><br>Statement: ".$sql_assign;
			echo "<br>- newFormationId: ".$newFormationId;
			echo "<br>- assignId: ".$assignId;

			mysqli_stmt_bind_param($stmt_assign, 'ii', $newFormationId, $assignId);
			mysqli_stmt_execute($stmt_assign);
			mysqli_stmt_close($stmt_assign);

			// ---------------------------------------------------------------------------------------------------------
			// Saving pilot
			echo "<br>Saving pilot...";

			if ($newPilotImage != "") {
				echo "<br>New Pilot image found.";

				$sql_pilot = 'UPDATE asc_pilot SET name=?,rank=?,pilot_imageurl=?,SPA=?,SPA_cost_sum=? WHERE pilotid=?';
				$stmt_pilot = mysqli_prepare($conn, $sql_pilot);

				echo "<br><br>Statement: ".$sql_pilot;
				echo "<br>- newPilotName: ".$newPilotName;
				echo "<br>- newRank: ".$newRank;
				echo "<br>- pilot_imageurl: "."images/pilots/".$newPilotImage;
				echo "<br>- SPA: ".$newSPAs;
				echo "<br>- SPA_cost_sum: ".$newSPASum;
				echo "<br>- pilotId: ".$pilotId;

				$pim = "images/pilots/".$newPilotImage;

				mysqli_stmt_bind_param($stmt_pilot, 'ssssii', $newPilotName, $newRank, $pim, $newSPAs, $newSPASum, $pilotId);
			} else {
				echo "<br>NO new Pilot image found.";

				$sql_pilot = 'UPDATE asc_pilot SET name=?,rank=?,SPA=?,SPA_cost_sum=? WHERE pilotid=?';
				$stmt_pilot = mysqli_prepare($conn, $sql_pilot);

				echo "<br><br>Statement: ".$sql_pilot;
				echo "<br>- newPilotName: ".$newPilotName;
				echo "<br>- newRank: ".$newRank;
				echo "<br>- SPA: ".$newSPAs;
				echo "<br>- SPA_cost_sum: ".$newSPASum;
				echo "<br>- pilotId: ".$pilotId;

				mysqli_stmt_bind_param($stmt_pilot, 'sssii', $newPilotName, $newRank, $newSPAs, $newSPASum, $pilotId);
			}

			mysqli_stmt_execute($stmt_pilot);
			mysqli_stmt_close($stmt_pilot);

			// ---------------------------------------------------------------------------------------------------------
			// Saving unit
			echo "<br>Saving unit...";

			$sql_unit = 'UPDATE asc_unit SET unit_name=?,as_skill=?,as_pv=?,unit_number=?,commander=?,subcommander=? WHERE unitid=?';
			$stmt_unit = mysqli_prepare($conn, $sql_unit);

			echo "<br><br>Statement: ".$sql_unit;
			echo "<br>- unit_name: ".$newUnitName;
			echo "<br>- as_skill: ".$newUnitSkill;
			echo "<br>- as_pv: ".$newPV;
			echo "<br>- unit_number: ".$newUnitNUmber;
			echo "<br>- chain: ".$newChain;

			if (strtolower($newChain) === "commander") {
				$commander = 1;
				$subcommander = 0;
			} else if (strtolower($newChain) === "subcommander") {
				$commander = 0;
				$subcommander = 1;
			} else {
				$commander = 0;
				$subcommander = 0;
			}

			mysqli_stmt_bind_param($stmt_unit, 'siisiii', $newUnitName, $newUnitSkill, $newPV, $newUnitNUmber, $commander, $subcommander, $unitId);
			mysqli_stmt_execute($stmt_unit);
			mysqli_stmt_close($stmt_unit);

			// ---------------------------------------------------------------------------------------------------------
			mysqli_commit($conn);
			echo "<br>... committed.";

			echo "<script>top.window.location = './gui_select_unit.php'</script>";
		} catch (mysqli_sql_exception $exception) {
			echo "<br>... ERROR. Rolling back changes!";
			mysqli_rollback($conn);
			throw $exception;
		}
	} else {
		echo "Missing data! Nothing was stored!<br>";
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
