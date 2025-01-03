<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedUnit = $_SESSION['option1'];

	$isAdmin = $_SESSION['isAdmin'];

	$opt2 = $_SESSION['option2'];
	$showplayerdata_topleft = $opt2;

	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$opt4 = $_SESSION['option4'];
	$showDistancesHexes = $opt4;

	function textTruncate($text, $chars=25) {
		if (strlen($text) <= $chars) {
			return $text;
		}
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = $text."...";
		return $text;
	}
	function getMULImageByName($unitname) {
		$image = "images/units/Generic_Mech.gif";

		$dir = 'images/units_mul/';
		$startChar = mb_substr($unitname, 0, 3); // use first 3 chars to list files to keep the result list as small as possible
		if ($startChar == "ELE") {
			// echo "<script>console.log('SEARCHING: >>" . $startChar . "<<');</script>";
			$startChar = "Ele";
		}

		$files = glob($dir."{$startChar}*.png");
		foreach ($files as &$img) {
			// echo "<script>console.log('>>" . trim($img) . "<<');</script>";

			$imagenametrimmed_a = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagenametrimmed = str_replace("'", "", $imagenametrimmed_a);

			// echo "<script>console.log('UNITNAME: >>" . $unitname . "<<');</script>";

			$unitnametrimmed_a = str_replace('ELE ', 'Elemental ', trim($unitname));
			$unitnametrimmed_b = str_replace('BA ', 'Battle Armor ', trim($unitnametrimmed_a));
			$unitnametrimmed_c = str_replace('&apos;', '', trim($unitnametrimmed_b));
			$unitnametrimmed_d = str_replace(' ', '', trim($unitnametrimmed_c));
			$unitnametrimmed_e = str_replace('[CV]', '', trim($unitnametrimmed_d));
			$unitnametrimmed_f = str_replace('[BA]', '', trim($unitnametrimmed_e));
			$unitnametrimmed_g = str_replace('[BM]', '', trim($unitnametrimmed_f));
			$unitnametrimmed_h = str_replace('Rec.', 'Reconnaissance', trim($unitnametrimmed_g));
			$unitnametrimmed_i = str_replace('Veh.', 'Vehicle', trim($unitnametrimmed_h));
			$unitnametrimmed = strtolower($unitnametrimmed_i);

			// echo "<script>console.log('SEARCHING: >>" . $imagenametrimmed . " ? " . $unitnametrimmed . "<<');</script>";

			if (strpos($imagenametrimmed,$unitnametrimmed) !== false) {
				// echo "<script>console.log('FOUND: >>" . $imagenametrimmed . " ? " . $unitnametrimmed . "<<');</script>";
				$image = str_replace(' ', '%20', trim($img));
				break;
			}
		}
		return $image;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net)</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/jquery.jscrollpane.css">
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
	<script type="text/javascript" src="./scripts/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/functions.js"></script>
	<script type="text/javascript" src="./scripts/specialunitabilities.js"></script>

	<style>
		.scroll-pane {
			width: 100%;
			height: 100px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 100px;
		}
	</style>
</head>

<body>
	<script>
		$(function() {
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			$('.scroll-pane').jScrollPane();
		});

		function showSpecialAbility(p) {
			document.getElementById("specialabilitiescontainer").style.visibility = "visible";
			document.getElementById("linkToCompleteAbilitiesList").href = "gui_show_specialabilities.php?sa=" + p;

			showSpecialUnitAbility(p);
		}

		function closeSpecialAbilities() {
			document.getElementById("specialabilitiescontainer").style.visibility = "hidden";
		}

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
//
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
//							fired = 1; // not fired on purpose to cool down (or sprinted)
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
//
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
	if (!isset($_GET["formationid"])) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
	}
	$formationid = $_GET["formationid"];
	if (empty($formationid)) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
	}
	if (isset($_GET["chosenunit"])) {
		$chosenUnitIndex = $_GET["chosenunit"];
		if (empty($chosenUnitIndex)) {
			$chosenUnitIndex = 1;
		}
	} else {
		$chosenUnitIndex = 1;
	}

	require('./db_getdata.php');

	echo "<script>\n";
	echo "	var currentRound = ".$CURRENTROUND.";\n";
	echo "	var gameid = ".$gid.";\n";
	echo "	var chosenunitindex = ".$chosenUnitIndex.";\n";
	echo "	var chosenunitdbid = ".$array_UNIT_DBID[$chosenUnitIndex].";\n";
	echo "	var unitmodel = '".$array_UNIT_MODEL[$chosenUnitIndex]."';\n";
	echo "	var shortdamage = ".$array_DMG_SHORT[$chosenUnitIndex].";\n";
	echo "	var mediumdamage = ".$array_DMG_MEDIUM[$chosenUnitIndex].";\n";
	echo "	var longdamage = ".$array_DMG_LONG[$chosenUnitIndex].";\n";
	echo "	var movementpointsground = ".$array_MV[$chosenUnitIndex].";\n";
	if ($array_MVJ[$chosenUnitIndex] != null) {
		echo "	var movementpointsjump = ".$array_MVJ[$chosenUnitIndex].";\n";
	} else {
		echo "	var movementpointsjump = 0;\n";
	}
	echo "	var maximalarmorpoints = ".$array_A_MAX[$chosenUnitIndex].";\n";
	echo "	var maximalstructurepoints = ".$array_S_MAX[$chosenUnitIndex].";\n";

	echo "	var currentA = ".$array_A[$chosenUnitIndex].";\n";
	echo "	var currentS = ".$array_S[$chosenUnitIndex].";\n";

	echo "	var originalunitimage = '".$array_UNIT_IMG_URL[$chosenUnitIndex]."';\n";
	echo "	var deadunitimage = 'skull.png';\n";
	echo "	var originalTMM = $array_TMM[$chosenUnitIndex];\n";
	echo "	var unitType = '$array_TP[$chosenUnitIndex]';\n";
	echo "	var ENGN_PREP = $array_ENGN_PREP[$chosenUnitIndex];\n";
	echo "	var FCTL_PREP = $array_FRCTRL_PREP[$chosenUnitIndex];\n";
	echo "	var MP_PREP = $array_MP_PREP[$chosenUnitIndex];\n";
	echo "	var WPNS_PREP = $array_WPNS_PREP[$chosenUnitIndex];\n";

	if ($array_CV_ENGN_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_ENGN_PREP = $array_CV_ENGN_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_ENGN_PREP = 0;\n";
	}
	if ($array_CV_FRCTRL_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_FCTL_PREP = $array_CV_FRCTRL_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_FCTL_PREP = 0;\n";
	}
	if ($array_CV_WPNS_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_WPNS_PREP = $array_CV_WPNS_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_WPNS_PREP = 0;\n";
	}
	if ($array_CV_MOTV_A_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVA_PREP = $array_CV_MOTV_A_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_MOTVA_PREP = 0;\n";
	}
	if ($array_CV_MOTV_B_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVB_PREP = $array_CV_MOTV_B_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_MOTVB_PREP = 0;\n";
	}
	if ($array_CV_MOTV_C_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVC_PREP = $array_CV_MOTV_C_PREP[$chosenUnitIndex];\n";
	} else {
		echo "	var CV_MOTVC_PREP = 0;\n";
	}

	echo "	var HT_PREP = $array_HT_PREP[$chosenUnitIndex];\n";
	if ($array_MVTYPE[$chosenUnitIndex] != null) {
		echo "	var MV_TYPE = '$array_MVTYPE[$chosenUnitIndex]';\n";
	} else {
		echo "	var MV_TYPE = '';\n";
	}
	if ($array_MOUNTED_UNITID[$chosenUnitIndex] != null) {
		echo "	var MOUNTED_UNITID = ".$array_MOUNTED_UNITID[$chosenUnitIndex].";\n";
	} else {
		echo "	var MOUNTED_UNITID = 0;\n";
	}
	if ($array_MOUNTED_ON_UNITID[$chosenUnitIndex] != null) {
		echo "	var MOUNTED_ON_UNITID = ".$array_MOUNTED_ON_UNITID[$chosenUnitIndex].";\n";
	} else {
		echo "	var MOUNTED_ON_UNITID = 0;\n";
	}

	echo "	var playerId = ".$pid.";\n";
	if ($showDistancesHexes != null) {
		echo "	var showDistancesHexes = ".$showDistancesHexes.";\n";
	} else {
		echo "	var showDistancesHexes = 0;\n";
	}
	echo "</script>\n";
