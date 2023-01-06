<?php
session_start();

// https://stackoverflow.com/questions/22911552/php-blank-white-page-no-errors
// php.ini: error_reporting=~E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~WARNING
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 5");
	}
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];

	$opt2 = $_SESSION['option2'];
	$showplayerdata_topleft = $opt2;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard)</title>
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
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/functions.js"></script>
	<!-- <script type="text/javascript" src="./scripts/qrcode.js"></script> -->

	<style>
		.options {
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 5px;
			background: rgba(60,60,60,0.75);
			color: #ddd;
			border-color: #aaa;
		}
	</style>
</head>

<body>
	<script>
//		var movementcache = 0;
//		var firedcache = 0;
//
//		function setFireValues(mv, fired) {
//			if (mv == 2) { // Stationary (AMM -1)
//				document.getElementById("AMM").innerHTML = "-1";
//			} else if (mv == 4) { // Jumped (AMM +2)
//				document.getElementById("AMM").innerHTML = "+2";
//			} else if (mv == 9) { // Sprinted
//             	document.getElementById("AMM").innerHTML = "0";
//             } else {
//				document.getElementById("AMM").innerHTML = "0";
//			}
//		}

//		function changeMovementFlag(index, fln) {
//			if (context != null) {
//				playTapSound();
//			}
//
//			var list = document.getElementsByClassName("bigcheck");
//			var fired = 0;
//			var mv = 0;
//			var movementdiestring = "";
//
//			[].forEach.call(list, function (el1) {
//				na = el1.name;
//				if (typeof na != 'undefined') {
//					if (na.substring(0, 2) == "MV" && (fln!=5 && fln!=6 && fln!=7 && fln!=8)) { el1.checked = false }
//					if (na.substring(0, 4) == "MV" + fln + "_" || na.substring(0, 5) == "MV" + fln + "_") {
//						el1.checked = true;
//						mv = fln;
//					}
//
//					if ((na.substring(0, 4) == "MV1_") && el1.checked == true) { mv = 1; }
//					if ((na.substring(0, 4) == "MV2_") && el1.checked == true) { mv = 2; }
//					if ((na.substring(0, 4) == "MV3_") && el1.checked == true) { mv = 3; }
//					if ((na.substring(0, 5) == "MV10_") && el1.checked == true) { mv = 10; }
//					if ((na.substring(0, 4) == "MV4_") && el1.checked == true) { mv = 4; }
//					if ((na.substring(0, 4) == "MV9_") && el1.checked == true) { mv = 9; }
//
//					if (na.substring(0,2) == "WF" && (fln!=1 && fln!=2 && fln!=3 && fln!=4 && fln!=9 && fln!=10)) { el1.checked = false }
//					if (na.substring(0,4) == "WF" + fln + "_") {
//						el1.checked = true;
//					}
//
//					if (na == "WF5_WEAPONSFIRED" && el1.checked == true) {
//						if (mv == 0) {
//							//alert("First movement has to be specified!");
//							el1.checked = false;
//						} else {
//							fired = 1; // not fired on purpose to cool down (or the unit sprinted)
//						}
//					}
//					if (na == "WF6_WEAPONSFIRED" && el1.checked == true) {
//						if (mv == 0) {
//							//alert("First movement has to be specified!");
//							el1.checked = false;
//						} else {
//							fired = 2; // fired weapons, was before: fired on short range (not anymore, there is just fired or hold fire)
//						}
//					}
//				}
//			})
//
//			var elem = document.getElementById("fire_info_cell_2");
//			if (elem == null || elem === undefined) {
//				// nothing
//			} else {
//				if (mv == "0" || mv == "9") {
//					elem.className = 'datalabel_disabled_dashed';
//				} else {
//					elem.className = 'datalabel';
//				}
//			}
//
//			var clearmovement = false;
//			if (movementcache == mv && (fln!=5 && fln!=6 && fln!=7 && fln!=8)) {
//				clearMovementFlags(index);
//				clearmovement = true;
//				fired = 0;
//			} else {
//				movementcache = mv;
//			}
//
//			if (firedcache == fired && (fln!=1 && fln!=2 && fln!=3 && fln!=4 && fln!=9 && fln!=10)) {
//				clearFiredFlags(index, mv);
//				fired = 0;
//			} else {
//				firedcache = fired;
//			}
//
//			if (clearmovement) {
//				mv = 0;
//				fired = 0;
//			}
//
//			if (mv == 9) {
//				fired = 1;
//			}
//
//			var tmmDiceValue = document.getElementById("TMM").innerHTML;
//			if (mv == "0") { // not moved yet
//			    movementdiestring = movementdiestring + "d6_0.png";
//			    document.getElementById('INFOMOVED').innerHTML = "MOVE:";
//			} else if (mv == "2") { // stationary
//			    movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
//			    document.getElementById('INFOMOVED').innerHTML = "STATIONARY";
//			} else if (mv == "3") { // walked
//			    movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
//			    document.getElementById('INFOMOVED').innerHTML = "WALKED";
//			} else if (mv == "10") { // hulldown
//				movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
//				document.getElementById('INFOMOVED').innerHTML = "HULLDOWN";
//			}  else if (mv == "4") { // jumped
//			    movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
//			    document.getElementById('INFOMOVED').innerHTML = "JUMPED";
//			} else if (mv == "9") { // sprinted
//				movementdiestring = movementdiestring + "yd6_" + tmmDiceValue + ".png";
//                var e1 = document.getElementById("WF5_WEAPONSFIRED");
//                var e2 = document.getElementById("WF6_WEAPONSFIRED");
//                if (e1 !== undefined && e1 !== null) { e1.checked = true; }
//                if (e2 !== undefined && e2 !== null) { e2.checked = false; }
//				var e1a = document.getElementById("WF5_WEAPONSFIRED2");
//				var e2a = document.getElementById("WF6_WEAPONSFIRED2");
//				if (e1a !== undefined && e1a !== null) { e1a.checked = true; }
//                if (e2a !== undefined && e2a !== null) { e2a.checked = false; }
//                fired = 1; // HOLD FIRE!
//                document.getElementById('INFOMOVED').innerHTML = "SPRINTED";
//            }
//
//			if (fired == 0) {
//                document.getElementById('INFOFIRED').innerHTML = "FIRE:";
//            } else if (fired == 1) {
//				document.getElementById('INFOFIRED').innerHTML = "HOLD FIRE";
//			} else if (fired == 2) {
//				document.getElementById('INFOFIRED').innerHTML = "FIRED";
//			}
//
//			document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;
//
//			setFireValues(mv, fired);
//			var url="./save_movement.php?index="+index+"&mvmt="+mv+"&wpns="+fired;
//			//console.log("Final 3: " + url);
//			window.frames['saveframe'].location.replace(url);
//		}

