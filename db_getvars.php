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

	$currentlyAvailableSupportPoints    = 0;
	$C3_SeasonId                        = 1;
	$C3_CurrentRound                    = -1;
	$CW_FactionID                       = 36; // Clan Wolf in C3 DB
	$CJF_FactionID                      = 32; // Clan Jade Falcon in C3 DB

	$VictoryPoints                      =  0;
	$VictoryPointsCaptialWorld          =  0;

	$RepairCost_Light_Mech_Destroyed    = -0;
	$RepairCost_Medium_Mech_Destroyed   = -0;
	$RepairCost_Heavy_Mech_Destroyed    = -0;
	$RepairCost_Assault_Mech_Destroyed  = -0;
	$RepairCost_Light_Mech_Crippled     = -0;
	$RepairCost_Medium_Mech_Crippled    = -0;
	$RepairCost_Heavy_Mech_Crippled     = -0;
	$RepairCost_Assault_Mech_Crippled   = -0;
	$RepairCost_Light_Mech_Damaged      = -0;
	$RepairCost_Medium_Mech_Damaged     = -0;
	$RepairCost_Heavy_Mech_Damaged      = -0;
	$RepairCost_Assault_Mech_Damaged    = -0;

	$RepairCost_Light_Armor_Destroyed   = -0;
	$RepairCost_Medium_Armor_Destroyed  = -0;
	$RepairCost_Heavy_Armor_Destroyed   = -0;
	$RepairCost_Assault_Armor_Destroyed = -0;
	$RepairCost_Light_Armor_Crippled    = -0;
	$RepairCost_Medium_Armor_Crippled   = -0;
	$RepairCost_Heavy_Armor_Crippled    = -0;
	$RepairCost_Assault_Armor_Crippled  = -0;
	$RepairCost_Light_Armor_Damaged     = -0;
	$RepairCost_Medium_Armor_Damaged    = -0;
	$RepairCost_Heavy_Armor_Damaged     = -0;
	$RepairCost_Assault_Armor_Damaged   = -0;

	$PCP_Aux                            =  0;
	$PCP_GGM                            =  0;
	$PCP_GME                            =  0;

	$selectCampaignVars = "SELECT * FROM c3_SCORE_REFERENCE WHERE SeasonId = ".$C3_SeasonId.";";
	$result_selectCampaignVars = mysqli_query($conn, $selectCampaignVars);
	if (mysqli_num_rows($result_selectCampaignVars) > 0) {
		while($row78f = mysqli_fetch_assoc($result_selectCampaignVars)) {
			$key = $row78f["Key"];
			$value = $row78f["Value"];

			if ($key === "VP")                { $VictoryPoints                      = $value; }
			if ($key === "VP_CW")             { $VictoryPointsCaptialWorld          = $value; }

			if ($key === "RC_BM_L_DESTROYED") { $RepairCost_Light_Mech_Destroyed    = $value; }
			if ($key === "RC_BM_M_DESTROYED") { $RepairCost_Medium_Mech_Destroyed   = $value; }
			if ($key === "RC_BM_H_DESTROYED") { $RepairCost_Heavy_Mech_Destroyed    = $value; }
			if ($key === "RC_BM_A_DESTROYED") { $RepairCost_Assault_Mech_Destroyed  = $value; }
			if ($key === "RC_BM_L_CRIPPLED")  { $RepairCost_Light_Mech_Crippled     = $value; }
			if ($key === "RC_BM_M_CRIPPLED")  { $RepairCost_Medium_Mech_Crippled    = $value; }
			if ($key === "RC_BM_H_CRIPPLED")  { $RepairCost_Heavy_Mech_Crippled     = $value; }
			if ($key === "RC_BM_A_CRIPPLED")  { $RepairCost_Assault_Mech_Crippled   = $value; }
			if ($key === "RC_BM_L_DAMAGED")   { $RepairCost_Light_Mech_Damaged      = $value; }
			if ($key === "RC_BM_M_DAMAGED")   { $RepairCost_Medium_Mech_Damaged     = $value; }
			if ($key === "RC_BM_H_DAMAGED")   { $RepairCost_Heavy_Mech_Damaged      = $value; }
			if ($key === "RC_BM_A_DAMAGED")   { $RepairCost_Assault_Mech_Damaged    = $value; }
			if ($key === "RC_CV_L_DESTROYED") { $RepairCost_Light_Armor_Destroyed   = $value; }
			if ($key === "RC_CV_M_DESTROYED") { $RepairCost_Medium_Armor_Destroyed  = $value; }
			if ($key === "RC_CV_H_DESTROYED") { $RepairCost_Heavy_Armor_Destroyed   = $value; }
			if ($key === "RC_CV_A_DESTROYED") { $RepairCost_Assault_Armor_Destroyed = $value; }
			if ($key === "RC_CV_L_CRIPPLED")  { $RepairCost_Light_Armor_Crippled    = $value; }
			if ($key === "RC_CV_M_CRIPPLED")  { $RepairCost_Medium_Armor_Crippled   = $value; }
			if ($key === "RC_CV_H_CRIPPLED")  { $RepairCost_Heavy_Armor_Crippled    = $value; }
			if ($key === "RC_CV_A_CRIPPLED")  { $RepairCost_Assault_Armor_Crippled  = $value; }
			if ($key === "RC_CV_L_DAMAGED")   { $RepairCost_Light_Armor_Damaged     = $value; }
			if ($key === "RC_CV_M_DAMAGED")   { $RepairCost_Medium_Armor_Damaged    = $value; }
			if ($key === "RC_CV_H_DAMAGED")   { $RepairCost_Heavy_Armor_Damaged     = $value; }
			if ($key === "RC_CV_A_DAMAGED")   { $RepairCost_Assault_Armor_Damaged   = $value; }

			if ($key === "PCP_AUX")           { $PCP_Aux                            = $value; }
			if ($key === "PCP_GGM")           { $PCP_GGM                            = $value; }
			if ($key === "PCP_GME")           { $PCP_GME                            = $value; }
		}
	}

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
		$c3FactionId = -1;
		if ($playerFactionId > 0) {
			if ($playerFactionId == 1) {
				$c3FactionId = 36; // 1,36: CW
			} else if ($playerFactionId == 9) {
				$c3FactionId = 32; // 9,32: CJF
			}

			// Select the PCP only from the PREVIOUS rounds (and the entries where attack == null)!
			// Current round PCP are not yet Support Points
			$selectPlanetaryControlPoints  = "SELECT SUM(PCP) supportPoints FROM c3_SCORE ";
			$selectPlanetaryControlPoints .= "WHERE SeasonID=".$C3_SeasonId." ";
			$selectPlanetaryControlPoints .= "AND PCP IS NOT NULL ";
			$selectPlanetaryControlPoints .= "AND VP IS NULL ";
			$selectPlanetaryControlPoints .= "AND FactionID=".$c3FactionId.";";

			//echo "<script>console.log('SQL: ".$selectPlanetaryControlPoints."');</script>";

			$result_selectPlanetaryControlPoints = mysqli_query($conn, $selectPlanetaryControlPoints);
			if (mysqli_num_rows($result_selectPlanetaryControlPoints) > 0) {
				while($row89a = mysqli_fetch_assoc($result_selectPlanetaryControlPoints)) {
					$currentlyAvailableSupportPoints = $row89a["supportPoints"];
				}
			}
		}
		if ($currentlyAvailableSupportPoints == null || $currentlyAvailableSupportPoints < 0) {
			$currentlyAvailableSupportPoints = 0;
		}
		//echo "<script>console.log('SupportPoints: ".$currentlyAvailableSupportPoints."');</script>";
	}
?>