?>

<iframe name="saveframe" id="iframe_save"></iframe>

<div id="specialabilitiescontainer" style="visibility:hidden;" onclick="javascript:closeSpecialAbilities();">

	<div class="hudcenteranimation">
		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" style="enable-background:new 0 0 1000 1000;" xml:space="preserve">
			<circle class="st0" cx="500" cy="500" r="302.8">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="360 500 500" dur="100s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st1" cx="500" cy="500" r="237.7">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="360 500 500" dur="40s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st2" cx="500" cy="500" r="366.8">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="-360 500 500" dur="50s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st3" cx="500" cy="500" r="395.1"></circle>
		</svg>
	</div>

	<br>
	<br>
	<table width="100%" height="70%">
		<tr>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<td width="80%">
				<table class="options" width="100%" style="height:100%;" cellspacing=4 cellpadding=8 border=0px>
					<tr>
						<td class="datalabel" id="sa_name" align="left" width="90%" style="font-size:1.2em;">...</td><td nowrap class="datalabel" id="sa_abbreviation" align="right" width="10%" style="font-size:1.2em;">...</td>
					</tr>
					<tr>
						<td class="datavalue_thinflow" style="font-size:0.75em;" align="left">
							<span  id="sa_source">...</span>, <span id="sa_page">...</span>
						</td>
						<td nowrap class="datavalue_thinflow" id="sa_type">...</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr>
						<td height="100%" colspan="2" align="left" valign="top">
							<div class='scroll-pane' width="100%" style="width:100%;">
								<table width="100%"><tr><td class="datavalue_thinflow" id="sa_rule">...</td></tr></table>
							</div>
						</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr>
						<td nowrap class="datavalue_thin" colspan="2" align="center"><a id="linkToCompleteAbilitiesList" href="#">Show all</a></td>
					</tr>
				</table>
			</td>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<!-- <td width="10%" align="left" valign="top"><a href="javascript:closeSpecialAbilities();">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-xmark" style="font-size:3em;"></i></a></td> -->
		</tr>
	</table>
</div>

<div id="cover"></div>

<div id="header">
	<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
		<tr>
			<td nowrap onclick="location.href='./index.html'" width="60px" style="width:100px;background:rgba(50,50,50,1.0);text-align:center;vertical-align:middle;">
				<div><a style="color:#eee;" href="./index.html">&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
			</td>
			<td nowrap onclick="location.href='./gui_select_unit.php'" style="width:100px;background:rgba(56,87,26,1.0);">
				<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
			</td>
			<td style="width:5px;">&nbsp;</td>