//		function setMovementFlags(index, movement, weaponsfired) {
//			if (context != null) {
//				playTapSound();
//			}
//
//			var movementdiestring = "";
//
//			var list = document.getElementsByClassName("bigcheck");
//			[].forEach.call(list, function (el1) {
//				na = el1.name;
//				if (typeof na != 'undefined') {
//					if (na.substring(0, 2) == "MV") { el1.checked = false }
//
//					if ((na.substring(0, 4) == "MV1_") && movement == 1) { el1.checked = true; }
//					if ((na.substring(0, 4) == "MV2_") && movement == 2) { el1.checked = true; }
//					if ((na.substring(0, 4) == "MV3_") && movement == 3) { el1.checked = true; }
//					if ((na.substring(0, 5) == "MV10_") && movement == 10) { el1.checked = true; }
//					if ((na.substring(0, 4) == "MV4_") && movement == 4) { el1.checked = true; }
//					if ((na.substring(0, 4) == "MV9_") && movement == 9) { el1.checked = true; }
//
//					// weaponsfired == 0 : not fired yet
//					// weaponsfired == 1 : not fired on purpose
//					// weaponsfired == 2 : fired
//
//					if (na == "WF5_WEAPONSFIRED" && weaponsfired == 1) { el1.checked = true; }
//					if (na == "WF5_WEAPONSFIRED2" && weaponsfired == 1) { el1.checked = true; }
//					if (na == "WF6_WEAPONSFIRED" && weaponsfired == 2) { el1.checked = true; }
//					if (na == "WF6_WEAPONSFIRED2" && weaponsfired == 2) { el1.checked = true; }
//					//if (na == "WF7_WEAPONSFIRED" && weaponsfired == 3) { el1.checked = true; }
//					//if (na == "WF8_WEAPONSFIRED" && weaponsfired == 4) { el1.checked = true; }
//				}
//			})
//
//			var elem = document.getElementById("fire_info_cell_2");
//			if (elem == null || elem === undefined) {
//				// nothing
//			} else {
//				if (movement == "0" || movement == "9") {
//					elem.className = 'datalabel_disabled_dashed';
//				} else {
//					elem.className = 'datalabel';
//				}
//			}
//
//			var tmmDiceValue = document.getElementById("TMM").innerHTML.replace('*','');
//
//			if (movement == "0") { // not moved yet
//			    movementdiestring = movementdiestring + "d6_0.png";
//			    document.getElementById('INFOMOVED').innerHTML = "MOVE:";
//			} else if (movement == "2") { // stationary
//				movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
//				document.getElementById('INFOMOVED').innerHTML = "STATIONARY";
//			} else if (movement == "3") { // walked
//				movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
//				document.getElementById('INFOMOVED').innerHTML = "WALKED";
//			} else if (movement == "10") { // hulldown
//				movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
//				document.getElementById('INFOMOVED').innerHTML = "HULLDOWN";
//            } else if (movement == "4") { // jumped
//			    movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
//			    document.getElementById('INFOMOVED').innerHTML = "JUMPED";
//			} else if (movement == "9") {
//				movementdiestring = movementdiestring + "yd6_" + tmmDiceValue + ".png";
//				var e1 = document.getElementById("WF5_WEAPONSFIRED");
//				var e2 = document.getElementById("WF6_WEAPONSFIRED");
//                if (e1 !== undefined && e1 !== null) { e1.checked = true; }
//                if (e2 !== undefined && e2 !== null) { e2.checked = false; }
//				var e1a = document.getElementById("WF5_WEAPONSFIRED2");
//				var e2a = document.getElementById("WF6_WEAPONSFIRED2");
//				if (e1a !== undefined && e1a !== null) { e1a.checked = true; }
//                if (e2a !== undefined && e2a !== null) { e2a.checked = false; }
//                fired = 1; // HOLD FIRE!
//                document.getElementById('INFOMOVED').innerHTML = "SPRINTED";
//			}
//
//			if (weaponsfired == 0) {
//				document.getElementById('INFOFIRED').innerHTML = "FIRE:";
//			} else if (weaponsfired == 1) {
//				document.getElementById('INFOFIRED').innerHTML = "HOLD FIRE";
//			} else if (weaponsfired == 2) {
//				document.getElementById('INFOFIRED').innerHTML = "FIRED";
//			}
//
//			document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;
//
//			movementcache = movement;
//			firedcache = weaponsfired;
//			setFireValues(movement, weaponsfired);
//		}
	</script>

