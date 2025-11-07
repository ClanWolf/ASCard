<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();
	// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 9");
	}

	// Get data from db
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$isAdmin = $_SESSION['isAdmin'];

	function random_pic($male) {
		$dir = 'images/pilots/';
		$files = glob($dir.$male.'_*.png');
		$file = array_rand($files);
		return $files[$file];
	}
	function random_name($male) {
		$f_contents = file("data/names/names_".$male.".lst");
		$line = $f_contents[array_rand($f_contents)];
		$data = $line;
		return $data;
	}

	function getUnitImageByName($unitname, $unittype) { // BM, BA=BattleArmor, CV=CombatVehicle
		if ($unittype == "CV") {
			$image = "images/units/Generic_Tank.gif";
		} else if ($unittype == "BA") {
			$image = "images/units/Generic_Battlearmor.gif";
		} else {
			$image = "images/units/Generic_Mech.gif";
		}
		$dir = 'images/units/';
		$files = glob($dir.'*.png');
		foreach ($files as &$img) {
			$imagenametrimmed = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagename = basename(str_replace(' ', '', trim($img)));
			$unitnametrimmed = strtolower(str_replace(' ', '', trim($unitname)));
			if (strpos($unitnametrimmed, $imagenametrimmed) !== false) {
				$image = str_replace(' ', '%20', trim($img));
				break;
			}
		}
		return $image;
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedUnit = $_SESSION['option1'];
	$paramformationid = isset($_GET["formationid"]) ? $_GET["formationid"] : "";
	$paramformationname = isset($_GET["formationname"]) ? $_GET["formationname"] : "";
	$addunit = isset($_GET["am"]) ? $_GET["am"] : "";

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	if ($addunit == 1) {
		$TON = isset($_POST["TON"]) ? $_POST["TON"] : "";
		$MNU = isset($_POST["MNU"]) ? $_POST["MNU"] : "";
		$UNITNAME = isset($_POST["UNITNAME"]) ? $_POST["UNITNAME"] : "";
		$TP = isset($_POST["TP"]) ? $_POST["TP"] : "";
		$SZ = isset($_POST["SZ"]) ? $_POST["SZ"] : "";
		$TMM = isset($_POST["TMM"]) ? $_POST["TMM"] : "";
		$MVG = isset($_POST["MVG"]) ? $_POST["MVG"] : "";
		$MVJ = isset($_POST["MVJ"]) ? $_POST["MVJ"] : "";
		$ROLE = isset($_POST["ROLE"]) ? $_POST["ROLE"] : "";
		$DMGS = isset($_POST["DMGS"]) ? $_POST["DMGS"] : "";
		$DMGM = isset($_POST["DMGM"]) ? $_POST["DMGM"] : "";
		$DMGL = isset($_POST["DMGL"]) ? $_POST["DMGL"] : "";
		$OV = isset($_POST["OV"]) ? $_POST["OV"] : "";
		$A = isset($_POST["A"]) ? $_POST["A"] : "";
		$S = isset($_POST["S"]) ? $_POST["S"] : "";
		$PVA = isset($_POST["PVA"]) ? $_POST["PVA"] : "";
		$SPCL = isset($_POST["SPCL"]) ? $_POST["SPCL"] : "";
		$PN = isset($_POST["PN"]) ? $_POST["PN"] : "";
		$PI = isset($_POST["PI"]) ? $_POST["PI"] : "";
		$SKILL = isset($_POST["SKILL"]) ? $_POST["SKILL"] : "";
		$FORMATIONID = isset($_POST["FORMATIONID"]) ? $_POST["FORMATIONID"] : "";
		$MULID = isset($_POST["MULID"]) ? $_POST["MULID"] : "";
		$MODEL = isset($_POST["MODEL"]) ? $_POST["MODEL"] : "";
		$TECH = isset($_POST["TECH"]) ? $_POST["TECH"] : "";

		$MVTYPE = isset($_POST["MVTYPE"]) ? $_POST["MVTYPE"] : "";

		$RULES = isset($_POST["TECH"]) ? $_POST["TECH"] : "";
		$COST = isset($_POST["COST"]) ? $_POST["COST"] : "";
		$BV = isset($_POST["BV"]) ? $_POST["BV"] : "";
		$PV = isset($_POST["PV"]) ? $_POST["PV"] : "";
		$ERAID = isset($_POST["ERAID"]) ? $_POST["ERAID"] : "";
		$ERASTART = isset($_POST["ERASTART"]) ? $_POST["ERASTART"] : "";
		$DATEINTRO = isset($_POST["DATEINTRO"]) ? $_POST["DATEINTRO"] : "";
		$UNITCLASS = isset($_POST["UNITCLASS"]) ? $_POST["UNITCLASS"] : "";
		$UNITVARIANT = isset($_POST["UNITVARIANT"]) ? $_POST["UNITVARIANT"] : "";

		$DMGE = isset($_POST["DMGE"]) ? $_POST["DMGE"] : "";

		$TON = urldecode($TON);
		$MNU = urldecode($MNU);
		$UNITNAME = urldecode($UNITNAME);
		$TP = urldecode($TP);
		$SZ = urldecode($SZ);
		$TMM = urldecode($TMM);
		$MVG = urldecode($MVG);
		$MVJ = urldecode($MVJ);
		$ROLE = urldecode($ROLE);
		$DMGS = urldecode($DMGS);
		$DMGM = urldecode($DMGM);
		$DMGL = urldecode($DMGL);
		$OV = urldecode($OV);
		$A = urldecode($A);
		$S = urldecode($S);
		$PVA = urldecode($PVA);
		$SPCL = urldecode($SPCL);
		$PN = urldecode($PN);
		$PI = urldecode($PI);
		$SKILL = urldecode($SKILL);
		$FORMATIONID = urldecode($FORMATIONID);
		$MULID = urldecode($MULID);
		$MODEL = urldecode($MODEL);

		$UNITIMAGE = getUnitImageByName($MODEL, $TP);
		$UNITSTATUSIMAGE = "";

		if ($TECH == "1" && $TP == "BA") {
			//$TON = $TON * 4;
			//$TON = "-";
		}

		if ($TP == "BA") { // && $pos !== false) {
			// This is a BattleArmor
			$MODEL = str_replace("Elemental", "ELE", $MODEL);
			$MODEL = str_replace("Battle Armor", "BA", $MODEL);
			$MODEL = str_replace("Reconnaissance", "Rec.", $MODEL);
            $MODEL = str_replace(" [BA]", "", $MODEL);
			$UNITSTATUSIMAGE = "images/DD_BA_01.png";
		} else if($TP == "BM") { // BM
			$MODEL = str_replace("Reconnaissance", "Rec.", $MODEL);
            $MODEL = str_replace(" [BM]", "", $MODEL);
			$UNITSTATUSIMAGE = "images/DD_BM_01.png";
		} else if ($TP == "CV") { // CV -> Combat vehicle
			$MODEL = str_replace("Reconnaissance", "Rec.", $MODEL);
			$MODEL = str_replace("Vehicle", "Veh.", $MODEL);
			$MODEL = str_replace(" [CV]", "", $MODEL);
			$UNITSTATUSIMAGE = "images/DD_CV_01.png";
		} else if ($TP == "AF") { // AF -> Aerial fighter
			$MODEL = str_replace("Reconnaissance", "Rec.", $MODEL);
            $MODEL = str_replace(" [AF]", "", $MODEL);
            $UNITSTATUSIMAGE = "images/DD_CV_01.png";
		} else {
			// Anything else
			$MODEL = str_replace("Reconnaissance", "Rec.", $MODEL);
            $MODEL = str_replace(" [BA]", "", $MODEL);
            $MODEL = str_replace(" [BM]", "", $MODEL);
            $MODEL = str_replace(" [CV]", "", $MODEL);
            $MODEL = str_replace(" [AF]", "", $MODEL);
			$UNITSTATUSIMAGE = "images/DD_BM_01.png"; // Find another image here
		}

		$RULES = urldecode($RULES);
		$COST = urldecode($COST);
		$BV = urldecode($BV);
		$PV = urldecode($PV);
		$ERAID = urldecode($ERAID);
		$ERASTART = urldecode($ERASTART);
		$DATEINTRO = urldecode($DATEINTRO);
		$UNITCLASS = urldecode($UNITCLASS);
		$UNITVARIANT = urldecode($UNITVARIANT);

		$DMGE = urldecode($DMGE);

		//    UNIT
		//    ----------------
		//    unitid
		//    unit_number
		//    tech
		//    mulid
		//    unit_tonnage
		//    as_model
		//    as_pv
		//    as_tp
		//    as_sz
		//    as_tmm
		//    as_mv
		//    as_mvj
		//    as_role
		//    as_skill
		//    as_short
		//    as_short_min
		//    as_medium
		//    as_medium_min
		//    as_long
		//    as_long_min
		//    as_extreme
		//    as_extreme_min
		//    as_ov
		//    as_armor
		//    as_structure
		//    as_threshold
		//    as_specials
		//    unit_imageurl
		//
		//    PILOT
		//    ----------------
		//    pilotid
		//    name
		//    pilot_imageurl
		//    playerid
		//
		//    ASSIGN
		//    ----------------
		//    id
		//    formationid
		//    unitid
		//    pilotid

		$sql_insertunit = "";
		$sql_insertunit = $sql_insertunit."INSERT INTO asc_unit ";
		$sql_insertunit = $sql_insertunit."(unit_number, unit_name, tech, mulid, cost, battlevalue, pointvalue, rules, era_id, era_start, date_introduced, unit_class, unit_variant, unit_tonnage, as_model, as_pv, as_tp, as_sz, as_tmm, as_mv, as_mvj, as_role, as_skill, as_short, as_short_min, as_medium, as_medium_min, as_long, as_long_min, as_extreme, as_extreme_min, as_ov, as_armor, as_structure, as_threshold, as_specials, unit_imageurl, playerid, as_mvtype) ";
		$sql_insertunit = $sql_insertunit."VALUES (";
		$sql_insertunit = $sql_insertunit."'".$MNU."', ";             // unit_number
		$sql_insertunit = $sql_insertunit."'".$UNITNAME."', ";        // unit_name
		$sql_insertunit = $sql_insertunit."'".$TECH."', ";            // tech
		$sql_insertunit = $sql_insertunit."'".$MULID."', ";           // mulid

		$sql_insertunit = $sql_insertunit."".$COST.", ";              // cost
		$sql_insertunit = $sql_insertunit."".$BV.", ";                // battlevalue
		$sql_insertunit = $sql_insertunit."".$PV.", ";                // pointvalue
		$sql_insertunit = $sql_insertunit."'".$RULES."', ";           // rules
		$sql_insertunit = $sql_insertunit."".$ERAID.", ";             // eraid
		$sql_insertunit = $sql_insertunit."".$ERASTART.", ";          // erastart
		$sql_insertunit = $sql_insertunit."'".$DATEINTRO."', ";       // date_introduced
		$sql_insertunit = $sql_insertunit."'".$UNITCLASS."', ";       // unitclass
		$sql_insertunit = $sql_insertunit."'".$UNITVARIANT."', ";     // unitvariant

		$sql_insertunit = $sql_insertunit."'".$TON."', ";             // unit_tonnage
		$sql_insertunit = $sql_insertunit."'".$MODEL."', ";           // as_model
		$sql_insertunit = $sql_insertunit."'".$PVA."', ";             // as_pv
		$sql_insertunit = $sql_insertunit."'".$TP."', ";              // as_tp
		$sql_insertunit = $sql_insertunit."'".$SZ."', ";              // as_sz
		$sql_insertunit = $sql_insertunit."'".$TMM."', ";             // as_tmm
		$sql_insertunit = $sql_insertunit."'".$MVG."', ";             // as_mv
		if ($MVJ == 0) {
			$sql_insertunit = $sql_insertunit."null, ";               // as_mvj
		} else {
			$sql_insertunit = $sql_insertunit."'".$MVJ."', ";         // as_mvj
		}
		$sql_insertunit = $sql_insertunit."'".$ROLE."', ";            // as_role
		$sql_insertunit = $sql_insertunit."'".$SKILL."', ";           // as_skill
		$sql_insertunit = $sql_insertunit."'".$DMGS."', ";            // as_short
		$sql_insertunit = $sql_insertunit."0, ";                      // as_short_min
		$sql_insertunit = $sql_insertunit."'".$DMGM."', ";            // as_medium
		$sql_insertunit = $sql_insertunit."0, ";                      // as_medium_min
		$sql_insertunit = $sql_insertunit."'".$DMGL."', ";            // as_long
		$sql_insertunit = $sql_insertunit."0, ";                      // as_long_min
		$sql_insertunit = $sql_insertunit."0, ";                      // as_extreme
		$sql_insertunit = $sql_insertunit."0, ";                      // as_extreme_min
		$sql_insertunit = $sql_insertunit."'".$OV."', ";              // as_ov
		$sql_insertunit = $sql_insertunit."'".$A."', ";               // as_armor
		$sql_insertunit = $sql_insertunit."'".$S."', ";               // as_structure
		$sql_insertunit = $sql_insertunit."0, ";                      // as_threshold
		$sql_insertunit = $sql_insertunit."'".$SPCL."', ";            // as_specials
		$sql_insertunit = $sql_insertunit."'".$UNITIMAGE."', ";       // unit_imageurl
//		$sql_insertunit = $sql_insertunit."'".$UNITSTATUSIMAGE."', "; // unit_statusimageurl

		$sql_insertunit = $sql_insertunit."'".$pid."', ";             // playerid
		$sql_insertunit = $sql_insertunit."'".$MVTYPE."'";            // as_mvtype h = hover, w = wheeled, t = tracked

		$sql_insertunit = $sql_insertunit.")";

		if (mysqli_query($conn, $sql_insertunit)) {
			// Success
			$newunitid = mysqli_insert_id($conn);
		} else {
			// Error
			echo "Error: " . $sql_insertunit . "<br>" . mysqli_error($conn);
		}

		$sql_insertpilot = "";
		$sql_insertpilot = $sql_insertpilot."INSERT INTO asc_pilot ";
		$sql_insertpilot = $sql_insertpilot."(name, rank, pilot_imageurl, playerid) ";
		$sql_insertpilot = $sql_insertpilot."VALUES (";
		$sql_insertpilot = $sql_insertpilot."'".$PN."',";      // Pilotname
		$sql_insertpilot = $sql_insertpilot."'MW',";           // Default rank
		$sql_insertpilot = $sql_insertpilot."'".$PI."',";      // Pilot image
		$sql_insertpilot = $sql_insertpilot."".$pid."";        // Player id
		$sql_insertpilot = $sql_insertpilot.")";
		if (mysqli_query($conn, $sql_insertpilot)) {
			// Success
			$newpilotid = mysqli_insert_id($conn);
		} else {
			// Error
			echo "Error: " . $sql_insertpilot . "<br>" . mysqli_error($conn);
		}

		$sql_insertassign = "";
		$sql_insertassign = $sql_insertassign."INSERT INTO asc_assign ";
		$sql_insertassign = $sql_insertassign."(formationid, unitid, pilotid, playerid) ";
		$sql_insertassign = $sql_insertassign."VALUES (";
		$sql_insertassign = $sql_insertassign.$FORMATIONID.",";
		$sql_insertassign = $sql_insertassign.$newunitid.",";
		$sql_insertassign = $sql_insertassign.$newpilotid.",";
		$sql_insertassign = $sql_insertassign.$pid;
		$sql_insertassign = $sql_insertassign.")";
		if (mysqli_query($conn, $sql_insertassign)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertassign . "<br>" . mysqli_error($conn);
		}

		$sql_insertunitstatus = "";
		$sql_insertunitstatus = $sql_insertunitstatus."INSERT INTO asc_unitstatus ";
		$sql_insertunitstatus = $sql_insertunitstatus."(unitid, playerid, gameid, round, heat, armor, structure, crit_engine, crit_fc, crit_mp, crit_weapons, unit_statusimageurl, initial_status) ";
		$sql_insertunitstatus = $sql_insertunitstatus."VALUES (";
		$sql_insertunitstatus = $sql_insertunitstatus.$newunitid.",";
		$sql_insertunitstatus = $sql_insertunitstatus.$pid.",";
		$sql_insertunitstatus = $sql_insertunitstatus.$gid.",";
		$sql_insertunitstatus = $sql_insertunitstatus.$CURRENTROUND.",";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
		$sql_insertunitstatus = $sql_insertunitstatus."0, ";
//		$sql_insertunitstatus = $sql_insertunitstatus."'".$UNITIMAGE."', ";        // unit_imageurl
		$sql_insertunitstatus = $sql_insertunitstatus."'".$UNITSTATUSIMAGE."', ";  // unit_statusimageurl
		$sql_insertunitstatus = $sql_insertunitstatus."1 ";
		$sql_insertunitstatus = $sql_insertunitstatus.")";
		if (mysqli_query($conn, $sql_insertunitstatus)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertunitstatus . "<br>" . mysqli_error($conn);
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php?activebid=1&unitid=" . $newunitid . "'>";
	}
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Unit creator</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="ASCard">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

	<link rel="manifest" href="/app/ascard.webmanifest">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/editorstyles.css">
	<link rel="icon" type="image/png" href="/app/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/app/favicon.svg" />
	<link rel="shortcut icon" href="/app/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/app/apple-touch-icon.png" />

	<!-- https://www.npmjs.com/package/passive-events-support?activeTab=readme -->
	<script>
		window.passiveSupport = {
			debug: false,
			events: ['touchstart', 'touchmove', 'wheel'],
			listeners: [
				{
					element: '.jspContainer',
					event: 'touchstart',
					prevented: true
				},
				{
					element: '.jspContainer',
					event: 'touchmove',
					prevented: true
				},
				{
					element: '.jspContainer',
					event: 'wheel',
					prevented: true
				}
			]
		}
	</script>
	<script type="text/javascript" src="./scripts/passive-events-support/main.js"></script>

	<script type="text/javascript" src="./scripts/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="./scripts/basic.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/masterunitlist.js"></script>
	<script type="text/javascript" src="./scripts/adjustPointValue.js"></script>


	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
	</style>
</head>

<body>
	<script>

	function postRedirect(url, data) {
		const form = document.createElement('form');
		form.method = 'POST';
		form.action = url;
	
		for (const key in data) {
			if (data.hasOwnProperty(key)) {
				const input = document.createElement('input');
				input.type = 'hidden';
				input.name = key;
				input.value = data[key];
				form.appendChild(input);
			}
		}
	
		document.body.appendChild(form);
		form.submit();
		}

		
<?php
	$randomPilotPictureMale = random_pic("m");
	$randomPilotPictureFemale = random_pic("f");
	$randomPilotNameMale = random_name("male");
	$randomPilotNameFemale = random_name("female");
	echo "		var randomPilotPictureFemale='".trim($randomPilotPictureFemale)."';\n";
	echo "		var randomPilotNameFemale='".trim($randomPilotNameFemale)."';\n";
	echo "		var randomPilotPictureMale='".trim($randomPilotPictureMale)."';\n";
	echo "		var randomPilotNameMale='".trim($randomPilotNameMale)."';\n\n";
?>
		$(document).ready(function() {
			$("#cover").hide();
			fetchUnitList();
			document.getElementById("units").selectedIndex = "1";
		});

		function storeNewCommand() {
			// Store new command
			alert("Not yet implemented!");
		}

		function storeNewUnit() {
			// Store new unit
			var TON = document.getElementById("F_TON").value;
			var TECH = document.getElementById("TECH").value;
			//var TON = document.getElementById('tonnage').value;
			var MNU = document.getElementById('MNU').value;
			var UNITNAME = document.getElementById('UNITNAME').value;
			UNITNAME = UNITNAME.replace(/"/g,"&quot;");
			UNITNAME = UNITNAME.replace(/'/g,"&apos;");
			var TP = document.getElementById('TP').value;
			var SZ = document.getElementById('SZ').value;
			var TMM = document.getElementById('TMM').value;
			var MV = document.getElementById('MV').value;
			var ROLE = document.getElementById('ROLE').value;
			var DMGS = document.getElementById('DMGS').value;
			var DMGM = document.getElementById('DMGM').value;
			var DMGL = document.getElementById('DMGL').value;
			var OV = document.getElementById('OV').value;
			var A = document.getElementById('A').value;
			var S = document.getElementById('S').value;
			var PVA = document.getElementById('PVA').value;
			var SPCL = document.getElementById('SPCL').value;
			var PN = document.getElementById('PN').value;
			var PI = finalPilotImage;
			var SKILL = document.getElementById('SKILL').value;
			var FORMATIONID = document.getElementById('FORMATIONID').value;

			var adjustedPV = adjustPointValue(PVA, SKILL);

			var unitslistbox = document.getElementById("units");
			var selIndex = unitslistbox.selectedIndex;
			var selValue = unitslistbox.options[selIndex].value;
			var selText = unitslistbox.options[selIndex].text;
			var MULID = selValue;
			var MODEL = selText;
			MODEL = MODEL.replace(/"/g,"&quot;");
			MODEL = MODEL.replace(/'/g,"&apos;");

			var RULES = document.getElementById("RULES").value;
			var COST = document.getElementById("COST").value;
			var BV = document.getElementById("BV").value;
			var PV = document.getElementById("PV").value;
			var ERAID = document.getElementById("ERAID").value;
			var ERASTART = document.getElementById("ERASTART").value;
			var DATEINTRO = document.getElementById("DATEINTRO").value;
			var UNITCLASS = document.getElementById("UNITCLASS").value;
			UNITCLASS = UNITCLASS.replace(/"/g,"&quot;");
			UNITCLASS = UNITCLASS.replace(/'/g,"&apos;");

			var UNITVARIANT = document.getElementById("UNITVARIANT").value;

			var DMGE = document.getElementById("DMGE").value;

			if (UNITNAME != "") {
//				const regExp = /(?<=\().*?(?=\))/g;
//				UNTINAME = UNITNAME.match(regExp);
//				console.log(UNITNAME.trim());
				UNITNAME = UNITNAME.length > 53 ? UNITNAME.substring(0, 50) + "..." : UNITNAME.substring(0, UNITNAME.length);
			}

			if ("<<< Select unit >>>" == MODEL) {
				alert("Select a Unit!");
				return;
			}

			var MVG = 0;
			var MVJ = 0;
			var MVType = '';

			if (MV.indexOf("w") !== -1) {
				MVType = 'w';
			} else if (MV.indexOf("t") !== -1) {
				MVType = 't';
			} else if (MV.indexOf("h") !== -1) {
				MVType = 'h';
			}

			if (MV.indexOf("/") !== -1) {
				var MV_Parts = MV.split('/');
				MVG = MV_Parts[0].match(/\d+/)[0];
				MVJ = MV_Parts[1].match(/\d+/)[0];
			} else if (MV.indexOf("j") !== -1) {
				MVG = MV.match(/\d+/)[0];
				MVJ = MV.match(/\d+/)[0];
			} else {
				MVG = MV.match(/\d+/)[0];
				MVJ = 0;
			}
			const unitData = {
				TON:TON,
				MNU:MNU,
				UNITNAME:UNITNAME,
				TP:TP,
				SZ:SZ,
				TMM:TMM,
				MVG:MVG,
				MVJ:MVJ,
				ROLE:ROLE,
				DMGS:DMGS,
				DMGM:DMGM,
				DMGL:DMGL,
				OV:OV,
				A:A,
				S:S,
				PVA:adjustedPV,
				SPCL:SPCL,
				PN:PN,
				PI:PI,
				SKILL:SKILL,
				MULID:MULID,
				MODEL:MODEL,
				FORMATIONID:FORMATIONID,
				TECH:TECH,
				MVTYPE:MVType,
	
				RULES:RULES,
				COST:COST,
				BV:BV,
				PV:PV,
				ERAID:ERAID,
				ERASTART:ERASTART,
				DATEINTRO:DATEINTRO,
				UNITCLASS:UNITCLASS,
				UNITVARIANT:UNITVARIANT,
				DMGE:DMGE
		    };

			// alert(url);
			postRedirect(`./gui_create_unit.php?am=1&formationid=${encodeURIComponent(FORMATIONID)}`, unitData);
		}
	</script>

	<div id="cover"></div>

<?php
	if ($playMode) {
		$buttonWidth = "33.3%"; // 3 columns in the middle
	} else {
		if ($isAdmin) {
			$buttonWidth = "17%"; // 6 columns
		} else {
			$buttonWidth = "25%"; // 4 columns
		}
	}
?>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" style="width: 80px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td nowrap onclick="location.href='./gui_edit_game.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_select_unit.php'>ROSTER</a></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth." class='menu_button_active'><a href='./gui_create_unit.php'>CREATE</a></td><td style='width:5px;'>&nbsp;</td>\n";
		//echo "				<td nowrap onclick=\"location.href='./gui_edit_game.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_edit_game.php'>GAME</a></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_player.php'>PLAYER</a></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_admin.php'>ADMIN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>
				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
			<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="off">
		<table width="80%" class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td nowrap width="1%" class="datalabel" style='text-align:left;' colspan='1'>
					Create new command:&nbsp;&nbsp;&nbsp;
				</td>
				<td nowrap width="99%" class="datalabel" style='text-align:left;' colspan='1'>
					<input required style='width:100%;' type="text" id="NewCommandName" name="NewCommandName">
				</td>
				<td nowrap width="1%" align="right">
					<a href='#' onClick='storeNewCommand();'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-plus-square'></i></a>
				</td>
			</tr>
		</table>

		<br>

		<table width="80%" class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Tech:
				</td>
				<td width="20%" nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<select required name='tech' style='width:100%;' id='tech' size='1'>
						<option value="2">Clan</option>
						<option value="1">IS</option>
						<!-- <option value="3">MIXED</option> -->
					</select>
				</td>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
                    Type:
                </td>
				<td width="20%" nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<select required style='width:100%;' name='unittype' id='unittype' size='1'>
						<option value="BA">BA</option>
						<option value="BM" selected="selected">BM</option>
						<option value="CV">CV</option>
						<!-- <option value="AF">AF</option> -->
					</select>
				</td>
				<td width="5%" nowrap id='weightLabel'class="datalabel" style='text-align:right;' colspan='1'>
                    Weight:
                </td>
				<td width="20%" id='weightBlock' nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<select required style='width:100%;' name='tonnage' id='tonnage' size='1'>
						<option value="LIGHT">LIGHT</option>
						<option value="MEDIUM">MEDIUM</option>
						<option value="HEAVY" selected="selected">HEAVY</option>
						<option value="ASSAULT">ASSAULT</option>
						<option value="SUPERHEAVY">SUPERHEAVY</option>

						<!-- <option value="BA">BA</option> -->
						<!-- <option value="ALL">ALL</option> -->
						<!-- <option value="0-2">0-2</option> -->
						<!-- <option value="20">20</option> -->
						<!-- <option value="25">25</option> -->
						<!-- <option value="30">30</option> -->
						<!-- <option value="35">35</option> -->
						<!-- <option value="40">40</option> -->
						<!-- <option value="45">45</option> -->
						<!-- <option value="50">50</option> -->
						<!-- <option value="55">55</option> -->
						<!-- <option value="60">60</option> -->
						<!-- <option value="65">65</option> -->
						<!-- <option value="70">70</option> -->
						<!-- <option value="75">75</option> -->
						<!-- <option value="80">80</option> -->
						<!-- <option value="85">85</option> -->
						<!-- <option value="90">90</option> -->
						<!-- <option value="95">95</option> -->
						<!-- <option value="100">100</option> -->
						<!-- <option value="105">105</option> -->
						<!-- <option value="110">110</option> -->
						<!-- <option value="115">115</option> -->
						<!-- <option value="120">120</option> -->
						<!-- <option value="125">125</option> -->
						<!-- <option value="130">130</option> -->
						<!-- <option value="135">135</option> -->
						<!-- <option value="140">140</option> -->
						<!-- <option value="145">145</option> -->
						<!-- <option value="150">150</option> -->
						<!-- <option value="155">155</option> -->
						<!-- <option value="160">160</option> -->
						<!-- <option value="165">165</option> -->
						<!-- <option value="170">170</option> -->
						<!-- <option value="175">175</option> -->
						<!-- <option value="180">180</option> -->
						<!-- <option value="185">185</option> -->
						<!-- <option value="190">190</option> -->
						<!-- <option value="195">195</option> -->
						<!-- <option value="200">200</option> -->
					</select>
				</td>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Filter:
				</td>
				<td width="20%" nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<input required style='width:100%;' type="text" id="NameFilter" name="NameFilter">
				</td>
				<td nowrap class="datalabel" style='text-align:left;vertical-align:bottom;' valign="bottom" colspan='1' rowspan="7">
					<a href='#' onClick='storeNewUnit();'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-plus-square'></i></a>
				</td>
			</tr>
			<tr>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Era:
				</td>
				<td width="95%" nowrap class="datalabel" style='text-align:left;' colspan='7'>
					<select required style='width:100%;' name='CreateUnitEra' id='CreateUnitEra' size='1'>
						<option value="0">ALL</option>
						<option value="9">2005-2570: AGE OF WAR</option>                             <!-- ID:   9 -->
						<option value="10">2571-2780: STAR LEAGUE</option>                           <!-- ID:  10 -->
						<option value="11">2781-2900: EARLY SUCCESSION WARS</option>                 <!-- ID:  11 -->
						<option value="255">2901-3019: LATE SUCCESSION WARS - LOSTECH</option>       <!-- ID: 255 -->
						<option value="256">3020-3049: LATE SUCCESSION WARS - RENAISSANCE</option>   <!-- ID: 256 -->
						<option value="13">3050-3061: CLAN INVASION</option>                         <!-- ID:  13 -->
						<option value="247">3062-3067: CIVIL WAR</option>                            <!-- ID: 247 -->
						<option value="14">3068-3080: JIHAD</option>                                 <!-- ID:  14 -->
						<option value="15">3081-3100: EARLY REPUBLIC</option>                        <!-- ID:  15 -->
						<option value="254">3101-3130: LATE REPUBLIC</option>                        <!-- ID: 254 -->
						<option value="16">3131-3150: DARK AGE</option>                              <!-- ID:  16 -->
						<option value="257">3151-9999: ILCLAN</option>                               <!-- ID: 257 -->
					</select>
				</td>
			</tr>
			<tr>
				<td width="5%" nowrap class="datalabel" style='text-align:left;' colspan='1'>
				</td>
				<td width="95%" nowrap class="datalabel" style='text-align:left;' colspan='7'>
					<br>
					<!-- will be filled by 'fetchUnitList();' -->
					<select required name='units' id='units' size='1' onchange="unitSelected();" style="width:100%"></select>
				</td>
			</tr>
			<tr>
				<td width="100%" nowrap class="datalabel" style='text-align:left;' colspan='8'>
					<hr>
					<input required type="hidden" id="TP" name="TP">
					<input required type="hidden" id="SZ" name="SZ">
					<input required type="hidden" id="TMM" name="TMM">
					<input required type="hidden" id="MV" name="MV">
					<input required type="hidden" id="ROLE" name="ROLE">
					<input required type="hidden" id="DMGS" name="DMGS">
					<input required type="hidden" id="DMGM" name="DMGM">
					<input required type="hidden" id="DMGL" name="DMGL">
					<input required type="hidden" id="OV" name="OV">
					<input required type="hidden" id="A" name="A">
					<input required type="hidden" id="S" name="S">
					<input required type="hidden" id="PVA" name="PVA">
					<input required type="hidden" id="SPCL" name="SPCL">
					<input required type="hidden" id="PI" name="PI">
					<input required type="hidden" id="F_TON" name="F_TON">
					<input required type="hidden" id="TECH" name="TECH">

					<input required type="hidden" id="RULES" name="RULES">
					<input required type="hidden" id="COST" name="COST">
					<input required type="hidden" id="BV" name="BV">
					<input required type="hidden" id="PV" name="PV">
					<input required type="hidden" id="ERAID" name="ERAID">
					<input required type="hidden" id="ERASTART" name="ERASTART">
					<input required type="hidden" id="DATEINTRO" name="DATEINTRO">
					<input required type="hidden" id="UNITCLASS" name="UNITCLASS">
					<input required type="hidden" id="UNITVARIANT" name="UNITVARIANT">
					<input required type="hidden" id="DMGE" name="DMGE">
				</td>
			</tr>
			<tr>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1' colspan='1'>
					#:
				</td>
				<td nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<input required type="text" id="MNU" name="MNU" style='width:100%;'>
				</td>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Pilot:
				</td>
				<td nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<input type="text" required id="PN" name="PN" style='width:100%;'>
				</td>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Skill:
				</td>
				<td nowrap class="datalabel" style='text-align:left;' colspan='1'>
					<select required name='SKILL' id='SKILL' size='1' onchange='unitdetailsChanged();' style="width:100%;">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3" selected>3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
					</select>
				</td>
				<td width="5%" nowrap class="datalabel" style='text-align:right;' rowspan="3" colspan='1'>
					<a href='#' onClick='createPilot();'><i class="fas fa-redo"></i></a>
				</td>
				<td width="20%" nowrap class="datalabel" style='text-align:left;' rowspan="3" colspan='1'>
					<img id="newpilotimage" src="" height="100px" width="100px" style="height:auto;">
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:right;' colspan='1'>
					Assign to:
				</td>
				<td nowrap class="datalabel" style='text-align:left;' colspan='5'>
					<select required name='FORMATIONID' id='FORMATIONID' size='1' style='width:100%;' onchange='unitdetailsChanged();'>
<?php
	$sql_asc_playersformations = "SELECT SQL_NO_CACHE * FROM asc_formation where playerid=".$pid;
	$result_asc_playersformations = mysqli_query($conn, $sql_asc_playersformations);
	if (mysqli_num_rows($result_asc_playersformations) > 0) {
		while($rowFormations = mysqli_fetch_assoc($result_asc_playersformations)) {
			$formationid = $rowFormations['formationid'];
			//$formationname = $rowFormations['formationname'];
			$formationname = $rowFormations['formationshort'];
			if ($paramformationid == $formationid) {
				echo "										<option value='".$formationid."' selected>".$formationname."</option>\n";
			} else {
				echo "										<option value='".$formationid."'>".$formationname."</option>\n";
			}
		}
	}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="5%" nowrap colspan="1" class="datalabel" style='text-align:right;'>
					Unitname:
				</td>
				<td nowrap colspan="4" class="datalabel" style='text-align:left;'>
					<input required type="text" id="UNITNAME" name="UNITNAME" style='width:100%;'>
				</td>
				<td width="20%" nowrap colspan="1" class="datalabel" style='text-align:left;'>(max. 30)<a href="javascript:switchNameProposal();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-shuffle"></i></a></td>
			</tr>
		</table>
	</form>

	<script>
		let filterTech = getCookie("UnitFilter_Tech");
		let filterType = getCookie("UnitFilter_Type");
		let filterWeight = getCookie("UnitFilter_Weight");
		let filterString = getCookie("UnitFilter_String");
		let filterEra = getCookie("UnitFilter_Era");
		let filterFormation = getCookie("UnitFilter_Formation");
		let filterSkill = getCookie("UnitFilter_Skill");

		if (filterTech != undefined && filterTech != "") {
			document.getElementById("tech").value = filterTech;
		}
		if (filterType != undefined && filterType != "") {
			document.getElementById("unittype").value = filterType;
		}
		if (filterWeight != undefined && filterWeight != "") {
			document.getElementById("tonnage").value = filterWeight;
		}
		if (filterString != undefined && filterString != "") {
			document.getElementById("NameFilter").value = filterString;
		}
		if (filterEra != undefined && filterEra != "") {
			document.getElementById("CreateUnitEra").value = filterEra;
		}
		if (filterFormation != undefined && filterFormation != "") {
			document.getElementById("FORMATIONID").value = filterFormation;
		}
		if (filterSkill != undefined && filterSkill != "") {
			document.getElementById("SKILL").value = filterSkill;
		}

		document.getElementById("tech").setAttribute("onchange", "fetchUnitList();");
		document.getElementById("unittype").setAttribute("onchange", "fetchUnitList();");
		document.getElementById("tonnage").setAttribute("onchange", "fetchUnitList();");
		document.getElementById("NameFilter").setAttribute("onchange", "fetchUnitList();");
		document.getElementById("CreateUnitEra").setAttribute("onchange", "fetchUnitList();");

		var finalPilotName = "";
		var finalPilotImage = "";

		function createPilot() {
			$.get("random_pic_female.php", function(data) {
				randomPilotPictureFemale = data;
//				console.log(randomPilotPictureFemale);
			});
			$.get("random_pic_male.php", function(data) {
				randomPilotPictureMale = data;
//				console.log(randomPilotPictureMale);
			});
			$.get("random_name_female.php", function(data) {
				randomPilotNameFemale = data;
//				console.log(randomPilotNameFemale);
			});
			$.get("random_name_male.php", function(data) {
				randomPilotNameMale = data;
//				console.log(randomPilotNameMale);
			});

			var male = Math.random() >= 0.3;
			if (male) {
				document.getElementById('PN').value = randomPilotNameMale;
				document.getElementById('newpilotimage').src = randomPilotPictureMale;
				finalPilotName = randomPilotNameMale;
				finalPilotImage = randomPilotPictureMale;
			} else {
				document.getElementById('PN').value = randomPilotNameFemale;
				document.getElementById('newpilotimage').src = randomPilotPictureFemale;
				finalPilotName = randomPilotNameFemale;
				finalPilotImage = randomPilotPictureFemale;
			}
		}
		createPilot();
	</script>
</body>

</html>