<?php
	$size = sizeof($array_UNIT_MODEL);
	for ($i11 = 1; $i11 <= sizeof($array_UNIT_MODEL); $i11++) {
		if ($array_ACTIVE_BID[$i11] == "0") {
			$size = $size - 1;
		}
	}
	$width = ceil(100 / $size);
	$heatimage = array();
	$currentUnitStatusImage = "./images/check_red.png";
	$currentmeli = "";
	$currentPhaseButton = "./images/top-right_phase01.png";

	$currentUnitMovement = 0;
	$currentUnitFired = 0;

	$atLeastOneValidUnitInFormation = 0;

	for ($i4 = 1; $i4 <= sizeof($array_UNIT_MODEL); $i4++) {
		$unitstatusimage = "./images/check_red.png";
		$mvmt = $array_MVMT[$i4];
		$wpnsfired = $array_WPNSFIRED[$i4];

		if ($array_TP[$i4] == "BA") {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px' width='0px'>";
		} else {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px'>";
		}
		$phaseButton = "./images/top-right_phase01.png";
		if ($mvmt == 0 && $wpnsfired == 0) {
			$unitstatusimage = "./images/check_red.png";
			$phaseButton = "./images/top-right_phase01.png";
		}
		if ($mvmt > 0 && $wpnsfired == 0) {
			$unitstatusimage = "./images/check_yellow.png";
			$phaseButton = "./images/top-right_phase02.png";
		}
		if ($mvmt > 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			$unitstatusimage = "./images/check_green.png";
			$phaseButton = "./images/top-right_phase03.png";
		}
		if ($mvmt == 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			// Error! Unit has fired but no movement was specified! Ask again!
		}
		if ($array_UNIT_IMG_STATUS[$i4] == "images/DD_BM_04.png") {
			$phaseButton = "./images/top-right_phase00.png";
		}

		$memodel = $array_UNIT_MODEL[$i4];
		$maxLength = 30;
		if (strlen($memodel) > $maxLength) {
			$memodel = substr($memodel, 0, $maxLength - 3);
			$memodel = $memodel . "...";
		}

		if ($array_ACTIVE_BID[$i4] == "0") {
			$memodel = "--- BIDDEN AWAY ---";
		}

		if ($array_UNIT_NUMBER[$i4] == "") {
			$mn = "-";
		} else {
			$mn = $array_UNIT_NUMBER[$i4];
		}

		$meli="./gui_play_unit.php?formationid=".$formationid."&chosenunit=".$i4;
		if ($chosenUnitIndex == $i4) {
			$locmeli = $meli;
			$currentUnitStatusImage = $unitstatusimage;
			$currentmeli = $meli;
			$currentPhaseButton = $phaseButton;

			$currentUnitMovement = $mvmt;
			$currentUnitFired = $wpnsfired;

			if ($array_ACTIVE_BID[$i4] == "1") {
				echo "			<td width='".$width."%' nowrap><table width='100%' height='100%' cellspacing='0' cellpadding='0' class='unitselect_button_active_play_left' style='animation: glow 1s infinite alternate;'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img id='unitstatusimagemenu' style='vertical-align:middle;' src='".$array_UNIT_IMG_STATUS[$i4]."' height='25px' width='23px'><br><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span></div></td><td>&nbsp;</td><td nowrap><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<span style='font-size:24px'>".$array_PILOT[$i4]."</span>&nbsp;&nbsp;<img src='".$unitstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".textTruncate($memodel, 18)."</span></div></td><td align='left' style='align:left;' nowrap width='100%'><img src='images/unit_indicator.png' height='42px;'></td></tr></table></td>\r\n";
				$atLeastOneValidUnitInFormation = $atLeastOneValidUnitInFormation + 1;
			}
		} else {
			if ($array_ACTIVE_BID[$i4] == "1") {
				echo "			<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' height='100%' cellspacing='0' cellpadding='0' class='unitselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$array_UNIT_IMG_STATUS[$i4]."' height='25px' width='23px'><br><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span></div></td><td>&nbsp;</td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$unitstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".textTruncate($memodel, 18)."</span></div></td></tr></table></td>\r\n";
				$atLeastOneValidUnitInFormation = $atLeastOneValidUnitInFormation + 1;
			} else {
				echo "			<td style='display:none;visibility:hidden;' width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='unitselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$array_UNIT_IMG_STATUS[$i4]."' height='25px' width='23px'><br><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span></div></td><td>&nbsp;</td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$unitstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".textTruncate($memodel, 18)."</span></div></td></tr></table></td>\r\n";
			}
		}
		echo "			<td style='width:5px;'>&nbsp;</td>\r\n";
	}
	if ($atLeastOneValidUnitInFormation == 0) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>\r\n";
		header("Location: ./gui_select_unit.php");
	}
?>
			<!-- <td style="width:100px;" style="width:100px;" nowrap width="100px" style="background:rgba(50,50,50,1.0);text-align:center;vertical-align:middle;display:block;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td> -->
			<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' style='height:auto;display:block;' width='60px' height='60px'></td>
		</tr>

<?php
	if ($playMode) {
		echo "		<tr><td colspan='999' style='background:#050505;height:5px;'></td></tr>\r\n";
	} else {
		echo "		<tr><td colspan='999' style='background:#da8e25;height:5px;'></td></tr>\r\n";
	}
?>

	</table>
</div>

<div><?php echo "<img src='".$array_PILOT_IMG_URL[$chosenUnitIndex]."' id='pilotimage' width='80px' height='80px'>" ?></div>
<div id="faction" align="center"><?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='50px' height='50px'>" ?></div>
<div id="unit_number" align="center" onclick='javascript:hideTopRightPanel();'>#<?= $array_UNIT_NUMBER[$chosenUnitIndex] ?><br><?= strtoupper($FORMATION) ?></div>

<?php
	if ($useMULImages == 0) {
		echo "<div id='unit'><img id='unitimage' src='" . $array_UNIT_IMG_URL[$chosenUnitIndex] . "'></div>\n";
	} else if ($useMULImages == 1) {
		echo "<div id='unit'><img id='unitimage' src='" . getMULImageByName($array_UNIT_MODEL[$chosenUnitIndex]) . "'></div>\n";
	}
	echo "<script>var unitImageURL='".$array_UNIT_IMG_URL[$chosenUnitIndex]."';</script>\n";
	echo "<script>var unitImageURLMUL='".getMULImageByName($array_UNIT_MODEL[$chosenUnitIndex])."';</script>\n";
?>

<div id="topleft">
	<span style="font-size: 18px; color: #eeeeee;"><?php echo "$FORMATION"; ?></span>
	<br>
	<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenUnitIndex]"; ?></span>
	<br>
	<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_UNIT_MODEL[$chosenUnitIndex]" ?></span>
</div>

<div id="topright" onclick='javascript:hideTopRightPanel();'>
	<img id='toprightimage' onclick='javascript:hideTopRightPanel();' src='./images/top-right_02.png' style='height:125px;'>
</div>

<div id="unitname">
    <?= strtoupper($array_UNIT_NAME[$chosenUnitIndex]); ?>
</div>

