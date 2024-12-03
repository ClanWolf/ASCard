<?php
	require('./db.php');

	$factionid = 0;
	$mechid = 0;
	$pilotid = 0;

	$useMULImages = 0;

	$CURRENTROUND = -1;

	$FACTION = "DEFAULT";
	$FACTION_IMG_URL = "...";
	$FORMATION = "DEFAULT";

	$GAMEID = -1;

	// Store in arrays to keep the mech- and pilotdata
	$array_PILOT = array();
	$array_PILOT_RANK = array();
	$array_PILOT_IMG_URL = array();

	$array_MVMT = array();
	$array_WPNSFIRED = array();

	$array_MECH_DBID = array();
	$array_MECH_MULID = array();
	$array_MECH_NUMBER = array();
	$array_MECH_IMG_URL = array();
	$array_MECH_IMG_STATUS = array();
	$array_MECH_STATUSSTRING = array();
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
			$CURRENTROUND = $row["round"];
		}
	}
	mysqli_free_result($result_asc_playerround);

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
	// id; formationid; mechid; pilotid
	$mechcount = 0;
	$sql_asc = "SELECT SQL_NO_CACHE * FROM asc_assign;";
	$result_asc = mysqli_query($conn, $sql_asc);
	if (mysqli_num_rows($result_asc) > 0) {
		while($row = mysqli_fetch_assoc($result_asc)) {
			if ($row["formationid"] == $formationid) {
				$mechcount++;
				// echo "<script>console.log('Mech-ID: ".$mechid."');</script>";
				// echo "<script>console.log('Pilot-ID: ".$pilotid."');</script>";
				$mechid = $row["mechid"];
				$pilotid = $row["pilotid"];

				$array_MVMT[$mechcount] = $row["round_moved"];
				$array_WPNSFIRED[$mechcount] = $row["round_fired"];

				// Mech
				// mechid; mulid; mech_tonnage; custom_name; as_name; as_model;
				// as_pv; as_tp; as_sz; as_tmm; as_mv; as_role; as_skill;
				// as_short; as_short_min; as_medium; as_medium_min;
				// as_long; as_long_min; as_extreme; as_extreme_min;
				// as_ov; as_armor; as_structure; as_threshold; as_specials;
				// mech_imageurl
				// and active_bid=1
				$sql_asc_mech = "SELECT SQL_NO_CACHE * FROM asc_mech where mechid=".$mechid." order by mech_tonnage desc;";
				$result_asc_mech = mysqli_query($conn, $sql_asc_mech);
				if (mysqli_num_rows($result_asc_mech) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_mech)) {
						if ($row["mechid"] == $mechid) {

							$clan = "";
							if ($row["tech"] == "2") {
								//$clan = "c ";
							}

							$array_MECH_DBID[$mechcount] = $row["mechid"];
							$array_MECH_MULID[$mechcount] = $row["mulid"];
							$array_MECH_NUMBER[$mechcount] = $row["mech_number"];
							$array_MECH_MODEL[$mechcount] = $clan.$row["as_model"];
							$array_MECH_IMG_URL[$mechcount] = $row["mech_imageurl"];
							$array_MECH_IMG_STATUS[$mechcount] = $row["mech_statusimageurl"];
							$array_MECH_STATUSSTRING[$mechcount] = $row["mech_status"];
							$array_TECH[$mechcount] = $row["tech"];
							$array_PV[$mechcount] = $row["as_pv"];
							$array_TP[$mechcount] = $row["as_tp"];
							$array_SZ[$mechcount] = $row["as_sz"];
							$array_TON[$mechcount] = $row["mech_tonnage"];
							$array_TMM[$mechcount] = $row["as_tmm"];
							$array_MV[$mechcount] = $row["as_mv"];
							$array_MVJ[$mechcount] = $row["as_mvj"];
							$array_MVTYPE[$mechcount] = $row["as_mvtype"];
							$array_ROLE[$mechcount] = $row["as_role"];
							$array_SKILL[$mechcount] = $row["as_skill"];
							$array_DMG_SHORT[$mechcount] = $row["as_short"];
							$array_DMG_MEDIUM[$mechcount] = $row["as_medium"];
							$array_DMG_LONG[$mechcount] = $row["as_long"];
							$array_OV[$mechcount] = $row["as_ov"];
							$array_SPCL[$mechcount] = $row["as_specials"];
							$array_A_MAX[$mechcount] = $row["as_armor"];
							$array_S_MAX[$mechcount] = $row["as_structure"];

							$array_MOUNTED_UNITID[$mechcount] = $row["mounted_unitid"];
                            $array_MOUNTED_ON_UNITID[$mechcount] = $row["mounted_on_unitid"];

							$array_ACTIVE_BID[$mechcount] = $row["active_bid"];
						}
					}
				}
				mysqli_free_result($result_asc_mech);

				// Mechstatus
				// mechstatusid; mechid; heat; armor; structure;
				// crit_engine; crit_fc; crit_mp; crit_weapons
				$sql_asc_mechstatus = "SELECT SQL_NO_CACHE * FROM asc_mechstatus where mechid=".$mechid.";";
				$result_asc_mechstatus = mysqli_query($conn, $sql_asc_mechstatus);
				if (mysqli_num_rows($result_asc_mechstatus) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_mechstatus)) {
						if ($row["mechid"] == $mechid) {
							$array_HT[$mechcount] = $row["heat"];
							$array_A[$mechcount] = $row["armor"];
							$array_S[$mechcount] = $row["structure"];
							$array_ENGN[$mechcount] = $row["crit_engine"];
							$array_FRCTRL[$mechcount] = $row["crit_fc"];
							$array_MP[$mechcount] = $row["crit_mp"];
							$array_WPNS[$mechcount] = $row["crit_weapons"];
							$array_ENGN_PREP[$mechcount] = $row["crit_engine_PREP"];
							$array_FRCTRL_PREP[$mechcount] = $row["crit_fc_PREP"];
							$array_MP_PREP[$mechcount] = $row["crit_mp_PREP"];
							$array_WPNS_PREP[$mechcount] = $row["crit_weapons_PREP"];

							$array_CV_ENGN[$mechcount] = $row["crit_CV_engine"];
							$array_CV_FRCTRL[$mechcount] = $row["crit_CV_firecontrol"];
							$array_CV_WPNS[$mechcount] = $row["crit_CV_weapons"];
							$array_CV_MOTV_A[$mechcount] = $row["crit_CV_motiveA"];
							$array_CV_MOTV_B[$mechcount] = $row["crit_CV_motiveB"];
							$array_CV_MOTV_C[$mechcount] = $row["crit_CV_motiveC"];
							$array_CV_ENGN_PREP[$mechcount] = $row["crit_CV_engine_PREP"];
							$array_CV_FRCTRL_PREP[$mechcount] = $row["crit_CV_firecontrol_PREP"];
							$array_CV_WPNS_PREP[$mechcount] = $row["crit_CV_weapons_PREP"];
							$array_CV_MOTV_A_PREP[$mechcount] = $row["crit_CV_motiveA_PREP"];
							$array_CV_MOTV_B_PREP[$mechcount] = $row["crit_CV_motiveB_PREP"];
							$array_CV_MOTV_C_PREP[$mechcount] = $row["crit_CV_motiveC_PREP"];

							$array_HT_PREP[$mechcount] = $row["heat_PREP"];
							$array_USEDOVERHEAT[$mechcount] = $row["usedoverheat"];
							$array_CURRENTTMM[$mechcount] = $row["currenttmm"];

							// echo "<script>console.log('".$sql_asc_mechstatus." --- ".$row["heat"]."');</script>";
						}
					}
				}
				mysqli_free_result($result_asc_mechstatus);

				// Pilot
				// pilotid; rank; name; callsign; --health--;
				// pilot_imageurl
				$sql_asc_pilot = "SELECT SQL_NO_CACHE * FROM asc_pilot where pilotid=".$pilotid.";";
				$result_asc_pilot = mysqli_query($conn, $sql_asc_pilot);
				if (mysqli_num_rows($result_asc_pilot) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_pilot)) {
						if ($row["pilotid"] == $pilotid) {
							$array_PILOT_RANK[$mechcount] = $row["rank"];
							$array_PILOT[$mechcount] = $row["name"];
							$array_PILOT_IMG_URL[$mechcount] = $row["pilot_imageurl"];
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
