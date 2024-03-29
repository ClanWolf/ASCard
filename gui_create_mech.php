<?php
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

	// Get data on units from db
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

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
//	function getMechImageByName($mechname) {
//		$image = "Generic.png";
//		$dir = 'images/mechs/';
//		$files = glob($dir.'*.png');
//		foreach ($files as &$img) {
//			$imagenametrimmed = str_replace(' ', '', trim($img));
//			$mechnametrimmed = str_replace(' ', '', trim($mechname));
//			if (strpos(strtolower($mechnametrimmed), strtolower($imagenametrimmed)) !== false) {
//				$image = $imagenametrimmed;
//				break;
//			}
//		}
//		return $image;
//	}
	function getMechImageByName($mechname) {
//		$image = "images/mechs/Generic.png";
		$image = "images/mechs/Generic.gif";
		$dir = 'images/mechs/';
		$files = glob($dir.'*.png');
		foreach ($files as &$img) {
			$imagenametrimmed = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagename = basename(str_replace(' ', '', trim($img)));
			$mechnametrimmed = strtolower(str_replace(' ', '', trim($mechname)));
			if (strpos($mechnametrimmed, $imagenametrimmed) !== false) {
				$image = str_replace(' ', '%20', trim($img));
				break;
			}
		}
		return $image;
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];
	$paramunitid = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
	$paramunitname = isset($_GET["unitname"]) ? $_GET["unitname"] : "";
	$addmech = isset($_GET["am"]) ? $_GET["am"] : "";

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	if ($addmech == 1) {
		$TON = isset($_GET["TON"]) ? $_GET["TON"] : "";
		$MNU = isset($_GET["MNU"]) ? $_GET["MNU"] : "";
		$TP = isset($_GET["TP"]) ? $_GET["TP"] : "";
		$SZ = isset($_GET["SZ"]) ? $_GET["SZ"] : "";
		$TMM = isset($_GET["TMM"]) ? $_GET["TMM"] : "";
		$MVG = isset($_GET["MVG"]) ? $_GET["MVG"] : "";
		$MVJ = isset($_GET["MVJ"]) ? $_GET["MVJ"] : "";
		$ROLE = isset($_GET["ROLE"]) ? $_GET["ROLE"] : "";
		$DMGS = isset($_GET["DMGS"]) ? $_GET["DMGS"] : "";
		$DMGM = isset($_GET["DMGM"]) ? $_GET["DMGM"] : "";
		$DMGL = isset($_GET["DMGL"]) ? $_GET["DMGL"] : "";
		$OV = isset($_GET["OV"]) ? $_GET["OV"] : "";
		$A = isset($_GET["A"]) ? $_GET["A"] : "";
		$S = isset($_GET["S"]) ? $_GET["S"] : "";
		$PVA = isset($_GET["PVA"]) ? $_GET["PVA"] : "";
		$SPCL = isset($_GET["SPCL"]) ? $_GET["SPCL"] : "";
		$PN = isset($_GET["PN"]) ? $_GET["PN"] : "";
		$PI = isset($_GET["PI"]) ? $_GET["PI"] : "";
		$SKILL = isset($_GET["SKILL"]) ? $_GET["SKILL"] : "";
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";
		$MULID = isset($_GET["MULID"]) ? $_GET["MULID"] : "";
		$MODEL = isset($_GET["MODEL"]) ? $_GET["MODEL"] : "";
		$TECH = isset($_GET["TECH"]) ? $_GET["TECH"] : "";

		$TON = urldecode($TON);
		$MNU = urldecode($MNU);
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
		$UNITID = urldecode($UNITID);
		$MULID = urldecode($MULID);
		$MODEL = urldecode($MODEL);

		$MECHIMAGE = getMechImageByName($MODEL);
		$MECHSTATUSIMAGE = "";

		if ($TECH == "1" && $TP == "BA") {
			//$TON = $TON * 4;
			//$TON = "-";
		}

		// Corrections for Clan Battle Armor (unit size / Name)
		// $pos = strpos($SPCL, "CAR4");
		if ($TECH == "2" && $TP == "BA") { // && $pos !== false) {
			// This is a Clan Battle Armor
			// Add Armor +1, PV +3 and replace CAR4 by CAR5 (in SPCL)
			// This is because MUL delivers the data for a 4 point unit (as Clan we want a SQUAD5 unit)
			// --> this is obsolete since MUL added all squad sizes!
			//$SPCL = str_replace("CAR4", "CAR5", $SPCL);
			$MODEL = str_replace("Elemental", "ELE", $MODEL);
			$MODEL = str_replace("Battle Armor", "BA", $MODEL);

			//$A = intval($A) + 1;
			//$PVA = intval($PVA) + 3;
			//$TON = $TON * 5;
			//$TON = "-";

			$MECHSTATUSIMAGE = "images/DD_ELE_01.png";
		} else {
			// This is anything else
			$MECHSTATUSIMAGE = "images/DD_01.png";
		}

		//    MECH
		//    ----------------
		//    mechid
		//    mech_number
		//    tech
		//    mulid
		//    mech_tonnage
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
		//    mech_imageurl
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
		//    unitid
		//    mechid
		//    pilotid

		$sql_insertmech = "";
		$sql_insertmech = $sql_insertmech."INSERT INTO asc_mech ";
		$sql_insertmech = $sql_insertmech."(mech_number, tech, mulid, mech_tonnage, as_model, as_pv, as_tp, as_sz, as_tmm, as_mv, as_mvj, as_role, as_skill, as_short, as_short_min, as_medium, as_medium_min, as_long, as_long_min, as_extreme, as_extreme_min, as_ov, as_armor, as_structure, as_threshold, as_specials, mech_imageurl, mech_statusimageurl) ";
		$sql_insertmech = $sql_insertmech."VALUES (";
		$sql_insertmech = $sql_insertmech."'".$MNU."', ";           // mech_number
		$sql_insertmech = $sql_insertmech."'".$TECH."', ";          // tech
		$sql_insertmech = $sql_insertmech."'".$MULID."', ";         // mulid
		$sql_insertmech = $sql_insertmech."'".$TON."', ";           // mech_tonnage
		$sql_insertmech = $sql_insertmech."'".$MODEL."', ";         // as_model
		$sql_insertmech = $sql_insertmech."'".$PVA."', ";           // as_pv
		$sql_insertmech = $sql_insertmech."'".$TP."', ";            // as_tp
		$sql_insertmech = $sql_insertmech."'".$SZ."', ";            // as_sz
		$sql_insertmech = $sql_insertmech."'".$TMM."', ";           // as_tmm
		$sql_insertmech = $sql_insertmech."'".$MVG."', ";           // as_mv
		if ($MVJ == 0) {
			$sql_insertmech = $sql_insertmech."null, ";             // as_mvj
		} else {
			$sql_insertmech = $sql_insertmech."'".$MVJ."', ";       // as_mvj
		}
		$sql_insertmech = $sql_insertmech."'".$ROLE."', ";          // as_role
		$sql_insertmech = $sql_insertmech."'".$SKILL."', ";         // as_skill
		$sql_insertmech = $sql_insertmech."'".$DMGS."', ";          // as_short
		$sql_insertmech = $sql_insertmech."0, ";                    // as_short_min
		$sql_insertmech = $sql_insertmech."'".$DMGM."', ";          // as_medium
		$sql_insertmech = $sql_insertmech."0, ";                    // as_medium_min
		$sql_insertmech = $sql_insertmech."'".$DMGL."', ";          // as_long
		$sql_insertmech = $sql_insertmech."0, ";                    // as_long_min
		$sql_insertmech = $sql_insertmech."0, ";                    // as_extreme
		$sql_insertmech = $sql_insertmech."0, ";                    // as_extreme_min
		$sql_insertmech = $sql_insertmech."'".$OV."', ";            // as_ov
		$sql_insertmech = $sql_insertmech."'".$A."', ";             // as_armor
		$sql_insertmech = $sql_insertmech."'".$S."', ";             // as_structure
		$sql_insertmech = $sql_insertmech."0, ";                    // as_threshold
		$sql_insertmech = $sql_insertmech."'".$SPCL."', ";          // as_specials
		$sql_insertmech = $sql_insertmech."'".$MECHIMAGE."', ";     // mech_imageurl
		$sql_insertmech = $sql_insertmech."'".$MECHSTATUSIMAGE."'"; // mech_statusimageurl
		$sql_insertmech = $sql_insertmech.")";
		if (mysqli_query($conn, $sql_insertmech)) {
			// Success
			$newmechid = mysqli_insert_id($conn);
		} else {
			// Error
			echo "Error: " . $sql_insertmech . "<br>" . mysqli_error($conn);
		}

		$sql_insertpilot = "";
		$sql_insertpilot = $sql_insertpilot."INSERT INTO asc_pilot ";
		$sql_insertpilot = $sql_insertpilot."(name, pilot_imageurl) ";
		$sql_insertpilot = $sql_insertpilot."VALUES (";
		$sql_insertpilot = $sql_insertpilot."'".$PN."', ";      // Pilotname
		$sql_insertpilot = $sql_insertpilot."'".$PI."'";        // Pilot image
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
		$sql_insertassign = $sql_insertassign."(unitid, mechid, pilotid) ";
		$sql_insertassign = $sql_insertassign."VALUES (";
		$sql_insertassign = $sql_insertassign.$UNITID.", ";
		$sql_insertassign = $sql_insertassign.$newmechid.", ";
		$sql_insertassign = $sql_insertassign.$newpilotid;
		$sql_insertassign = $sql_insertassign.")";
		if (mysqli_query($conn, $sql_insertassign)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertassign . "<br>" . mysqli_error($conn);
		}

		$sql_insertmechstatus = "";
		$sql_insertmechstatus = $sql_insertmechstatus."INSERT INTO asc_mechstatus ";
		$sql_insertmechstatus = $sql_insertmechstatus."(mechid, heat, armor, structure, crit_engine, crit_fc, crit_mp, crit_weapons) ";
		$sql_insertmechstatus = $sql_insertmechstatus."VALUES (";
		$sql_insertmechstatus = $sql_insertmechstatus.$newmechid.", ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0";
		$sql_insertmechstatus = $sql_insertmechstatus.")";
		if (mysqli_query($conn, $sql_insertmechstatus)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertmechstatus . "<br>" . mysqli_error($conn);
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php?activebid=1&mechid=" . $newmechid . "'>";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit creator</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75, user-scalable=no" />

	<link rel="manifest" href="./manifest.json">
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="icon" href="./favicon.png" type="image/png">
	<link rel="shortcut icon" href="./images/icon_196x196.png" type="image/png" sizes="196x196">
	<link rel="apple-touch-icon" href="./images/icon_57x57.png" type="image/png" sizes="57x57">
	<link rel="apple-touch-icon" href="./images/icon_72x72.png" type="image/png" sizes="72x72">
	<link rel="apple-touch-icon" href="./images/icon_76x76.png" type="image/png" sizes="76x76">
	<link rel="apple-touch-icon" href="./images/icon_114x114.png" type="image/png" sizes="114x114">
	<link rel="apple-touch-icon" href="./images/icon_120x120.png" type="image/png" sizes="120x120">
	<link rel="apple-touch-icon" href="./images/icon_144x144.png" type="image/png" sizes="144x144">
	<link rel="apple-touch-icon" href="./images/icon_152x152.png" type="image/png" sizes="152x152">
	<link rel="apple-touch-icon" href="./images/icon_180x180.png" type="image/png" sizes="180x180">

	<script type="text/javascript" src="./scripts/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="./scripts/basic.js"></script>
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
		.box {
			width: 80%;
			background-color :#transparent;
			top: 50%;
			left: 50%;
		}
		.options {
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 5px;
			background: rgba(60,60,60,0.75);
			color: #ddd;
			border-color: #aaa;
		}
		input, select {
			width: 80px;
			vertical-align: middle;
			color: #ddd;
			border-width: 0px;
			padding: 2px;
			font-family: 'Pathway Gothic One', sans-serif;
		}
		select:focus, textarea:focus, input:focus {
			outline: none;
		}
		select:invalid, input:invalid {
			background: rgba(40,40,40,0.75);;
		}
		select:valid, input:valid {
			background: rgba(70,70,70,0.75);;
		}
	</style>
</head>

<body>
	<script>
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
			fetchMechList();
			document.getElementById("units").selectedIndex = "1";
		});

		function storeNewMech() {
			var url="./gui_create_mech.php?am=1";

			// Store new mech

			var TON = document.getElementById("F_TON").value;
			var TECH = document.getElementById("TECH").value;
			//var TON = document.getElementById('tonnage').value;
			var MNU = document.getElementById('MNU').value;
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
			var UNITID = document.getElementById('UNITID').value;

			var adjustedPV = adjustPointValue(PVA, SKILL);

			var unitslistbox = document.getElementById("units");
			var selIndex = unitslistbox.selectedIndex;
			var selValue = unitslistbox.options[selIndex].value;
			var selText = unitslistbox.options[selIndex].text;
			var MULID = selValue;
			var MODEL = selText;
			MODEL = MODEL.replace(/"/g,"&quot;");
			MODEL = MODEL.replace(/'/g,"&apos;");

			if ("<<< Select Mech >>>" == MODEL) {
				alert("Select a Mech Model!");
				return;
			}

			if ("<<< Select BA >>>" == MODEL) {
				alert("Select a BA Model!");
				return;
			}

			var MVG = 0;
			var MVJ = 0;

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
			url=url+"&TON="+encodeURIComponent(TON);
			url=url+"&MNU="+encodeURIComponent(MNU);
			url=url+"&TP="+encodeURIComponent(TP);
			url=url+"&SZ="+encodeURIComponent(SZ);
			url=url+"&TMM="+encodeURIComponent(TMM);
			url=url+"&MVG="+encodeURIComponent(MVG);
			url=url+"&MVJ="+encodeURIComponent(MVJ);
			url=url+"&ROLE="+encodeURIComponent(ROLE);
			url=url+"&DMGS="+encodeURIComponent(DMGS);
			url=url+"&DMGM="+encodeURIComponent(DMGM);
			url=url+"&DMGL="+encodeURIComponent(DMGL);
			url=url+"&OV="+encodeURIComponent(OV);
			url=url+"&A="+encodeURIComponent(A);
			url=url+"&S="+encodeURIComponent(S);
			url=url+"&PVA="+encodeURIComponent(adjustedPV);
			url=url+"&SPCL="+encodeURIComponent(SPCL);
			url=url+"&PN="+encodeURIComponent(PN);
			url=url+"&PI="+encodeURIComponent(PI);
			url=url+"&SKILL="+encodeURIComponent(SKILL);
			url=url+"&MULID="+encodeURIComponent(MULID);
			url=url+"&MODEL="+encodeURIComponent(MODEL);
			url=url+"&UNITID="+encodeURIComponent(UNITID);
			url=url+"&TECH="+encodeURIComponent(TECH);

			// alert(url);
			window.location.href = url;
		}
	</script>

	<div id="cover"></div>

<?php
	if ($playMode) {
		$buttonWidth = "34%";
	} else {
		$buttonWidth = "17%";
	}
?>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="width: 100px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<!--
				<td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background: rgba(56,87,26,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				-->
				<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>All bidding units</span></div></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_mech.php'\" width='17%'><div class='mechselect_button_active'><a href='./gui_create_mech.php'>ADD</a><br><span style='font-size:16px;'>Create a Mech/BA</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td style="width: 100px;" nowrap width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="off">
		<table class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='5'>
					Tech: <select required name='tech' id='tech' size='1' onchange="fetchMechList();">
						<option value="2">Clan</option>
						<option value="1">IS</option>
					</select>

					Tons: <select required name='tonnage' id='tonnage' size='1' onchange="fetchMechList();">
						<option value="0-2">0-2</option>
						<option value="20">20</option>
						<option value="25">25</option>
						<option value="30">30</option>
						<option value="35">35</option>
						<option value="40">40</option>
						<option value="45">45</option>
						<option value="50">50</option>
						<option value="55">55</option>
						<option value="60">60</option>
						<option value="65">65</option>
						<option value="70">70</option>
						<option value="75">75</option>
						<option value="80">80</option>
						<option value="85">85</option>
						<option value="90">90</option>
						<option value="95">95</option>
						<option value="100">100</option>
					</select>

					Filter: <input required type="text" id="NameFilter" name="NameFilter" onchange="fetchMechList();">
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='5'>
					<!-- will be filled by 'fetchMechList();' -->
					<select required name='units' id='units' size='1' onchange="mechSelected();" style="width:300px"></select>
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='5'>
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
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;'>
					#: <input required type="text" id="MNU" name="MNU" style='width:60px'>
				</td>
				<td nowrap class="datalabel" style='text-align:left;'>
					<img id="newpilotimage" src="" width="50px" height="50px">
				</td>
				<td nowrap class="datalabel" style='text-align:left;'>
					Pilot: <input type="text" required id="PN" name="PN" style='width:120px'>
				</td>
				<td nowrap class="datalabel" style='text-align:left;'>
					Skill: <select required name='SKILL' id='SKILL' size='1'>
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
				<td>
					<a href='#' onClick='createPilot();'><i class="fas fa-redo"></i></a>
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='4'>Add to unit: <select required name='UNITID' id='UNITID' size='1' style='width:200px;'>
<?php
	$sql_asc_playersunits = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid=".$pid;
	$result_asc_playersunits = mysqli_query($conn, $sql_asc_playersunits);
	if (mysqli_num_rows($result_asc_playersunits) > 0) {
		while($rowUnits = mysqli_fetch_assoc($result_asc_playersunits)) {
			$unitid = $rowUnits['unitid'];
			$forcename = $rowUnits['forcename'];
			if ($paramunitid == $unitid) {
				echo "										<option value='".$unitid."' selected>".$forcename."</option>\n";
			} else {
				echo "										<option value='".$unitid."'>".$forcename."</option>\n";
			}
		}
	}
?>
					</select>
				</td>
				<td align="right">
					<a href='#' onClick='storeNewMech();'><i class='fas fa-plus-square'></i></a>
				</td>
			</tr>
		</table>
	</form>

	<script>
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