<?php
	//echo "<div id='player_image' onclick='location.href=\"gui_show_playerlist.php\"'>\n";
	//echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>\n";
	//echo "</div>\n";
	echo "<div id='pilotrank'>\n";
	echo "  <img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$chosenUnitIndex].".png' width='30px' height='30px'>\n";
	echo "</div>\n";
	if ($pid == $formationplayerid) {
		// Current Unit is playable by current user
		$playable = true;
	} else {
		$playable = false;
	}

	if ($array_ACTIVE_BID[$chosenUnitIndex] == "0") {
		$playable = false;
	}

	if (!$playable) {
		if ($hideNotOwnedUnit) {
			echo "<div id='blockNotOwnedUnits'></div>\r\n";
		}
	}

	echo "<script type='text/javascript'>\r\n";
	if ($showplayerdata_topleft == 1) {
		// show top left pilot info
		echo "	$('#pilotimage').show();\r\n";
		echo "	$('#faction').show();\r\n";
		echo "	$('#pilotrank').show();\r\n";
		echo "	$('#topleft').show();\r\n";
		echo "	$('#unitname').hide();\r\n";
	} else {
		// do not show pilot information
		echo "	$('#pilotimage').hide();\r\n";
		echo "	$('#faction').hide();\r\n";
		echo "	$('#pilotrank').hide();\r\n";
		echo "	$('#topleft').hide();\r\n";
		echo "	$('#unitname').show();\r\n";
	}
	echo "	setStructuralDamageCache($array_S[$chosenUnitIndex]);\r\n";
	echo "</script>\r\n";
?>

<div id="pv" onclick='javascript:hideTopRightPanel();'>
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">PV:&nbsp;</span>
	<span style="font-size: 36px; color: #da8e25; vertical-align: middle; font-weight: bold;"><?php echo "$array_PV[$chosenUnitIndex]"; ?></span>
</div>

<div class="datatable">
	<table width="100%" style="height:100%;">
		<tr>
			<td width="0%" valign="bottom" align="center">
				<div id="TargetingComputer" class="dataarea_red" style="font-size:0;">
					<div class="dataarea_content">
						<table width="100%">
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="1" valign="top"><b>S.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="1" id="TC_SKILL" class="datalabel" width="20%" align="right">
									<?php echo "$array_SKILL[$chosenUnitIndex]"; ?>
								</td>
								<td nowrap width="90%" rowspan="2" colspan="2" align="right" id="ToHitResult" class="datalabel_big" style="color:#da8e25;vertical-align:top;text-align:right;font-weight:bold;">5</td>
							</tr>
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="1" valign="top"><b>A.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="1" id="TC_AMM" class="datalabel" width="20%" align="right">
									0
								</td>
							</tr>
						</table>
					<!-- </div>
					<div class="dataarea_divider_horizontal"></div>
					<div class="dataarea_content"> -->
						<table width="100%">
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="1" valign="top"><b>T.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="3" align="center">
									<table width="100%">
										<tr>
											<td width="90%" nowrap style="text-align:left;" class="datalabel_thin_small">TMM</td>
											<td width="1px" nowrap style="text-align:right;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:reduceEnemyTMM();"><i class="fas fa-minus-square"></i></a></td>
											<td width="50px" nowrap style="text-align:center;min-width:25px;" class="datalabel" id="EnemyTMM" align="center">2</td>
											<td width="1px" nowrap style="text-align:left;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseEnemyTMM();"><i class="fas fa-plus-square"></i></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div class="dataarea_divider_horizontal"></div>
					<div class="dataarea_content">
						<table width="100%">
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="2" valign="top"><b>O.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="3" align="center">
									<table width="100%">
										<tr>
											<td width="90%" nowrap style="text-align:left;" class="datalabel_thin_small">Other</td>
											<td width="1px" nowrap style="text-align:right;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:reduceOther();"><i class="fas fa-minus-square"></i></a></td>
											<td width="50px" nowrap style="text-align:center;min-width:25px;" class="datalabel" id="Other" align="center">0</td>
											<td width="1px" nowrap style="text-align:left;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseOther();"><i class="fas fa-plus-square"></i></a></td>
										</tr>
										<tr>
											<td width="90%" nowrap style="text-align:left;" class="datalabel_thin_small">Forrest</td>
											<td width="1px" nowrap style="text-align:right;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:reduceForrest();"><i class="fas fa-minus-square"></i></a></td>
											<td width="50px" nowrap style="text-align:center;min-width:25px;" class="datalabel" id="Forrest" align="center">0</td>
											<td width="1px" nowrap style="text-align:left;" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseForrest();"><i class="fas fa-plus-square"></i></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td nowrap style="text-align:left;vertical-align:middle;" class="datalabel"><label class='bigcheck'><input type='checkbox' onchange="setCover();" class='bigcheck' name='ToHitCover' id='ToHitCover' value='no'/><span class='bigcheck-target'></span></label></td>
								<td nowrap style="text-align:left;vertical-align:middle;" class="datalabel_thin_small" colspan="2">Par. cover</td>
							</tr>
						</table>
					</div>
					<div class="dataarea_divider_horizontal"></div>
					<div class="dataarea_content">
						<table width="100%">
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="1" valign="top"><b>R.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="4">
									<table width="100%">
										<tr>
											<td nowrap width="30%" style="text-align:center;" class="datalabel_thin_small">S</td>
											<td nowrap width="40%" style="text-align:center;" class="datalabel_thin_small">M</td>
											<td nowrap width="30%" style="text-align:center;" class="datalabel_thin_small">L</td>
										</tr>
										<tr>
											<td nowrap width="30%" style="text-align:center;" class="datalabel"><label class='bigcheck'><input onchange="setRangeToShort();" type='checkbox' class='bigcheck' name='ToHitShort' id='ToHitShort' value='no'/><span class='bigcheck-target'></span></label></td>
											<td nowrap width="40%"  style="text-align:center;" class="datalabel"><label class='bigcheck'><input onchange="setRangeToMedium();" type='checkbox' class='bigcheck' name='ToHitMedium' id='ToHitMedium' value='yes'/><span class='bigcheck-target'></span></label></td>
											<td nowrap width="30%" style="text-align:center;" class="datalabel"><label class='bigcheck'><input onchange="setRangeToLong();" type='checkbox' class='bigcheck' name='ToHitLong' id='ToHitLong' value='no'/><span class='bigcheck-target'></span></label></td>
										</tr>
										<tr>
