<?php
	require('./db.php');

	$factionid = 0;
	$mechid = 0;
	$pilotid = 0;

	$CURRENTROUND = -1;

	$FACTION = "DEFAULT";
	$FACTION_IMG_URL = "...";
	$UNIT = "DEFAULT";
	$UNIT_IMG_URL = "...";

	// Store in arrays to keep the mech- and pilotdata of the current unit
	$array_PILOT = array();
	$array_PILOT_IMG_URL = array();

	$array_MVMT = array();
	$array_WPNSFIRED = array();

	$array_MECH_DBID = array();
	$array_MECH_NUMBER = array();
	$array_MECH_IMG_URL = array();
	$array_MECH_IMG_STATUS = array();
	$array_TECH = array();
	$array_PV = array();
	$array_TP = array();
	$array_SZ = array();
	$array_TON = array();
	$array_TMM = array();
	$array_MV = array();
	$array_MVJ = array();
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
	$array_ENGN = array();
	$array_FRCTRL = array();
	$array_MP = array();
	$array_WPNS = array();

	$array_MV_MOD = array();
	$array_DMG_SHORT_MOD = array();
	$array_DMG_MEDIUM_MOD = array();
	$array_DMG_LONG_MOD = array();
	$array_FRCTRL_MOD = array();

	$array_ACTIVE_BID = array();

	// Game
	// currentround
	$sql_asc_game = "SELECT SQL_NO_CACHE * FROM asc_game where gameid = 1;";
	$result_asc_game = mysqli_query($conn, $sql_asc_game);
	if (mysqli_num_rows($result_asc_game) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_game)) {
			$CURRENTROUND = $row["currentround"];
		}
	}
	mysqli_free_result($result_asc_game);

	// Unit
	// unitid; factionid; forcename; --parentforceid--; unit_imageurl; playable
	$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM asc_unit;";
	$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
	if (mysqli_num_rows($result_asc_unit) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_unit)) {
			if ($row["unitid"] == $unitid) {
				$UNIT = $row["forcename"];
				$UNIT_IMG_URL = $row["unit_imageurl"];
				$factionid = $row["factionid"];
				$unitplayerid = $row["playerid"];
			}
		}
	}
	mysqli_free_result($result_asc_unit);

	// Faction
	// factionid; name; --factiontype--; faction_imageurl
	$sql_asc_faction = "SELECT SQL_NO_CACHE * FROM asc_faction where factionid=".$factionid.";";
	$result_asc_faction = mysqli_query($conn, $sql_asc_faction);
	if (mysqli_num_rows($result_asc_faction) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_faction)) {
			if ($row["factionid"] == $factionid) {
				$FACTION = $row["name"];
				$FACTION_IMG_URL = $row["faction_imageurl"];
			}
		}
	}
//	$UNIT_PARENTS = $FACTION_TYPE." ".$FACTION.",<br>".$UNIT_PARENTS;
	mysqli_free_result($result_asc_faction);

	// Alpha Strike Cards
	// id; unitid; mechid; pilotid
	$mechcount = 0;
	$sql_asc = "SELECT SQL_NO_CACHE * FROM asc_assign;";
	$result_asc = mysqli_query($conn, $sql_asc);
	if (mysqli_num_rows($result_asc) > 0) {
		while($row = mysqli_fetch_assoc($result_asc)) {
			if ($row["unitid"] == $unitid) {
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
							$array_MECH_NUMBER[$mechcount] = $row["mech_number"];
							$array_MECH_MODEL[$mechcount] = $clan.$row["as_model"];
							$array_MECH_IMG_URL[$mechcount] = $row["mech_imageurl"];
							$array_MECH_IMG_STATUS[$mechcount] = $row["mech_statusimageurl"];
							$array_TECH[$mechcount] = $row["tech"];
							$array_PV[$mechcount] = $row["as_pv"];
							$array_TP[$mechcount] = $row["as_tp"];
							$array_SZ[$mechcount] = $row["as_sz"];
							$array_TON[$mechcount] = $row["mech_tonnage"];
							$array_TMM[$mechcount] = $row["as_tmm"];
							$array_MV[$mechcount] = $row["as_mv"];
							$array_MVJ[$mechcount] = $row["as_mvj"];
							$array_ROLE[$mechcount] = $row["as_role"];
							$array_SKILL[$mechcount] = $row["as_skill"];
							$array_DMG_SHORT[$mechcount] = $row["as_short"];
							$array_DMG_MEDIUM[$mechcount] = $row["as_medium"];
							$array_DMG_LONG[$mechcount] = $row["as_long"];
							$array_OV[$mechcount] = $row["as_ov"];
							$array_SPCL[$mechcount] = $row["as_specials"];
							$array_A_MAX[$mechcount] = $row["as_armor"];
							$array_S_MAX[$mechcount] = $row["as_structure"];
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
							//$array_PILOT[$mechcount] = $row["rank"]." ".$row["name"];
							$array_PILOT[$mechcount] = $row["name"];
							$array_PILOT_IMG_URL[$mechcount] = $row["pilot_imageurl"];
						}
					}
				}
				mysqli_free_result($result_asc_pilot);
			}
		}
	}
	mysqli_free_result($result_asc);

	$thread_id = mysqli_thread_id($conn);
	mysqli_kill($conn, $thread_id);

	mysqli_close($conn);
	mysqli_refresh();
?>
