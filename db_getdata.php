<?php
	require('./db.php');

	$parentunitid = 0;
	$factionid = 0;
	$mechid = 0;
	$pilotid = 0;

	$FACTION = "DEFAULT";
	$FACTION_IMG_URL = "...";
	$FACTION_TYPE = "...";
	$UNIT = "DEFAULT";
	$UNIT_PARENTS = "";
	$UNIT_IMG_URL = "...";

	// Store in arrays to keep the mech- and pilotdata of the current unit
	$array_PILOT = array();
	$array_PILOT_CALLSIGN = array();
	$array_PILOT_IMG_URL = array();

	$array_MECH_DBID = array();
	$array_MECH_NUMBER = array();
	$array_MECH_CUSTOM_NAME = array();

	$array_MECH = array();
	$array_MECH_IMG_URL = array();
	$array_PV = array();
	$array_TP = array();
	$array_SZ = array();
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

	// Unit
	// unitid; factionid; forcename; parentforceid; unit_imageurl; playable
	$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM clanwolf.asc_unit;";
	$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
	if (mysqli_num_rows($result_asc_unit) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_unit)) {
			if ($row["unitid"] == $unitid) {
				$UNIT = $row["forcename"];
				$UNIT_IMG_URL = $row["unit_imageurl"];
				$parentunitid = $row["parentforceid"];
				$factionid = $row["factionid"];
			}
		}
		$UNIT_PARENTS = $UNIT;
		while($parentunitid !== "null") {
			mysqli_data_seek($result_asc_unit, 0);
			while($row = mysqli_fetch_assoc($result_asc_unit)) {
				if ($row["unitid"] == $parentunitid) {
					$name = $row["forcename"];
					$UNIT_PARENTS = $name.",<br>".$UNIT_PARENTS;
					$parentunitid = $row["parentforceid"];
				}
			}
		}
	}

	// Faction
	// factionid; name; factiontype; faction_imageurl
	$sql_asc_faction = "SELECT SQL_NO_CACHE * FROM clanwolf.asc_faction where factionid=".$factionid.";";
	$result_asc_faction = mysqli_query($conn, $sql_asc_faction);
	if (mysqli_num_rows($result_asc_faction) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_faction)) {
			if ($row["factionid"] == $factionid) {
				$FACTION = $row["name"];
				$FACTION_IMG_URL = $row["faction_imageurl"];
				$FACTION_TYPE = $row["factiontype"];
			}
		}
	}
	$UNIT_PARENTS = $FACTION_TYPE." ".$FACTION.",<br>".$UNIT_PARENTS;

	// Alpha Strike Cards
	// id; unitid; mechid; pilotid
	$mechcount = 0;
	$sql_asc = "SELECT SQL_NO_CACHE * FROM clanwolf.asc;";
	$result_asc = mysqli_query($conn, $sql_asc);
	if (mysqli_num_rows($result_asc) > 0) {
		while($row = mysqli_fetch_assoc($result_asc)) {
			if ($row["unitid"] == $unitid) {
				$mechcount++;
				// echo "<script>console.log('Mech-ID: ".$mechid."');</script>";
				// echo "<script>console.log('Pilot-ID: ".$pilotid."');</script>";
				$mechid = $row["mechid"];
				$pilotid = $row["pilotid"];

				// Mech
				// mechid; mulid; mech_tonnage; custom_name; as_name; as_model; 
				// as_pv; as_tp; as_sz; as_tmm; as_mv; as_role; as_skill;
				// as_short; as_short_min; as_medium; as_medium_min;
				// as_long; as_long_min; as_extreme; as_extreme_min; 
				// as_ov; as_armor; as_structure; as_threshold; as_specials;
				// mech_imageurl
				$sql_asc_mech = "SELECT SQL_NO_CACHE * FROM clanwolf.asc_mech where mechid=".$mechid.";";
				$result_asc_mech = mysqli_query($conn, $sql_asc_mech);
				if (mysqli_num_rows($result_asc_mech) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_mech)) {
						if ($row["mechid"] == $mechid) {
							$array_MECH_DBID[$mechcount] = $row["mechid"];
							$array_MECH_NUMBER[$mechcount] = $row["mech_number"];
							$array_MECH_CUSTOM_NAME[$mechcount] = $row["custom_name"];
							$array_MECH[$mechcount] = $row["as_name"];
							$array_MECH_MODEL[$mechcount] = $row["as_model"];
							$array_MECH_IMG_URL[$mechcount] = $row["mech_imageurl"];
							$array_PV[$mechcount] = $row["as_pv"];
							$array_TP[$mechcount] = $row["as_tp"];
							$array_SZ[$mechcount] = $row["as_sz"];
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

							// echo $array_MECH_DBID[$mechcount];
							// echo $array_MECH[$mechcount];
							// echo $array_MECH_MODEL[$mechcount];
						}
					}
				}

				// Mechstatus
				// mechstatusid; mechid; heat; armor; structure;
				// crit_engine; crit_fc; crit_mp; crit_weapons
				$sql_asc_mechstatus = "SELECT SQL_NO_CACHE * FROM clanwolf.asc_mechstatus where mechid=".$mechid.";";
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

							// echo "<script>alert(".$row["heat"].");</script>";
						}
					}
				}

				// Pilot
				// pilotid; rank; name; callsign; health;
				// pilot_imageurl
				$sql_asc_pilot = "SELECT SQL_NO_CACHE * FROM clanwolf.asc_pilot where pilotid=".$pilotid.";";
				$result_asc_pilot = mysqli_query($conn, $sql_asc_pilot);
				if (mysqli_num_rows($result_asc_pilot) > 0) {
					while($row = mysqli_fetch_assoc($result_asc_pilot)) {
						if ($row["pilotid"] == $pilotid) {
							$array_PILOT_CALLSIGN[$mechcount] = $row["callsign"];
							$array_PILOT[$mechcount] = $row["rank"]." ".$row["name"]." \"".$row["callsign"]."\"";
							$array_PILOT_IMG_URL[$mechcount] = $row["pilot_imageurl"];
						}
					}
				}
			}
		}
	}
	mysqli_close($conn);
?>