<?php
if ($showDistancesHexes == 1) {
	echo "											<td nowrap width='30%' style='text-align:center;' class='datalabel_thin_small'>&#60;3<span style='font-size:0.6em;'>&#11043;</span></td>\r\n";
	echo "											<td nowrap width='40%' style='text-align:center;' class='datalabel_thin_small'>&#60;12<span style='font-size:0.6em;'>&#11043;</span></td>\r\n";
	echo "											<td nowrap width='30%' style='text-align:center;' class='datalabel_thin_small'>&#60;21<span style='font-size:0.6em;'>&#11043;</span></td>\r\n";
} else {
	echo "											<td nowrap width='30%' style='text-align:center;' class='datalabel_thin_small'>&#60;6&quot;</td>\r\n";
	echo "											<td nowrap width='40%' style='text-align:center;' class='datalabel_thin_small'>&#60;24&quot;</td>\r\n";
	echo "											<td nowrap width='30%' style='text-align:center;' class='datalabel_thin_small'>&#60;42&quot;</td>\r\n";
}
?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</td>

			<td width="60%" valign="bottom">
				<div class="dataarea">
					<table width="100%">
						<tr>
							<td onclick="toggleTargetingComputer();" nowrap style="text-align:center;" width="5%" id="targetcomp" rowspan="2">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-circle-left" style="color:#999;font-size:40px;"></i>&nbsp;&nbsp;&nbsp;</td>
							<td nowrap class="datalabel" width="12%">TP:</td>
							<td nowrap class="datavalue" width="25%" id="unit_type" colspan="3"><?php echo "$array_TP[$chosenUnitIndex]"; ?> <span class='datalabel_thin_small'><?php echo "$array_SZ[$chosenUnitIndex]"; ?>/<?php echo "$array_TON[$chosenUnitIndex]"; ?></span></td>
							<td id="tmmLabel" nowrap class="datalabel" width="12%">TMM:</td>
							<td nowrap class="datavalue" width="13%" id="TMM"><?php echo "$array_TMM[$chosenUnitIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datavalue" style="text-transform: none;" width="13%" id="mv_points">
								<?php echo "$array_MV[$chosenUnitIndex]&rdquo;$array_MVTYPE[$chosenUnitIndex]";
									if ($array_MVJ[$chosenUnitIndex] != null) {
										echo "/$array_MVJ[$chosenUnitIndex]&rdquo;&nbsp;j\r\n";
									} else {
										echo "\r\n";
									}
								?>
							</td>
						</tr>
						<tr>
							<td nowrap class="datavalue_small_special" width="50%" colspan="4" style="text-align:center;" valign="middle" onclick="javascript:window.open('http://www.masterunitlist.info/Unit/Details/<?php echo $array_UNIT_MULID[$chosenUnitIndex] ?>');"><?php echo "$array_ROLE[$chosenUnitIndex]"; ?>&nbsp;&nbsp;<i class="fa-solid fa-square-up-right"></i></td>
							<td nowrap class="datalabel" width="13%" colspan="1" valign="middle" >AMM:</td>
							<td nowrap class="datavalue" width="12%" colspan="1" valign="middle" style="top:0px;bottom:0px;vertical-align:middle;"><span class="datavalue" id="AMM">0</span></td>
							<td nowrap class="datalabel" width="12%" colspan="1">SKL:</td>
							<td nowrap class="datavalue" width="12%" colspan="1" valign="middle" id="skillfield" style="top:0px;bottom:0px;vertical-align:middle;"><?php echo "$array_SKILL[$chosenUnitIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea" id="firepanel">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="10%" style="text-align: left;">DMG:</td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrollshort">S (+0)</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgshort_s"><?php echo "$array_DMG_SHORT[$chosenUnitIndex]"; ?></td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrollmedium">M (+2)</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgmedium_s"><?php echo "$array_DMG_MEDIUM[$chosenUnitIndex]"; ?></td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrolllong">L (+4)</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmglong_s"><?php echo "$array_DMG_LONG[$chosenUnitIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea" id="firepanelhidden" style="visibility: hidden;display:none">
					<table width="100%">
						<tr>
							<td nowrap class="datavalue_thin" width="10%" style="text-align: center;">TRADE ABILITY TO FIRE FOR SPEED</td>
						</tr>
					</table>
				</div>
			</div>
<?php
	if ($array_TP[$chosenUnitIndex] == "BA" || $array_TP[$chosenUnitIndex] == "CV") {
		// Do not show the heat block for all Battle Armor and combat vehicle units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<td nowrap width="25%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_OV[$chosenUnitIndex]; $i1++) {
		echo "								<label class='bigcheck'><input onchange='readCircles($array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='UOV".$i1."' id='UOV".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
							<td nowrap class="datalabel" width="15%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:&nbsp;&nbsp;</td>
							<td nowrap width="2%" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseHT_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" width="2%" id="label_HT_PREP" align="center"><?= $array_HT_PREP[$chosenUnitIndex] ?></td>
							<td nowrap width="36%" style="text-align: right;" id="ht_field" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H1" id="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H2" id="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H3" id="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H4" id="H4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="5%" class="datalabel">A:</td>
							<td nowrap width="95%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_A_MAX[$chosenUnitIndex]; $i1++) {
		echo "							<label class='bigcheck'><input onchange='readCircles($array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
		if ($i1 == 10) {
            echo "<br>\n";
        }
	}
?>
							</td>
							<td align="center" nowrap width="5%" class="datalabel_thin">
								<span id="narcDesc" onclick="javascript:changeNARCDesc();"><?= $array_NARCDESC[$chosenUnitIndex] ?></span>
							</td>
						</tr>
						<tr>
							<td nowrap width="5%" class="datalabel">S:</td>
							<td nowrap width="90%" class="datalabel_thin">
<?php
	for ($i2 = 1; $i2 <= $array_S_MAX[$chosenUnitIndex]; $i2++) {
		echo "							<label class='bigcheck'><input onchange='readCircles($array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
		if ($i2 == 10) {
			echo "<br>\n";
		}
	}
