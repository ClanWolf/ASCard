<?php
	$repairMode = 0;
	if (isset($gid)) {
		$selectRepairMode = "SELECT * FROM asc_game WHERE gameid = ".$gid.";";
		$result_selectRepairMode = mysqli_query($conn, $selectRepairMode);
		if (mysqli_num_rows($result_selectRepairMode) > 0) {
			while($row77 = mysqli_fetch_assoc($result_selectRepairMode)) {
				$repairMode = $row77["repairActive"];
			}
		}
	}

	$currentlyAvailableSupportPoints = 0;
	$C3_SeasonId     = 1;
	$C3_CurrentRound = -1;
	$CW_FactionID    = 36; // Clan Wolf in C3 DB
	$CJF_FactionID   = 32; // Clan Jade Falcon in C3 DB

	$RepairCost_Light_Mech_Damaged    = -15;
	$RepairCost_Light_Armor_Damaged   = -3;
	$RepairCost_Light_Mech_Crippled   = -30;
	$RepairCost_Light_Armor_Crippled  = -6;
	$RepairCost_Light_Mech_Destroyed  = -45;
	$RepairCost_Light_Armor_Destroyed = -9;

	$RepairCost_Medium_Mech_Damaged    = -30;
	$RepairCost_Medium_Armor_Damaged   = -6;
	$RepairCost_Medium_Mech_Crippled   = -45;
	$RepairCost_Medium_Armor_Crippled  = -15;
	$RepairCost_Medium_Mech_Destroyed  = -60;
	$RepairCost_Medium_Armor_Destroyed = -25;

	$RepairCost_Heavy_Mech_Damaged    = -60;
	$RepairCost_Heavy_Armor_Damaged   = -15;
	$RepairCost_Heavy_Mech_Crippled   = -75;
	$RepairCost_Heavy_Armor_Crippled  = -25;
	$RepairCost_Heavy_Mech_Destroyed  = -80;
	$RepairCost_Heavy_Armor_Destroyed = -40;

	$RepairCost_Assault_Mech_Damaged    = -80;
	$RepairCost_Assault_Armor_Damaged   = -20;
	$RepairCost_Assault_Mech_Crippled   = -100;
	$RepairCost_Assault_Armor_Crippled  = -40;
	$RepairCost_Assault_Mech_Destroyed  = -125;
	$RepairCost_Assault_Armor_Destroyed = -75;

	$playerFactionId = -1;
	if (isset($gid) && isset($pid)) {
		$selectPlayerFaction = "SELECT * FROM asc_player WHERE playerid = ".$pid;
		$result_selectPlayerFaction = mysqli_query($conn, $selectPlayerFaction);
		if (mysqli_num_rows($result_selectPlayerFaction) > 0) {
			while($row87 = mysqli_fetch_assoc($result_selectPlayerFaction)) {
				$playerFactionId = $row87["factionid"];
			}
		}

		$selectCurrentRound = "SELECT * FROM c3_ROUND WHERE Season=".$C3_SeasonId;
		$result_selectCurrentRound = mysqli_query($conn, $selectCurrentRound);
		if (mysqli_num_rows($result_selectCurrentRound) > 0) {
			while($row84a = mysqli_fetch_assoc($result_selectCurrentRound)) {
				$C3_CurrentRound = $row84a["Round"];
			}
		}

		// FactionId ASCard CW:  1
		// FactionId ASCard CJF: 9
		if ($playerFactionId > 0) {
			if ($playerFactionId == 1) {
				$c3FactionId = 36; // 1,36: CW
			} else {
				$c3FactionId = 32; // 9,32: CJF
			}

			// Select the PCP only from the PREVIOUS rounds (and the entries where attack == null)!
			// Current round PCP are not yet Support Points
			$selectPlanetaryControlPoints  = "SELECT SUM(PCP) supportPoints FROM c3_SCORE ";
			$selectPlanetaryControlPoints .= "WHERE SeasonID=".$C3_SeasonId." ";
			$selectPlanetaryControlPoints .= "AND PCP IS NOT NULL ";
			$selectPlanetaryControlPoints .= "AND VP IS NULL ";
			$selectPlanetaryControlPoints .= "AND FactionID=".$c3FactionId.";";
			$result_selectPlanetaryControlPoints = mysqli_query($conn, $selectPlanetaryControlPoints);
			if (mysqli_num_rows($result_selectPlanetaryControlPoints) > 0) {
				while($row89a = mysqli_fetch_assoc($result_selectPlanetaryControlPoints)) {
					$currentlyAvailableSupportPoints = $row89a["supportPoints"];
				}
			}
		}
	}
?>