<?php
	$file = file_get_contents('./version.txt', true);
	$version = $file;
	if (!isset($_GET["unit"])) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
		//die("Check position 1");
	}
	$unitid = $_GET["unit"];
	if (empty($unitid)) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
		//die("Check position 2");
	}
	if (isset($_GET["chosenmech"])) {
		$chosenMechIndex = $_GET["chosenmech"];
		if (empty($chosenMechIndex)) {
			$chosenMechIndex = 1;
		}
	} else {
		$chosenMechIndex = 1;
	}
	require('./db_getdata.php');

	echo "<script>\n";
	echo "  var chosenmechindex = ".$chosenMechIndex.";\n";
	echo "  var chosenmechdbid = ".$array_MECH_DBID[$chosenMechIndex].";\n";
	echo "  var mechmodel = '".$array_MECH_MODEL[$chosenMechIndex]."';\n";
	echo "	var shortdamage = ".$array_DMG_SHORT[$chosenMechIndex].";\n";
	echo "	var mediumdamage = ".$array_DMG_MEDIUM[$chosenMechIndex].";\n";
	echo "	var longdamage = ".$array_DMG_LONG[$chosenMechIndex].";\n";
	echo "	var movementpointsground = ".$array_MV[$chosenMechIndex].";\n";
	if ($array_MVJ[$chosenMechIndex] != null) {
		echo "	var movementpointsjump = ".$array_MVJ[$chosenMechIndex].";\n";
	} else {
		echo "	var movementpointsjump = 0;\n";
	}
	echo "	var maximalarmorpoints = ".$array_A_MAX[$chosenMechIndex].";\n";
	echo "	var maximalstructurepoints = ".$array_S_MAX[$chosenMechIndex].";\n";
	echo "	var originalmechimage = '".$array_MECH_IMG_URL[$chosenMechIndex]."';\n";
	echo "	var deadmechimage = 'skull.png';\n";
	echo "	var originalTMM = $array_TMM[$chosenMechIndex];\n";
	echo "  var unitType = '$array_TP[$chosenMechIndex]';\n";
	echo "  var ENGN_PREP = $array_ENGN_PREP[$chosenMechIndex];\n";
	echo "  var FCTL_PREP = $array_FRCTRL_PREP[$chosenMechIndex];\n";
	echo "  var MP_PREP = $array_MP_PREP[$chosenMechIndex];\n";
	echo "  var WPNS_PREP = $array_WPNS_PREP[$chosenMechIndex];\n";
	echo "	var HT_PREP = $array_HT_PREP[$chosenMechIndex];\n";
	echo "	var playerId = ".$pid.";\n";
	echo "</script>\n";
?>

<iframe name="saveframe" src="./save.php"></iframe>

<div id="cover"></div>

<div id="header">
	<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
		<tr>
			<td nowrap onclick="location.href='./index.html'" width="60px" style="width:100px;background:rgba(50,50,50,1.0);text-align:center;vertical-align:middle;">
				<div><a style="color:#eee;" href="./index.html">&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
			</td>
			<!-- <td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background:rgba(56,87,26,1.0);text-align:center;vertical-align:middle;">
				<div><a style="color: #eee;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
			</td>
			-->
			<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width:100px;background:rgba(56,87,26,1.0);">
				<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
			</td>

