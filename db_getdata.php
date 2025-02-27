<?php
	require('./db.php');

	$factionid = 0;
	$unitid = 0;
	$pilotid = 0;

	$useMULImages = 0;

	$CURRENTROUND = -1;
	$ROUNDSOUTOFSYNC = false;

	$FACTION = "DEFAULT";
	$FACTION_IMG_URL = "...";
	$COMMAND = "DEFAULT";
	$FORMATION = "DEFAULT";

	$GAMEID = -1;
	$HOSTEDGAMEID = -1;

	// Store in arrays to keep the unit- and pilotdata
	$array_PILOT = array();
	$array_PILOT_RANK = array();
	$array_PILOT_IMG_URL = array();

	$array_PLAYER_FORMATION_IDS = array();
	$array_PLAYER_FORMATION_FACTIONIDS = array();
	$array_PLAYER_FORMATION_COMMANDIDS = array();
	$array_PLAYER_FORMATION_NAMES = array();
	$array_PLAYER_UNITS_IN_FORMATION = array();

	$array_MVMT = array();
	$array_WPNSFIRED = array();

	$array_UNIT_DBID = array();
	$array_UNIT_MULID = array();
	$array_UNIT_NUMBER = array();
	$array_UNIT_NAME = array();
	$array_UNIT_IMG_URL = array();
	$array_UNIT_IMG_STATUS = array();
	$array_UNIT_STATUSSTRING = array();
	$array_TECH = array();
	$array_PV = array();
	$array_TP = array();
	$array_SZ = array();
	$array_TON = array();
	$array_TMM = array();
	$array_MV = array();
	$array_MVJ = array();
	$array_MVTYPE = array();
	$array_ROLE = array();
	$array_SKILL = array();
	$array_DMG_SHORT = array();
	$array_DMG_MEDIUM = array();
	$array_DMG_LONG = array();
	$array_OV = array();
	$array_SPCL = array();
	$array_A_MAX = array();
	$array_S_MAX = array();

	$array_HT = array();
	$array_A = array();
	$array_S = array();

	$array_MOUNTED_UNITID = array();
	$array_MOUNTED_ON_UNITID = array();

	$array_NARCDESC = array();
	$array_NARCED = array();
	$array_TAGED = array();
	$array_WATER = array();
	$array_ROUTED = array();

	$array_ENGN = array();
	$array_FRCTRL = array();
	$array_MP = array();
	$array_WPNS = array();

	$array_ENGN_PREP = array();
	$array_FRCTRL_PREP = array();
	$array_MP_PREP = array();
	$array_WPNS_PREP = array();
	$array_HT_PREP = array();

	$array_CV_ENGN = array();
	$array_CV_FRCTRL = array();
	$array_CV_WPNS = array();
	$array_CV_MOTV_A = array();
	$array_CV_MOTV_B = array();
	$array_CV_MOTV_C = array();

	$array_CV_ENGN_PREP = array();
	$array_CV_FRCTRL_PREP = array();
	$array_CV_WPNS_PREP = array();
	$array_CV_MOTV_A_PREP = array();
	$array_CV_MOTV_B_PREP = array();
	$array_CV_MOTV_C_PREP = array();

	$array_MV_MOD = array();
	$array_DMG_SHORT_MOD = array();
	$array_DMG_MEDIUM_MOD = array();
	$array_DMG_LONG_MOD = array();

	$array_ACTIVE_BID = array();

	$array_USEDOVERHEAT = array();
	$array_CURRENTTMM = array();