?>
							</td>
							<td align="center" style="text-align:center; margin:0 auto" nowrap width="5%" class="datalabel_thin">
								<label class='bigcheck'><input onchange='readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>);' type='checkbox' class='bigcheck' name='NARC' value='yes'/><span class='bigcheck-target'></span></label>
							</td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="10%" class="datalabel" width="100%">SA:</td>
							<td nowrap width="90%" class="datavalue_thin" style="text-align: left;">
								<table>
									<tr>
										<td nowrap width="99%" class="datavalue_thin" style="text-align: left;" id="sa_field">
											<?php
												$allSpecialAbilities = "";
												$parts = explode(',', $array_SPCL[$chosenUnitIndex]);
												if (sizeof($parts) >= 1) {
													$i = 1;
													foreach ($parts as $part) {

														// These special abilities are special, because they have "-" or "("
														// in the name so that the regular expression down there does not
														// catch them correctly. Remove this if the re is fixed
														$saParameter = "";
														if (substr($part, 0, 3) === "ART") {
															$saParameter = "ART";
														} else if (substr($part, 0, 3) === "BIM") {
															$saParameter = "BIM";
														} else if (substr($part, 0, 3) === "LAM") {
															$saParameter = "LAM";
														} else if (substr($part, 0, 5) === "I-TSM") {
															$saParameter = "I-TSM";
														} else if (substr($part, 0, 5) === "SDS-C") {
															$saParameter = "SDS-C";
														} else if (substr($part, 0, 6) === "SDS-CM") {
															$saParameter = "SDS-CM";
														} else if (substr($part, 0, 6) === "SDS-SC") {
															$saParameter = "SDS-SC";
														} else {
															// This re removed all "#" and "/" from the names
															// also all "-" and "(", ")" should be removed to match
															// them in the javascript to display the ability
															$re = '/^[A-Z][A-Z3][A-Z]*/m';
															preg_match($re, $part, $matches);
															$saParameter = $matches[0];
														}

														if ($i > 1) {
															echo ", ";
														}

														if ($saParameter != null) {
															$pos = strpos($allSpecialAbilities, $saParameter);
															if ($pos !== false) {
																// String is already in the list
															} else {
																if ($i > 1) {
																	$allSpecialAbilities = $allSpecialAbilities."|";
																}
																$allSpecialAbilities = $allSpecialAbilities.$saParameter;
															}
															if ($i == 8) {
																echo "<br>";
															}
															echo "<span class='datavalue_thin' onclick='javascript:showSpecialAbility(\"".$saParameter."\");'>".$part."</span>";
															$i++;
														}
													}
												}
											?>
										</td>
										<td nowrap width="1%" class="datavalue_thin" style="text-align: right;" align="right">
											<!--
											<a href="javascript:showSpecialAbility('<?= $allSpecialAbilities ?>');"><i class="fas fa-info-circle"></i></a>
											-->
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
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td nowrap rowspan="3" style="vertical-align: middle;" valign="middle" align="center" width="15px">
								<div onclick="location.href='save_finalize_round.php?pid=<?= $pid?>';" style="padding: 0 15 0 15;" id="phasebutton" name="phasebutton"><img id="phasebuttonimage" src=<?php echo "'$currentPhaseButton'"; ?> style='height:50px;'></div>
							</td>
							<td nowrap width="65%" class="datalabel_thin">
								<table cellspacing="2" cellpadding="0">
									<tr>
										<td align="center"><img src="./images/buttons/mov01.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov02.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov03.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov04.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov05.png" height='17px' style="border: 0px solid #000000;"></td>
									</tr>
									<tr>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 2, -1);' class='bigcheck' name='MV2_moved2_standstill' id='MV2_moved2_standstill' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 10,-1);' class='bigcheck' name='MV10_moved10_hulldown' id='MV10_moved10_hulldown' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 3, -1);' class='bigcheck' name='MV3_moved3_moved' id='MV3_moved3_moved' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 9, -1);' class='bigcheck' name='MV9_moved9_sprinted' id='MV9_moved9_sprinted' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 4, -1);' class='bigcheck' name='MV4_moved4_jumped' id='MV4_moved4_jumped' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
									</tr>
								</table>
							</td>
							<td id="INFOMOVED" nowrap width="20%" class="datalabel_thin"></td>
						</tr>
						<tr style='margin:2px;height:2px;padding:2px;line-height:2px;font-size:2px;'><td colspan='2' style='margin:2px;height:2px;padding:2px;line-height:2px;font-size:2px;'><hr style='margin:2px;'></td></tr>
						<tr>
							<td nowrap width="65%" id="firecontainer" class="datalabel_thin">
							<table cellspacing="2" cellpadding="0">
								<tr>
									<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, -1, 1);' class='bigcheck' name='WF5_WEAPONSFIRED2' id='WF5_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
									<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, -1, 2);' class='bigcheck' name='WF6_WEAPONSFIRED2' id='WF6_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
									<td nowrap rowspan='2' class="datavalue" style="text-align: right;" align="right"><span style="font-family:'Pathway Gothic One',sans-serif;font-size:60%;text-transform:uppercase;color:#999;">&nbsp;&nbsp;&nbsp;WEAPONS</span></td>
								</tr>
								<tr>
									<td align="center"><img src="./images/buttons/holdfire.png" height='17px' style="border: 0px solid #000000;"></td>
									<td align="center"><img src="./images/buttons/fireweapons.png" height='17px' style="border: 0px solid #000000;"></td>
								</tr>
							</table>
							</td>
							<td id="INFOFIRED" nowrap width="20%" class="datalabel_thin"></td>
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenUnitIndex] == "BA" || $array_TP[$chosenUnitIndex] == "CV") {
		// Do not show the normal critical block for all Battle Armor and combat vehicle units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">EN:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseENGN_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_ENGN_PREP" align="center"><?= $array_ENGN_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" id="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_2" id="CD_E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+1 HT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FC:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseFCTL_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_FCTL_PREP" align="center"><?= $array_FRCTRL_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="90%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" id="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" id="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" id="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" id="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMP_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_MP_PREP" align="center"><?= $array_MP_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" id="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" id="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" id="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" id="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">½ MV</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WN:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseWPNS_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_WPNS_PREP" align="center"><?= $array_WPNS_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" id="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" id="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" id="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" id="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">-1 DMG</td>
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenUnitIndex] == "CV") {
		// Do not show the normal critical block for all Battle Armor and combat vehicle units
		// Do show the vehicle critical block for combat vehicles
		echo "				<div class='dataarea'>\r\n";
	} else {
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	}
?>
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">EN:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" href="javascript:increaseENGN_CV_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_CV_ENGN_PREP" align="center"><?= $array_CV_ENGN_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-E_1" id="CD_CV-E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-E_2" id="CD_CV-E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" colspan="2" width="5%" style="text-align: right;">½ MV, ½ DMG</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FC:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" href="javascript:increaseFCTL_CV_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_CV_FCTL_PREP" align="center"><?= $array_CV_FRCTRL_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="90%" colspan='2' style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_1" id="CD_CV-FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_2" id="CD_CV-FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_3" id="CD_CV-FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_4" id="CD_CV-FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align:right;">WN:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" href="javascript:increaseWPNS_CV_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_CV_WPNS_PREP" align="center"><?= $array_CV_WPNS_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" colspan='2' style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_1" id="CD_CV-W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_2" id="CD_CV-W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_3" id="CD_CV-W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_4" id="CD_CV-W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">-1 DMG</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;" rowspan="2">MO:&nbsp;</td>
							<td colspan="7" style="padding-top:10px;">
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td nowrap colspan="2" width="33%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MA_1" id="CD_CV-MA_1" value="yes"/><span class="bigcheck-target"></span></label>
											<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MA_2" id="CD_CV-MA_2" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
										<td nowrap width="32%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MB_1" id="CD_CV-MB_1" value="yes"/><span class="bigcheck-target"></span></label>
											<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MB_2" id="CD_CV-MB_2" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
										<td nowrap width="33%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(<?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MC_1" id="CD_CV-MC_1" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
									</tr>
									<tr>
										<td nowrap width="33%" colspan="2" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">-2 MV</td>
													<td nowrap style="text-align:right;"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMOTIVEA_PREP();"><i class="fas fa-plus-square"></i></a></td>
													<td nowrap style="text-align:left;" class="datalabel_thin" id="label_CV_MOTIVA_PREP" valign="middle"><?= $array_CV_MOTV_A_PREP[$chosenUnitIndex] ?></td>
												</tr>
											</table>
										</td>
										<td nowrap width="32%" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">½ MV</td>
													<td nowrap style="text-align:right;"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMOTIVEB_PREP();"><i class="fas fa-plus-square"></i></a></td>
													<td nowrap style="text-align:left;" class="datalabel_thin" id="label_CV_MOTIVB_PREP" valign="middle"><?= $array_CV_MOTV_B_PREP[$chosenUnitIndex] ?></td>
												</tr>
											</table>
										</td>
										<td nowrap width="33%" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">0 MV</td>
													<td nowrap style="text-align:right;"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMOTIVEC_PREP();"><i class="fas fa-plus-square"></i></a></td>
													<td nowrap style="text-align:left;" class="datalabel_thin" id="label_CV_MOTIVC_PREP" valign="middle"><?= $array_CV_MOTV_C_PREP[$chosenUnitIndex] ?></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td valign='bottom' style='font-size:0px;'>
				<a onclick='showInfoBar();'    id="InfoButton" href='#' style='font-size:0;'><img style='margin:0;padding:0;' src='./images/selector_02-info.png'     width='50px'></a><br>
				<a onclick='showSoundBoard();' id="SoundBoard" href='#' style='font-size:0;'><img style='margin:0;padding:0;' src='./images/selector_00-sb.png'       width='50px'></a><br>
				<a onclick='showDiceBar();'    id="DiceButton" href='#' style='font-size:0;'><img style='margin:0;padding:0;' src='./images/selector_01-dice.png'     width='50px'></a><br>
				<a onclick='showMoveBar();'    id="MoveButton" href='#' style='font-size:0;'><img style='margin:0;padding:0;' src='./images/selector_04-movement.png' width='50px' id='roundphaseshortcutimage'></a>
			</td>
		</tr>
	</table>