<?php
	$size = sizeof($array_MECH_MODEL);
	for ($i11 = 1; $i11 <= sizeof($array_MECH_MODEL); $i11++) {
		if ($array_ACTIVE_BID[$i11] == "0") {
			$size = $size - 1;
		}
	}
	$width = ceil(100 / $size);
	$heatimage = array();
	$currentMechStatusImage = "./images/check_red.png";
	$currentmeli = "";
	$currentPhaseButton = "./images/top-right_phase01.png";

	$currentMechMovement = 0;
	$currentMechFired = 0;

	$atLeastOneValidMechInUnit = 0;

	for ($i4 = 1; $i4 <= sizeof($array_MECH_MODEL); $i4++) {
		$mechstatusimage = "./images/check_red.png";
		$mvmt = $array_MVMT[$i4];
		$wpnsfired = $array_WPNSFIRED[$i4];

		if ($array_TP[$i4] == "BA") {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px' width='0px'>";
		} else {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px'>";
		}
		$phaseButton = "./images/top-right_phase01.png";
		if ($mvmt == 0 && $wpnsfired == 0) {
			$mechstatusimage = "./images/check_red.png";
			$phaseButton = "./images/top-right_phase01.png";
		}
		if ($mvmt > 0 && $wpnsfired == 0) {
			$mechstatusimage = "./images/check_yellow.png";
			$phaseButton = "./images/top-right_phase02.png";
		}
		if ($mvmt > 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			$mechstatusimage = "./images/check_green.png";
			$phaseButton = "./images/top-right_phase03.png";
		}
		if ($mvmt == 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			// Error! Unit has fired but no movement was specified! Ask again!
		}
		if ($array_MECH_IMG_STATUS[$i4] == "images/DD_04.png") {
			$phaseButton = "./images/top-right_phase00.png";
		}

		$memodel = $array_MECH_MODEL[$i4];
		if ($array_ACTIVE_BID[$i4] == "0") {
			$memodel = "--- BIDDEN AWAY ---";
		}

		if ($array_MECH_NUMBER[$i4] == "") {
			$mn = "-";
		} else {
			$mn = $array_MECH_NUMBER[$i4];
		}

		$meli="./gui_play_mech.php?unit=".$unitid."&chosenmech=".$i4;
		if ($chosenMechIndex == $i4) {
			$locmeli = $meli;
			$currentMechStatusImage = $mechstatusimage;
			$currentmeli = $meli;
			$currentPhaseButton = $phaseButton;

			$currentMechMovement = $mvmt;
			$currentMechFired = $wpnsfired;

			if ($array_ACTIVE_BID[$i4] == "1") {
				echo "<td width='".$width."%' nowrap><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_active_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img id='mechstatusimagemenu' style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<span style='font-size:24px'>".$array_PILOT[$i4]."</span>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
				$atLeastOneValidMechInUnit = $atLeastOneValidMechInUnit + 1;
			}
		} else {
			if ($array_ACTIVE_BID[$i4] == "1") {
				echo "<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
				$atLeastOneValidMechInUnit = $atLeastOneValidMechInUnit + 1;
			} else {
				echo "<td style='display:none;visibility:hidden;' width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
			}
		}
	}
	if ($atLeastOneValidMechInUnit == 0) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
	}

	function getMechMULImageByName($mechname) {
		$image = "images/mechs/Generic.gif";
		$dir = 'images/mechs_mul/';
		$startChar = mb_substr($mechname, 0, 3); // use first 3 chars to list files to keep the resultlist as small as possible

		$files = glob($dir."{$startChar}*.png");
		foreach ($files as &$img) {
			//echo "<script>console.log('>>" . trim($img) . "<<');</script>";

			$imagenametrimmed_a = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagenametrimmed = str_replace("'", "", $imagenametrimmed_a);

			$mechnametrimmed_a = str_replace('ELE ', 'Elemental ', trim($mechname));
			$mechnametrimmed_b = str_replace('BA ', 'Battle Armor ', trim($mechnametrimmed_a));
			$mechnametrimmed_c = str_replace('&apos;', '', trim($mechnametrimmed_b));
			$mechnametrimmed_d = str_replace(' ', '', trim($mechnametrimmed_c));
			$mechnametrimmed = strtolower($mechnametrimmed_d);

			// echo "<script>console.log('SEARCHING: >>" . $imagenametrimmed . "?" . $mechnametrimmed . "<<');</script>";

			if (strpos($imagenametrimmed,$mechnametrimmed) !== false) {
				// echo "<script>console.log('FOUND: >>" . $imagenametrimmed . "?" . $mechnametrimmed . "<<');</script>";
				$image = str_replace(' ', '%20', trim($img));
				break;
			}
		}
		return $image;
	}
?>

			<td style="width: 100px;" style="width: 100px;" nowrap width="100px" style="background:rgba(50,50,50,1.0);text-align:center;vertical-align:middle;display:block;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
		</tr>
	</table>
</div>

<div id="pilotimage"><?php echo "<img src='".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='80px' height='80px'>" ?></div>
<div id="faction" align="center"><?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='50px' height='50px'>" ?></div>
<div id="mech_number" align="center">#<?= $array_MECH_NUMBER[$chosenMechIndex] ?></div>

<?php
	if ($useMULImages == 0) {
		echo "<div id='mech'><img id='mechimage' src='" . $array_MECH_IMG_URL[$chosenMechIndex] . "'></div>\n";
	} else if ($useMULImages == 1) {
		echo "<div id='mech'><img id='mechimage' src='" . getMechMULImageByName($array_MECH_MODEL[$chosenMechIndex]) . "'></div>\n";
	}
	echo "<script>var mechImageURL='".$array_MECH_IMG_URL[$chosenMechIndex]."';</script>\n";
	echo "<script>var mechImageURLMUL='".getMechMULImageByName($array_MECH_MODEL[$chosenMechIndex])."';</script>\n";
?>

<div id="topleft">
	<span style="font-size: 18px; color: #eeeeee;"><?php echo "$UNIT"; ?></span>
	<br>
	<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenMechIndex]"; ?></span>
	<br>
	<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?></span>
</div>

<div id="topright">
	<img id='toprightimage' src='./images/top-right_02.png' style='height:135px;'>
</div>