//	// Game
//	// currentround
//	$sql_asc_game = "SELECT SQL_NO_CACHE * FROM asc_game where gameid = 1;";
//	$result_asc_game = mysqli_query($conn, $sql_asc_game);
//	if (mysqli_num_rows($result_asc_game) > 0) {
//		while($row = mysqli_fetch_assoc($result_asc_game)) {
//			$CURRENTROUND = $row["currentround"];
//		}
//	}
//	mysqli_free_result($result_asc_game);

	// Formation
	// formationid; factionid; formationname; --parentforceid--; formation_imageurl; playable
	$sql_asc_formation = "SELECT SQL_NO_CACHE * FROM asc_formation;";
	$result_asc_formation = mysqli_query($conn, $sql_asc_formation);
	if (mysqli_num_rows($result_asc_formation) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_formation)) {
			if ($row["formationid"] == $formationid) {
				$FORMATION = $row["formationname"];
				$factionid = $row["factionid"];
				$formationplayerid = $row["playerid"];
			}
		}
	}
	mysqli_free_result($result_asc_formation);

	// Player formations
	$formationscount = 0;
	$sql_asc_playerformations = "SELECT SQL_NO_CACHE * FROM asc_formation where playerid = ".$pid." ORDER BY formationid;";
	$result_asc_playerformations = mysqli_query($conn, $sql_asc_playerformations);
	if (mysqli_num_rows($result_asc_playerformations) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerformations)) {
			$array_PLAYER_FORMATION_IDS[$formationscount] = $row["formationid"];
			$array_PLAYER_FORMATION_FACTIONIDS[$formationscount] = $row["factionid"];
			$array_PLAYER_FORMATION_COMMANDIDS[$formationscount] = $row["commandid"];
			$array_PLAYER_FORMATION_NAMES[$formationscount] = $row["formationname"];
			$formationscount++;
		}
	}
	mysqli_free_result($result_asc_playerformations);

	// Use MUL Images
	$sql_asc_useMULImages = "SELECT SQL_NO_CACHE * FROM asc_options where playerid = " . $formationplayerid . ";";
	$result_asc_useMULImages = mysqli_query($conn, $sql_asc_useMULImages);
	if (mysqli_num_rows($result_asc_useMULImages) > 0) {
		while($row33 = mysqli_fetch_assoc($result_asc_useMULImages)) {
			$useMULImages = $row33["UseMULImages"];
		}
	}
	mysqli_free_result($result_asc_useMULImages);

	// Game
	// currentround from player
	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $formationplayerid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$GAMEID = $row["gameid"];
			$HOSTEDGAMEID = $row["hostedgameid"];
			$CURRENTROUND = $row["round"];
		}
	}
	mysqli_free_result($result_asc_playerround);

	// Check for current game if rounds are out of sync
	$sql_asc_playerroundsingame = "SELECT SQL_NO_CACHE round FROM asc_player WHERE gameid = " . $GAMEID . ";";
	$result_asc_playerroundsingame = mysqli_query($conn, $sql_asc_playerroundsingame);
	if (mysqli_num_rows($result_asc_playerroundsingame) > 0) {
		$lastGameId = -1;
		while($row = mysqli_fetch_assoc($result_asc_playerroundsingame)) {
			$cgid = $row['round'];
			if ($lastGameId != -1 && $lastGameId != $cgid) {
				$ROUNDSOUTOFSYNC = true;
			}
			$lastGameId = $cgid;
		}
	}

	// Units in player formations
	for ($cc = 0; $cc < sizeof($array_PLAYER_FORMATION_IDS); $cc++) {
		$unitdata = array();
		$currentformationid = $array_PLAYER_FORMATION_IDS[$cc];
		$sql_asc_playerunitsinformation = "SELECT SQL_NO_CACHE * FROM asc_assign WHERE formationid=".$currentformationid.";";
		$result_asc_playerunitsinformation = mysqli_query($conn, $sql_asc_playerunitsinformation);
		if (mysqli_num_rows($result_asc_playerunitsinformation) > 0) {
			$units_in_formation = array();
			while($row = mysqli_fetch_assoc($result_asc_playerunitsinformation)) {
				$unitdata['unitid'] = $row["unitid"];
				$unitdata['round_moved'] = $row["round_moved"];
				$unitdata['round_fired'] = $row["round_fired"];

				// Select faction logo
				$sql_asc_playerformationfaction = "SELECT SQL_NO_CACHE * FROM asc_faction where factionid = ".$array_PLAYER_FORMATION_FACTIONIDS[$cc]." ORDER BY factionid;";
				$result_asc_playerformationfaction = mysqli_query($conn, $sql_asc_playerformationfaction);
				if (mysqli_num_rows($result_asc_playerformationfaction) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_playerformationfaction)) {
						$unitdata['faction_logo'] = $row["factionimage"];
					}
				}

				$sql_currentunit = "SELECT SQL_NO_CACHE * FROM asc_unit where unitid=".$unitdata['unitid'].";";
				$result_currentunit = mysqli_query($conn, $sql_currentunit);
				if (mysqli_num_rows($result_currentunit) > 0) {
					while($row = mysqli_fetch_assoc($result_currentunit)) {
						if ($row["unit_number"] != null) {
							$unitdata['unit_number'] = $row["unit_number"];
						} else {
							$unitdata['unit_number'] = "-";
						}
					}
				}

				$sql_currentunitstatus = "SELECT SQL_NO_CACHE * FROM asc_unitstatus where unitid=".$unitdata['unitid']." and round=".$CURRENTROUND." and gameid=".$gid.";";
				$result_currentunitstatus = mysqli_query($conn, $sql_currentunitstatus);
				if (mysqli_num_rows($result_currentunitstatus) > 0) {
					while($row = mysqli_fetch_assoc($result_currentunitstatus)) {
						$unitdata['status_image'] = $row["unit_statusimageurl"];
						$unitdata['active_bid'] = $row["active_bid"];
					}
				}

				$units_in_formation[$unitdata['unitid']] = $unitdata;
			}
			$array_PLAYER_UNITS_IN_FORMATION[$currentformationid] = $units_in_formation;
		}
		mysqli_free_result($result_asc_playerunitsinformation);
	}

	// Faction
	// factionid; name; --factiontype--; factionimage
	$sql_asc_faction = "SELECT SQL_NO_CACHE * FROM asc_faction where factionid=".$factionid.";";
	$result_asc_faction = mysqli_query($conn, $sql_asc_faction);
	if (mysqli_num_rows($result_asc_faction) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_faction)) {
			if ($row["factionid"] == $factionid) {
				$FACTION = $row["factionname"];
				$FACTION_IMG_URL = $row["factionimage"];
			}
		}
	}
	mysqli_free_result($result_asc_faction);

	// Alpha Strike Cards
	// id; formationid; unitid; pilotid
	$unitcount = 0;
	$sql_asc = "SELECT SQL_NO_CACHE * FROM asc_assign;";
	$result_asc = mysqli_query($conn, $sql_asc);
	if (mysqli_num_rows($result_asc) > 0) {
		while($row = mysqli_fetch_assoc($result_asc)) {
			if ($row["formationid"] == $formationid) {
				$unitcount++;
				// echo "<script>console.log('Unit-ID: ".$unitid."');</script>";
				// echo "<script>console.log('Pilot-ID: ".$pilotid."');</script>";
				$unitid = $row["unitid"];
				$pilotid = $row["pilotid"];

				$array_MVMT[$unitcount] = $row["round_moved"];
				$array_WPNSFIRED[$unitcount] = $row["round_fired"];

				// Unit
				// unitid; mulid; unit_tonnage; custom_name; as_name; as_model;
				// as_pv; as_tp; as_sz; as_tmm; as_mv; as_role; as_skill;
				// as_short; as_short_min; as_medium; as_medium_min;
				// as_long; as_long_min; as_extreme; as_extreme_min;
				// as_ov; as_armor; as_structure; as_threshold; as_specials;
				$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM asc_unit where unitid=".$unitid." order by unit_tonnage desc;";
				$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
				if (mysqli_num_rows($result_asc_unit) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_unit)) {
						if ($row["unitid"] == $unitid) {

							$clan = "";
							if ($row["tech"] == "2") {
								//$clan = "c ";
							}

							$array_UNIT_DBID[$unitcount] = $row["unitid"];
							$array_UNIT_MULID[$unitcount] = $row["mulid"];
							$array_UNIT_NUMBER[$unitcount] = $row["unit_number"];
							$array_UNIT_NAME[$unitcount] = $row["unit_name"];
							$array_UNIT_MODEL[$unitcount] = $clan.$row["as_model"];
							$array_UNIT_IMG_URL[$unitcount] = $row["unit_imageurl"];
							$array_TECH[$unitcount] = $row["tech"];
							$array_PV[$unitcount] = $row["as_pv"];
							$array_TP[$unitcount] = $row["as_tp"];
							$array_SZ[$unitcount] = $row["as_sz"];
							$array_TON[$unitcount] = $row["unit_tonnage"];
							$array_TMM[$unitcount] = $row["as_tmm"];
							$array_MV[$unitcount] = $row["as_mv"];
							$array_MVJ[$unitcount] = $row["as_mvj"];
							$array_MVTYPE[$unitcount] = $row["as_mvtype"];
							$array_ROLE[$unitcount] = $row["as_role"];
							$array_SKILL[$unitcount] = $row["as_skill"];
							$array_DMG_SHORT[$unitcount] = $row["as_short"];
							$array_DMG_MEDIUM[$unitcount] = $row["as_medium"];
							$array_DMG_LONG[$unitcount] = $row["as_long"];
							$array_OV[$unitcount] = $row["as_ov"];
							$array_SPCL[$unitcount] = $row["as_specials"];
							$array_A_MAX[$unitcount] = $row["as_armor"];
							$array_S_MAX[$unitcount] = $row["as_structure"];
						}
					}
				}
				mysqli_free_result($result_asc_unit);

				// Unitstatus
				// unitstatusid; unitid; heat; armor; structure;
				// crit_engine; crit_fc; crit_mp; crit_weapons
				$sql_asc_unitstatus = "SELECT SQL_NO_CACHE * FROM asc_unitstatus where unitid=".$unitid." and round=".$CURRENTROUND." and gameid=".$GAMEID.";";
				$result_asc_unitstatus = mysqli_query($conn, $sql_asc_unitstatus);
				if (mysqli_num_rows($result_asc_unitstatus) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_unitstatus)) {
						if ($row["unitid"] == $unitid) {
							$array_HT[$unitcount] = $row["heat"];
							$array_A[$unitcount] = $row["armor"];
							$array_S[$unitcount] = $row["structure"];
							$array_ENGN[$unitcount] = $row["crit_engine"];
							$array_FRCTRL[$unitcount] = $row["crit_fc"];
							$array_MP[$unitcount] = $row["crit_mp"];
							$array_WPNS[$unitcount] = $row["crit_weapons"];
							$array_ENGN_PREP[$unitcount] = $row["crit_engine_PREP"];
							$array_FRCTRL_PREP[$unitcount] = $row["crit_fc_PREP"];
							$array_MP_PREP[$unitcount] = $row["crit_mp_PREP"];
							$array_WPNS_PREP[$unitcount] = $row["crit_weapons_PREP"];

							$array_NARCDESC[$unitcount] = $row["narc_desc"];
							$array_NARCED[$unitcount] = $row["active_narc"];
							$array_TAGED[$unitcount] = $row["active_tag"];
							$array_WATER[$unitcount] = $row["active_water"];
							$array_ROUTED[$unitcount] = $row["active_routed"];

							$array_ACTIVE_BID[$unitcount] = $row["active_bid"];
							$array_UNIT_IMG_STATUS[$unitcount] = $row["unit_statusimageurl"];

							if ($array_UNIT_IMG_STATUS[$unitcount] == "_01.png") {
								$array_UNIT_IMG_STATUS[$unitcount] = "images/DD_".$array_TP[$unitcount]."_01.png";
							}

							$array_UNIT_STATUSSTRING[$unitcount] = $row["unit_status"];

							$array_CV_ENGN[$unitcount] = $row["crit_CV_engine"];
							$array_CV_FRCTRL[$unitcount] = $row["crit_CV_firecontrol"];
							$array_CV_WPNS[$unitcount] = $row["crit_CV_weapons"];
							$array_CV_MOTV_A[$unitcount] = $row["crit_CV_motiveA"];
							$array_CV_MOTV_B[$unitcount] = $row["crit_CV_motiveB"];
							$array_CV_MOTV_C[$unitcount] = $row["crit_CV_motiveC"];
							$array_CV_ENGN_PREP[$unitcount] = $row["crit_CV_engine_PREP"];
							$array_CV_FRCTRL_PREP[$unitcount] = $row["crit_CV_firecontrol_PREP"];
							$array_CV_WPNS_PREP[$unitcount] = $row["crit_CV_weapons_PREP"];
							$array_CV_MOTV_A_PREP[$unitcount] = $row["crit_CV_motiveA_PREP"];
							$array_CV_MOTV_B_PREP[$unitcount] = $row["crit_CV_motiveB_PREP"];
							$array_CV_MOTV_C_PREP[$unitcount] = $row["crit_CV_motiveC_PREP"];

							$array_HT_PREP[$unitcount] = $row["heat_PREP"];
							$array_USEDOVERHEAT[$unitcount] = $row["usedoverheat"];
							$array_CURRENTTMM[$unitcount] = $row["currenttmm"];

							$array_MOUNTED_UNITID[$unitcount] = $row["mounted_unitid"];
                            $array_MOUNTED_ON_UNITID[$unitcount] = $row["mounted_on_unitid"];

							// echo "<script>console.log('".$sql_asc_unitstatus." --- ".$row["heat"]."');</script>";
						}
					}
				}
				mysqli_free_result($result_asc_unitstatus);

				// Pilot
				// pilotid; rank; name; callsign; --health--;
				// pilot_imageurl
				$sql_asc_pilot = "SELECT SQL_NO_CACHE * FROM asc_pilot where pilotid=".$pilotid.";";
				$result_asc_pilot = mysqli_query($conn, $sql_asc_pilot);
				if (mysqli_num_rows($result_asc_pilot) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_pilot)) {
						if ($row["pilotid"] == $pilotid) {
							$array_PILOT_RANK[$unitcount] = $row["rank"];
							$array_PILOT[$unitcount] = $row["name"];
							$array_PILOT_IMG_URL[$unitcount] = $row["pilot_imageurl"];
						}
					}
				}
				mysqli_free_result($result_asc_pilot);
			}
		}
	}
	$thread_id = mysqli_thread_id($conn);

	mysqli_free_result($result_asc);
	mysqli_kill($conn, $thread_id);

	mysqli_close($conn);
?>