</div>

<div name='bgrightbar' id='bgrightbar'></div>

<div name='soundboard' id='soundboard'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideSoundBoard();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='soundboardpanel' id='soundboardpanel'>
		<table width="100%">
			<tr>
				<td align="right" valign="bottom">
					<div valign="bottom" align="left">
						<table cellspacing="5" cellpadding="2" width="100%">
							<tr>
								<td class='phase_button_normal' onclick="javascript:playSound_01();">1</td>
								<td class='phase_button_normal' onclick="javascript:playSound_02();">2</td>
								<td class='phase_button_normal' onclick="javascript:playSound_03();">3</td>
							</tr>
							<tr>
								<td class='phase_button_normal' onclick="javascript:playSound_04();">4</td>
								<td class='phase_button_normal' onclick="javascript:playSound_05();">5</td>
								<td class='phase_button_normal' onclick="javascript:playSound_06();">6</td>
							</tr>
							<tr>
								<td class='phase_button_normal' onclick="javascript:playSound_07();">7</td>
								<td class='phase_button_normal' onclick="javascript:playSound_08();">8</td>
								<td class='phase_button_normal' onclick="javascript:playSound_09();">9</td>
							</tr>
							<tr>
								<td class='phase_button_normal' colspan="3" onclick="javascript:stopSoundSB();">STOP</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div name='infobar' id='infobar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideInfoBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='infopanel' id='infopanel'>
		<table width="220px">
			<tr>
				<td id='pilotinfo' align="right" valign="bottom">
					<span style="font-size: 18px; color: #eeeeee;"><?php echo "$FORMATION"; ?></span><br>
					<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenUnitIndex]"; ?></span><br>
					<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_UNIT_MODEL[$chosenUnitIndex]" ?></span><br><br>
					<div id="pilotinfo" valign="bottom" align="right">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td rowspan="2">
									<?php echo "<img src='".$array_PILOT_IMG_URL[$chosenUnitIndex]."' width='84px' height='84px' style='border: 1px solid #000000;'>\r\n" ?>
								</td>
								<td style='background-color:#000000;' align='right'>
									<?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='40px' height='40px' style='border: 1px solid #000000;'>\r\n" ?>
								</td>
							</tr>
							<tr>
								<td valign='bottom' align='right'>
									<img src='./images/ranks/<?php echo $factionid ?>/<?php echo $array_PILOT_RANK[$chosenUnitIndex] ?>.png' style='border: 1px solid #000000;' width='40px' height='40px'>
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
	if ($array_TP[$chosenUnitIndex] != "BA") {
		echo "					<div id='criticalhit'>CRIT:<br>-</div>\r\n";
	} else {
		echo "					<div id='criticalhit' style='display:none;'>CRIT:<br>-</div>\r\n";
	}

		echo "					<div id='dice' valign='middle' align='center'>\r\n";
		echo "						<img id='die1' src='./images/dice/d6_0.png' width='65px' height='65px'>\r\n";
		echo "						<img id='die2' src='./images/dice/d6_0.png' width='65px' height='65px'>\r\n";
		echo "					</div>\r\n";

	if ($array_TP[$chosenUnitIndex] == "CV") {
		echo "					<br><div id='motivehit'>MOTV:<br>-</div>\r\n";
		echo "					<div id='motivedice' valign='middle' align='center'>\r\n";
		echo "						<img id='die3' src='./images/dice/bd6_0.png' width='65px' height='65px'>\r\n";
		echo "						<img id='die4' src='./images/dice/bd6_0.png' width='65px' height='65px''>\r\n";
		echo "					</div>\r\n";
	}