<?php
	echo "<div id='mechalive_status_div'>\n";
	echo "	<img id='mechalive_status' src='./images/vitalmonitor.gif' width='140px' height='120px'>\n";
	echo "</div>\n";
	echo "<div id='player_image'>\n";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>\n";
	echo "</div>\n";
	echo "<div id='pilotrank'>\n";
	echo "  <img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$chosenMechIndex].".png' width='30px' height='30px'>\n";
	echo "</div>\n";
	if ($pid == $unitplayerid) {
		// Current Mech is playable by current user
		$playable = true;
	} else {
		$playable = false;
	}

	if ($array_ACTIVE_BID[$chosenMechIndex] == "0") {
		$playable = false;
	}

	if (!$playable) {
		if ($hideNotOwnedMech) {
			echo "<div id='blockNotOwnedMechs'></div>";
		}
	}

	echo "<script type='text/javascript'>\n";
	if ($showplayerdata_topleft == 1) {
		// show top left pilot info
		echo "  $('#pilotimage').show();\n";
		echo "  $('#faction').show();\n";
		echo "  $('#pilotrank').show();\n";
		echo "  $('#topleft').show();\n";
	} else {
		// do not show pilot infor
		echo "  $('#pilotimage').hide();\n";
		echo "  $('#faction').hide();\n";
		echo "  $('#pilotrank').hide();\n";
		echo "  $('#topleft').hide();\n";
	}
	echo "  //console.log('Current structure damage: $array_S[$chosenMechIndex]');\n";
	echo "  setStructuralDamageCache($array_S[$chosenMechIndex]);\n";
	echo "</script>\n";
?>

<div id="pv">
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">&nbsp;PV:&nbsp;</span>
	<span style="font-size: 36px; color: #da8e25; vertical-align: middle; font-weight: bold;"><?php echo "$array_PV[$chosenMechIndex]"; ?></span>
</div>

<div class="datatable">
	<table width="100%" style="height: 100%;">
		<tr>
			<td width="60%" valign="bottom">

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="12%">TP:</td>
							<td nowrap class="datavalue" width="13%" id="unit_type"><?php echo "$array_TP[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">SZ:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_SZ[$chosenMechIndex]/$array_TON[$chosenMechIndex]"; ?></td>
							<td id="tmmLabel" nowrap class="datalabel" width="12%">TMM:</td>
							<td nowrap class="datavalue" width="13%" id="TMM"><?php echo "$array_TMM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datavalue_thin" style="text-transform: none;" width="12%" id="mv_points"><?php echo "$array_MV[$chosenMechIndex]&rdquo;";
							if ($array_MVJ[$chosenMechIndex] != null) {
								echo "/$array_MVJ[$chosenMechIndex]&rdquo;&nbsp;j";
							} ?></td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="12%" colspan="1">ROLE:</td>
							<td nowrap class="datavalue_thin" width="38%" colspan="3"><?php echo "$array_ROLE[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%" colspan="1">SKILL:</td>
							<td nowrap class="datavalue" width="37%" colspan="3" valign="middle" style="top:0px;bottom:0px;vertical-align:middle;"><?php echo "$array_SKILL[$chosenMechIndex]"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:'Pathway Gothic One',sans-serif;font-size:75%;text-transform:uppercase;color:#999;" id="AMM">0</span> <span style="font-family:'Pathway Gothic One',sans-serif;font-size:75%;text-transform:uppercase;color:#999;">(AMM)</span></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="10%" style="text-align: left;">DMG:</td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrollshort">S (+0):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgshort_s"><?php echo "$array_DMG_SHORT[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrollmedium">M (+2):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgmedium_s"><?php echo "$array_DMG_MEDIUM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrolllong">L (+4):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmglong_s"><?php echo "$array_DMG_LONG[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenMechIndex] == "BA") {
		// Do not show the heat block for all Battle Armor units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<!-- <td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_OV[$chosenMechIndex]"; ?></td> -->
							<td nowrap width="25%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_OV[$chosenMechIndex]; $i1++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='UOV".$i1."' id='UOV".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
							<td nowrap class="datalabel" width="15%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:&nbsp;&nbsp;</td>
							<td nowrap class="datalabel_button" width="2%" valign="middle"><a href="javascript:increaseHT_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel" width="2%" id="label_HT_PREP" align="center"><?= $array_HT_PREP[$chosenMechIndex] ?></td>
							<td nowrap width="36%" style="text-align: right;" id="ht_field" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H1" id="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H2" id="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H3" id="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H4" id="H4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<!-- <td class="datalabel" width="5%" style="text-align: right;">&nbsp;&nbsp;&nbsp;(SD)</td> -->
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="5%" class="datalabel">A:</td>
							<td nowrap width="95%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_A_MAX[$chosenMechIndex]; $i1++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
						</tr>
						<tr>
							<td nowrap width="5%" class="datalabel">S:</td>
							<td nowrap width="95%" class="datalabel_thin">
<?php
	for ($i2 = 1; $i2 <= $array_S_MAX[$chosenMechIndex]; $i2++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="10%" class="datalabel" width="100%">SP:</td>
							<td nowrap width="90%" class="datavalue_thin" style="text-align: left;">
								<table>
									<tr>
										<td nowrap width="99%" class="datavalue_thin" style="text-align: left;" id="sa_field">
											<?php echo "$array_SPCL[$chosenMechIndex]"; ?>
										</td>
										<td nowrap width="1%" class="datavalue_thin" style="text-align: right;" align="right">
											<a href="https://www.clanwolf.net/apps/ASCard/gui_show_specialabilities.php"><i class="fas fa-info-circle"></i></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>

			</td>
			<td width="40%" valign="bottom" align="left">
				<div id="movementtoken" width="100%" valign="top" align="left">
					<img valign="top" id="movementtokenimage" src="./images/dice/yd6_4.png" height="70px">
				</div>
				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap rowspan="3" style="vertical-align: middle;" valign="middle" align="center" width="15px">
								<div style="padding: 0 15 0 15;" id="phasebutton" name="phasebutton"><img id="phasebuttonimage" src=<?php echo "'$currentPhaseButton'"; ?> style='height:50px;'></div> <!-- <a href=<?php echo "'$currentmeli'"; ?>> </a> -->
							</td>
							<td nowrap width="65%" class="datalabel_thin">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td align="center"><img src="./images/buttons/mov01.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov02.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov03.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov04.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov05.png" height='17px' style="border: 0px solid #000000;"></td>
									</tr>
									<tr>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, 2, -1);' class='bigcheck' name='MV2_moved2_standstill' id='MV2_moved2_standstill' value='no'/><span class='bigcheck-target'></span></label></td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, 10,-1);' class='bigcheck' name='MV10_moved10_hulldown' id='MV10_moved10_hulldown' value='no'/><span class='bigcheck-target'></span></label></td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, 3, -1);' class='bigcheck' name='MV3_moved3_moved' id='MV3_moved3_moved' value='no'/><span class='bigcheck-target'></span></label></td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, 9, -1);' class='bigcheck' name='MV9_moved9_sprinted' id='MV9_moved9_sprinted' value='no'/><span class='bigcheck-target'></span></label></td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, 4, -1);' class='bigcheck' name='MV4_moved4_jumped' id='MV4_moved4_jumped' value='no'/><span class='bigcheck-target'></span></label></td>
									</tr>
								</table>
							</td>
							<td id="INFOMOVED" nowrap width="20%" class="datalabel"></td> <!-- &nbsp;(MOVEMENT) -->
						</tr>
						<tr>
							<td nowrap width="65%" id="firecontainer" class="datalabel_thin">
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, -1, 1);' class='bigcheck' name='WF5_WEAPONSFIRED2' id='WF5_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label></td>
									<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>, -1, 2);' class='bigcheck' name='WF6_WEAPONSFIRED2' id='WF6_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label></td>
								</tr>
								<tr>
									<td align="center" colspan="2"><img src="./images/buttons/fire.png" height='17px' style="border: 0px solid #000000;"></td>
                                </tr>
							</table>
							</td>
							<td id="INFOFIRED" nowrap  width="20%" class="datalabel"></td> <!-- &nbsp;(WEAPONS) -->
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenMechIndex] == "BA") {
		// Do not show the heat block for all Battle Armor units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>

					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">ENGN:&nbsp;&nbsp;</td>
							<td nowrap class="datalabel_button" valign="middle"><a href="javascript:increaseENGN_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel" id="label_ENGN_PREP" align="center"><?= $array_ENGN_PREP[$chosenMechIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" id="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_2" id="CD_E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+1 HT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FCTL:&nbsp;&nbsp;</td>
							<td nowrap class="datalabel_button" valign="middle"><a href="javascript:increaseFCTL_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel" id="label_FCTL_PREP" align="center"><?= $array_FRCTRL_PREP[$chosenMechIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;&nbsp;</td>
							<td nowrap width="90%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" id="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" id="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" id="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" id="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:&nbsp;&nbsp;</td>
							<td nowrap class="datalabel_button" valign="middle"><a href="javascript:increaseMP_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel" id="label_MP_PREP" align="center"><?= $array_MP_PREP[$chosenMechIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" id="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" id="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" id="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" id="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">1/2 MV</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WPNS:&nbsp;&nbsp;</td>
							<td nowrap class="datalabel_button" valign="middle"><a href="javascript:increaseWPNS_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel" id="label_WPNS_PREP" align="center"><?= $array_WPNS_PREP[$chosenMechIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" id="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" id="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" id="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" id="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">-1 DMG</td>
						</tr>
					</table>
				</div>
			</td>
			<td valign='bottom'>
				<a onclick='showInfoBar();' id="InfoButton" href='#'><img src='./images/selector_02-info.png' width='50px'></a><br>
				<a onclick='showDiceBar();' id="DiceButton" href='#'><img src='./images/selector_01-dice.png' width='50px'></a><br>
				<a onclick='showMoveBar();' id="MoveButton" href='#'><img id='roundphaseshortcutimage' src='./images/selector_04-movement.png' width='50px'></a>
			</td>
		</tr>
	</table>
</div>

<div name='bgrightbar' id='bgrightbar'></div>

<div name='infobar' id='infobar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideInfoBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='infopanel' id='infopanel'>
		<table width="220px">
			<tr>
				<td id='pilotinfo' align="right" valign="bottom">
					<span style="font-size: 18px; color: #eeeeee;"><?php echo "$UNIT"; ?></span><br>
					<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenMechIndex]"; ?></span><br>
					<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?></span><br><br>
					<!-- Mechwarriors are highly trained and effective warriors.<br><br> -->
					<div id="pilotinfo" valign="bottom" align="right">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td rowspan="2">
									<?php echo "<img src='".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='84px' height='84px' style='border: 1px solid #000000;'>" ?>
								</td>
								<td style='background-color:#000000;' align='right'>
									<?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='40px' height='40px' style='border: 1px solid #000000;'>" ?>
								</td>
							</tr>
							<tr>
								<td valign='bottom' align='right'>
									<img src='./images/ranks/<?php echo $factionid ?>/<?php echo $array_PILOT_RANK[$chosenMechIndex] ?>.png' style='border: 1px solid #000000;' width='40px' height='40px'>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div name='movebar' id='movebar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideMoveBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='movepanel' id='movepanel'>
		<table width="100%">
			<tr>
				<td id='moveinfo' align="right" valign="bottom">
					<div id="moveinfo" valign="bottom" align="left">
						<table cellspacing="5" cellpadding="0" width="100%">
							<tr>
								<td id="phasemovebutton2" class='phase_button_normal'>Stationary</td>
							</tr>
							<tr>
								<td id="phasemovebutton10" class='phase_button_normal'>Hulldown</td>
							</tr>
							<tr>
								<td id="phasemovebutton3" class='phase_button_normal'>Walked</td>
							</tr>
							<tr>
								<td id="phasemovebutton9" class='phase_button_normal'>Sprinted</td>
							</tr>
							<tr>
								<td id="phasemovebutton4" class='phase_button_normal'>Jumped</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div name='dicebar' id='dicebar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideDiceBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='dicepanel' id='dicepanel'>
		<table width="220px">
			<tr>
				<td align="right" valign="bottom">
<?php
	if ($array_TP[$chosenMechIndex] != "BA") {
		echo "                  <div id='criticalhit'></div>\r\n";
	} else {
		echo "                  <div id='criticalhit' style='display:none;'></div>\r\n";
	}
?>
					<div id="dice" valign="middle" align="center">
						<img id="die1" src="./images/dice/d6_0.png" width="65px" height="65px">
						<img id="die2" src="./images/dice/d6_0.png" width="65px" height="65px">
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div id="destroyedIndicator">
	<img src='./images/skull.png' onclick="javascript:hideSkull();" height='250px'>
</div>

<script type="text/javascript">
	$("#infobar").hide();
	$("#dicebar").hide();
	$("#movebar").hide();
	$("#destroyedIndicator").hide();
	setCircles(<?=$array_HT[$chosenMechIndex]?>,<?=$array_A[$chosenMechIndex]?>,<?=$array_S[$chosenMechIndex]?>,<?=$array_ENGN[$chosenMechIndex]?>,<?=$array_FRCTRL[$chosenMechIndex]?>,<?=$array_MP[$chosenMechIndex]?>,<?=$array_WPNS[$chosenMechIndex]?>,<?=$array_USEDOVERHEAT[$chosenMechIndex]?>,<?=$array_MVMT[$chosenMechIndex]?>,<?=$array_WPNSFIRED[$chosenMechIndex]?>);
</script>

<div id="footer"></div>

<div id="bottomleft"><img src="./images/bottom-left.png" width="200px"></div>

<div align="center" id="settings">
	<a href="javascript:showMech()"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<!-- <a href="https://www.clanwolf.net/static/files/Rulebooks/CAT35860%20-%20AlphaStrike%20CommandersEdition.pdf" target="_blank"><i class="fas fa-bookmark"></i></a>&nbsp;&nbsp; -->
	<!-- <a href="#" onclick="javascript:window.location.reload(true)"><i class="fas fa-redo"></i></a>&nbsp;&nbsp; -->
	<a href="javascript:textSize(0)"><i class="fas fa-minus-square"></i></a>&nbsp;&nbsp;
	<a href="javascript:textSize(1)"><i class="fas fa-plus-square"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:changeWallpaper()"><i class="fas fa-image"></i></a>&nbsp;&nbsp;
	<a href="./gui_edit_option.php"><i class="fas fa-cog"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="./images/bt-logo2.png" width="250px"></div>

<?php
//	echo "<script>\n";
//	echo "	setMovementFlags($array_MECH_DBID[$chosenMechIndex], $array_MVMT[$chosenMechIndex], $array_WPNSFIRED[$chosenMechIndex]);\n";
//	echo "	setFireValues($array_MVMT[$chosenMechIndex], $array_WPNSFIRED[$chosenMechIndex]);\n";
//	echo "</script>\n";
//
//	if ($movd==1) {
//		if ($playable) {
//			echo "<div id='editMovementValues' style='display:none;'>\n";
//			//echo "	<br>\n";
//			echo "	<br>\n";
//			echo "	<table width='100%'>\n";
//			echo "		<tr>\n";
//			echo "			<td width='30%'></td>\n"; // onclick=\"location.href='".$locmeli."'\"
//			echo "			<td width='40%'>\n";
//			echo "				<div>\n";
//			echo "					<table width='100%' class='options' style='margin-left: auto;margin-right: auto;' cellspacing=4 cellpadding=4 border=0px>\n";
////			echo "						<tr>\n";
////			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
////			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 1);' type='checkbox' class='bigcheck' name='MV1_IMMOBILE' value='yes'/><span class='bigcheck-target'></span></label>\n";
////			echo "							</td>\n";
////			echo "							<td nowrap align='left' class='datalabel'>\n";
////			echo "								&nbsp;&nbsp;&nbsp;Immobile\n";
////			echo "							</td>\n";
////			echo "							<td nowrap align='left' class='datavalue_small'>\n";
////			echo "								&nbsp;&nbsp;&nbsp;\n";
////			echo "							</td>\n";
////			echo "							<td nowrap align='left' class='datavalue_small'>\n";
////			echo "								&nbsp;&nbsp;&nbsp;TMM -4\n";
////			echo "							</td>\n";
////			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 2);' type='checkbox' class='bigcheck' name='MV2_STANDSTILL' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Stationary\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;AMM -1\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;TMM 0\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 10);' type='checkbox' class='bigcheck' name='MV10_HULLDOWN' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Hulldown\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 3);' type='checkbox' class='bigcheck' name='MV3_MOVED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Walked\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;TMM #\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 9);' type='checkbox' class='bigcheck' name='MV9_SPRINTED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Sprinted\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;NO FIRE\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 4);' type='checkbox' class='bigcheck' name='MV4_JUMPED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Jumped\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;AMM +2\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;TMM ";
//
//			if ($array_TP[$chosenMechIndex] == "BA") {
//				// BA do not use the modifier for jumping
//				echo "#+SPCL\n";
//			} else {
//				echo "#+1+SPCL\n";
//			}
//
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap colspan='4'><hr></td>\n";
//			echo "						</tr>\n";
//			echo "						<tr>\n";
// 			echo "							<td id='fire_info_cell_2' nowrap colspan='4' align='left' class='datalabel_disabled_dashed'>\n";
//			echo "							    <table width='100%' cellspacing='1'>\n"; // style='background-color:#754743;'
//			echo "									<tr>\n";
//			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 5);' type='checkbox' class='bigcheck' name='WF5_WEAPONSFIRED' id='WF5_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;&nbsp;&nbsp;HOLD FIRE\n";
// 			echo "										</td>\n";
//			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 6);' type='checkbox' class='bigcheck' name='WF6_WEAPONSFIRED' id='WF6_WEAPONSFIRED'value='yes'/><span class='bigcheck-target'></span></label>&nbsp;&nbsp;&nbsp;FIRE\n";
// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//// 			echo "										</td>\n";
////			echo "									</tr>\n";
////			echo "									<tr>\n";
////			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											HOLD FIRE\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											FIRED\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
////			echo "										</td>\n";
//			echo "									</tr>\n";
////			echo "									<tr>\n";
////			echo "										<td nowrap align='center' class='datalabel' width='1%' style='vertical-align:top;text-align:center'>\n";
////			echo "											Hold\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
////			echo "											S&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='SDamage'>x</span>\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
////			echo "											|\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
////			echo "											<span style='vertical-align:top;' class='datalabel' id='SMinRoll'>y</span>\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
////			echo "											M&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='MDamage'>x</span>\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
////			echo "											|\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
////			echo "											<span style='vertical-align:top;' class='datalabel' id='MMinRoll'>y</span>\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
////			echo "											L&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='LDamage'>x</span>\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
////			echo "											|\n";
////			echo "										</td>\n";
////			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
////			echo "											<span style='vertical-align:top;' class='datalabel' id='LMinRoll'>y</span>\n";
////			echo "										</td>\n";
////			echo "									</tr>\n";
////			echo "									<tr>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>Dissipate</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
////			echo "									</tr>\n";
////			echo "									<tr>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>Heat</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
////			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
////			echo "									</tr>\n";
//			echo "								</table>\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
//			echo "					</table>\n";
//			echo "				<div>\n";
//			echo "			</td>\n";
//			echo "			<td width='30%' valign='top'>\n";
//			echo "				<a href='#' onclick=\"location.href='".$locmeli."'\">&nbsp;&nbsp;&nbsp;&nbsp;<img src='./images/confirm.png' width='80px'></a><br>\n";
//			echo "			</td>\n";
//			echo "		</tr>\n";
//			echo "	</table>\n";
//			echo "</div>\n";
//
//			echo "<script>\n";
////			if ($array_MVMT[$chosenMechIndex] != null) {
////				echo "	movement = $array_MVMT[$chosenMechIndex]\n";
////			}
////			if ($array_WPNSFIRED[$chosenMechIndex] != null) {
////				echo "	weaponsfired = $array_WPNSFIRED[$chosenMechIndex]\n";
////			}
//			echo "	setMovementFlags($array_MECH_DBID[$chosenMechIndex], $array_MVMT[$chosenMechIndex], $array_WPNSFIRED[$chosenMechIndex]);\n";
//			echo "	setFireValues($array_MVMT[$chosenMechIndex], $array_WPNSFIRED[$chosenMechIndex]);\n";
//			echo "  document.getElementById('editMovementValues').style.visibility='visible';\n";
//			echo " 	$('#editMovementValues').show();\n";
//			echo "</script>\n";
//		}
//	}
?>

</body>

</html>