?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div id="destroyedIndicator">
	<img style="pointer-events:auto;" src='./images/skull.png' onclick="javascript:hideSkull();" height='250px'>
</div>
<div id="crippledIndicator">
	<img style="pointer-events:auto;" src='./images/crippled.png' onclick="javascript:hideCrippled();" height='250px'>
</div>
<div id="shutdownIndicator">
	<img style="pointer-events:auto;" src='./images/heat.png' onclick="javascript:hideShutdownIndicator();" height='250px'>
</div>
<div id="narcIndicator">
	<img style="pointer-events:auto;" src='./images/narc.png' onclick="javascript:hideNarcIndicator();" height='250px'>
</div>


<script type="text/javascript">
	$("#infobar").hide();
	$("#dicebar").hide();
	$("#movebar").hide();
	$("#soundboard").hide();
	$("#destroyedIndicator").hide();
	$("#crippledIndicator").hide();
	$("#shutdownIndicator").hide();
	$("#narcIndicator").hide();
	setCircles(<?=$array_HT[$chosenUnitIndex]?>,<?=$array_A[$chosenUnitIndex]?>,<?=$array_S[$chosenUnitIndex]?>,<?=$array_ENGN[$chosenUnitIndex]?>,<?=$array_FRCTRL[$chosenUnitIndex]?>,<?=$array_MP[$chosenUnitIndex]?>,<?=$array_WPNS[$chosenUnitIndex]?>,<?=$array_CV_ENGN[$chosenUnitIndex]?>,<?=$array_CV_FRCTRL[$chosenUnitIndex]?>,<?=$array_CV_WPNS[$chosenUnitIndex]?>,<?=$array_CV_MOTV_A[$chosenUnitIndex]?>,<?=$array_CV_MOTV_B[$chosenUnitIndex]?>,<?=$array_CV_MOTV_C[$chosenUnitIndex]?>,<?=$array_USEDOVERHEAT[$chosenUnitIndex]?>,<?=$array_MVMT[$chosenUnitIndex]?>,<?=$array_WPNSFIRED[$chosenUnitIndex]?>,2,0,'<?=$array_UNIT_STATUSSTRING[$chosenUnitIndex]?>', <?=$array_NARCED[$chosenUnitIndex]?>);
</script>

<div id="footer"></div>

<div id="bottomleft"><img src="./images/bottom-left.png" width="200px"></div>

<div align="center" id="settings">
	<a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:showUnit()"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<!-- <a href="#" onclick="javascript:window.location.reload(true)"><i class="fas fa-redo"></i></a>&nbsp;&nbsp; -->
	<a href="javascript:textSize(0)"><i class="fas fa-minus-square"></i></a>&nbsp;&nbsp;
	<a href="javascript:textSize(1)"><i class="fas fa-plus-square"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:changeWallpaper()"><i class="fas fa-image"></i></a>&nbsp;&nbsp;
	<a href="./gui_edit_option.php"><i class="fas fa-cog"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="./images/bt-logo2.png" width="250px"></div>

<script>
	document.addEventListener('readystatechange', event => {
		if (event.target.readyState === "complete") {
			$("#cover").fadeOut(175, "linear", function() {
				$("#cover").hide();
				document.getElementById("cover").style.visibility = "hidden";
			});
		}
	});
</script>

<?php
//	echo "<script>\n";
//	echo "	setMovementFlags($array_UNIT_DBID[$chosenUnitIndex], $array_MVMT[$chosenUnitIndex], $array_WPNSFIRED[$chosenUnitIndex]);\n";
//	echo "	setFireValues($array_MVMT[$chosenUnitIndex], $array_WPNSFIRED[$chosenUnitIndex]);\n";
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
////			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 1);' type='checkbox' class='bigcheck' name='MV1_IMMOBILE' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 2);' type='checkbox' class='bigcheck' name='MV2_STANDSTILL' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 10);' type='checkbox' class='bigcheck' name='MV10_HULLDOWN' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 3);' type='checkbox' class='bigcheck' name='MV3_MOVED' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 9);' type='checkbox' class='bigcheck' name='MV9_SPRINTED' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 4);' type='checkbox' class='bigcheck' name='MV4_JUMPED' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
//			if ($array_TP[$chosenUnitIndex] == "BA") {
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
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 5);' type='checkbox' class='bigcheck' name='WF5_WEAPONSFIRED' id='WF5_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;&nbsp;&nbsp;HOLD FIRE\n";
// 			echo "										</td>\n";
//			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 6);' type='checkbox' class='bigcheck' name='WF6_WEAPONSFIRED' id='WF6_WEAPONSFIRED'value='yes'/><span class='bigcheck-target'></span></label>&nbsp;&nbsp;&nbsp;FIRE\n";
// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//// 			echo "										</td>\n";
////			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
////			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_UNIT_DBID[$chosenUnitIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
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
////			if ($array_MVMT[$chosenUnitIndex] != null) {
////				echo "	movement = $array_MVMT[$chosenUnitIndex]\n";
////			}
////			if ($array_WPNSFIRED[$chosenUnitIndex] != null) {
////				echo "	weaponsfired = $array_WPNSFIRED[$chosenUnitIndex]\n";
////			}
//			echo "	setMovementFlags($array_UNIT_DBID[$chosenUnitIndex], $array_MVMT[$chosenUnitIndex], $array_WPNSFIRED[$chosenUnitIndex]);\n";
//			echo "	setFireValues($array_MVMT[$chosenUnitIndex], $array_WPNSFIRED[$chosenUnitIndex]);\n";
//			echo "  document.getElementById('editMovementValues').style.visibility='visible';\n";
//			echo " 	$('#editMovementValues').show();\n";
//			echo "</script>\n";
//		}
//	}
?>
</body>

</html>
