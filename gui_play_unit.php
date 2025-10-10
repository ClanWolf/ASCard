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

	//$pid    = filter_var($_SESSION['playerid'], FILTER_VALIDATE_INT);
	$pid    = isset($_SESSION["playerid"]) ? filter_var($_SESSION["playerid"], FILTER_VALIDATE_INT) : "not found";
	$gid    = filter_var($_SESSION['gameid'], FILTER_VALIDATE_INT);
	$hgid   = filter_var($_SESSION['hostedgameid'], FILTER_VALIDATE_INT);
	$pimage = htmlspecialchars($_SESSION['playerimage'], ENT_NOQUOTES);

	$fadeOutDuration  = isset($_GET["fod"]) ? filter_var($_GET["fod"], FILTER_VALIDATE_INT) : 150;
	$scrollToView     = isset($_GET["stv"]) ? filter_var($_GET["stv"], FILTER_VALIDATE_INT) : 0;

	$isAdmin    = filter_var($_SESSION['isAdmin'], FILTER_VALIDATE_BOOLEAN);
	$isGodAdmin = filter_var($_SESSION['isGodAdmin'], FILTER_VALIDATE_BOOLEAN);

	$opt1                   = filter_var($_SESSION['option1'], FILTER_VALIDATE_BOOLEAN);
	$opt2                   = filter_var($_SESSION['option2'], FILTER_VALIDATE_BOOLEAN);
	$opt3                   = filter_var($_SESSION['option3'], FILTER_VALIDATE_BOOLEAN);
	$opt4                   = filter_var($_SESSION['option4'], FILTER_VALIDATE_BOOLEAN);
	$hideNotOwnedUnit       = $opt1;
	$showplayerdata_topleft = $opt2;
	$playMode               = $opt3;
	$showDistancesHexes     = $opt4;
	$currentcommandid       = $_SESSION['commandid'];

	if ($pid === "not found") {
		echo "LOGIN EXPIRED. REDIRECT TO LOGIN...<br>\n";
		echo "<script>top.location.assign('./login.php?auto=1');</script>";
	}

	function textTruncate($text, $chars=25) {
		if (strpos($text, " | ") !== false) {
			$parts = explode(" | ", $text);
			$text = $parts[1];
		}

		if (strlen($text) <= $chars) {
			return $text;
		}
		$text = $text." ";
        $textb = mb_convert_encoding($text, 'UTF-8', mb_list_encodings());
		$textc = html_entity_decode($textb, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = mb_substr($textc,0,$chars,'ASCII');
		$text = $text."...";

		return $text;
	}

	function textShorten($text) {
		if (strpos($text, " | ") !== false) {
			$parts = explode(" | ", $text);
			$text = $parts[1];
		}

		$text = $text." ";
        $text = mb_convert_encoding($text, 'UTF-8', mb_list_encodings());
		$text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = str_replace("Prime", "", $text);
		$text = str_replace("(Squad5)", "(Sqd3)", $text);
		$text = str_replace("(Squad5)", "(Sqd4)", $text);
		$text = str_replace("(Squad5)", "(Sqd5)", $text);
		$text = str_replace("(Squad5)", "(Sqd6)", $text);
		$text = str_replace("(Squad5)", "(Sqd7)", $text);

		return $text;
	}

	function getMULImageByName($unitname) {
		$image = "images/units/Generic_Mech.gif";

		$arr = explode('t | ', $unitname);
		$unitname = $arr[1];
		//echo "<script>console.log('SEARCHING: >>".$unitname."<<');</script>";

		$dir = 'images/units_mul/';
		$startChar = mb_substr($unitname, 0, 3); // use first 3 chars to list files to keep the result list as small as possible
		if ($startChar == "ELE") {
			//echo "<script>console.log('SEARCHING: >>" . $startChar . "<<');</script>";
			$startChar = "Ele";
		}

		$files = glob($dir."{$startChar}*.png");
		foreach ($files as &$img) {
			//echo "<script>console.log('>>" . trim($img) . "<<');</script>";

			$imagenametrimmed_a = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagenametrimmed = str_replace("'", "", $imagenametrimmed_a);

			//echo "<script>console.log('UNITNAME: >>" . $unitname . "<<');</script>";

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

			//echo "<script>console.log('SEARCHING: >>" . $imagenametrimmed . " ? " . $unitnametrimmed . "<<');</script>";

			if (strpos($imagenametrimmed,$unitnametrimmed) !== false) {
				//echo "<script>console.log('FOUND: >>" . $imagenametrimmed . " ? " . $unitnametrimmed . "<<');</script>";
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
	<meta name="apple-mobile-web-app-title" content="ASCard">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

	<link rel="manifest" href="/app/ascard.webmanifest">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/jquery.jscrollpane.css">
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
	<script type="text/javascript" src="./scripts/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/functions.js"></script>
	<script type="text/javascript" src="./scripts/functions_AF.js"></script>
	<script type="text/javascript" src="./scripts/functions_BA.js"></script>
	<script type="text/javascript" src="./scripts/functions_BM.js"></script>
	<script type="text/javascript" src="./scripts/functions_CV.js"></script>
	<script type="text/javascript" src="./scripts/specialunitabilities.js"></script>
	<script type="text/javascript" src="./scripts/spa.js"></script>

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
	<iframe name="pollframe" id="iframe_serverpoll" src="server_poll.php"></iframe>

	<script>
		$(function() {
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			//$('.scroll-pane').jScrollPane();
		});
		$(document).ready(function() {
			let realhightofscrollbar = document.getElementById("scrollcontainer").offsetHeight;
			//console.log(realhightofscrollbar);
			var scrollcontainerdivs = document.getElementsByClassName("scroll-pane");
			for(var i=0; i < scrollcontainerdivs.length; i++) {
				scrollcontainerdivs[i].style.height = realhightofscrollbar+"px";
			}
		});
		function showSpecialAbility(p) {
			// If fadeIn is used here, css animation does not work anymore
			playTapSound();
			document.getElementById("specialabilitiescontainer").style.visibility = "visible";
			document.getElementById("linkToCompleteAbilitiesList").href = "gui_show_specialabilities.php?sa=" + p;
			showSpecialUnitAbility(p);
		}
		function closeSpecialAbilities() {
			// If fadeIn is used here, css animation does not work anymore
			playTCCloseSound();
			document.getElementById("specialabilitiescontainer").style.visibility = "hidden";
		}
		function showSpaInfo(spa) {
			if (spa !== "") {
				playTapSound();
				document.getElementById("spaInfoContainer").style.visibility = "visible";
				showSpa(spa);
			}
		}
		function closeSpaInfo() {
			// If fadeIn is used here, css animation does not work anymore
			playTCCloseSound();
			document.getElementById("spaInfoContainer").style.visibility = "hidden";
		}
		function showGameMenu() {
			if (document.getElementById("gamemenu").style.visibility == "visible") {
				playTCCloseSound();
				$("#gamemenu").fadeOut(300, "linear", function() {
					document.getElementById("gamemenu").style.visibility = "hidden";
					document.getElementById("gamemenu").style.display = "none";
					document.getElementById("gamemenubutton").innerHTML = "<i style='color:#eee;' class='fa-solid fa-angles-down'></i>";
				});
			} else {
				playTapSound();
				document.getElementById("gamemenu").style.visibility = "visible";
				$("#gamemenu").fadeIn(300, "linear", function() {
					document.getElementById("gamemenu").style.display = "block";
					document.getElementById("gamemenubutton").innerHTML = "<i style='color:#eee;' class='fa-solid fa-angles-up'></i>";
				});

				// Synchronize css glowing animations
				let anims = document.getAnimations()
				for(let i = 0; i < anims.length; i++) {
					if (i == 0) {
						pulseStart = anims[i].currentTime;
					}
					anims[i].currentTime = pulseStart;
				}
			}
		}

		// Reload the polling iFrame every 2 seconds
		(function(){
		    document.getElementById("iframe_serverpoll").src="server_poll.php";
		    setTimeout(arguments.callee, 3000);
		})();
	</script>
<?php
	$file = file_get_contents('./version.txt', true);
	$version = $file;
	if (!isset($_GET["formationid"])) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
	}
	$formationid = filter_var($_GET["formationid"], FILTER_VALIDATE_INT);

	if (empty($formationid)) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
	}
	if (isset($_GET["chosenunit"])) {
		$chosenUnitIndex = filter_var($_GET["chosenunit"], FILTER_VALIDATE_INT);
		if (empty($chosenUnitIndex)) {
			$chosenUnitIndex = 1;
		}
	} else {
		$chosenUnitIndex = 1;
	}

	// Store latest unit opened
	$latestUnitUrl = basename($_SERVER['REQUEST_URI']);
	require('./db_getdata.php');

	if ($array_ACTIVE_BID[$chosenUnitIndex] == 0) { // check if the chosen index is active bid. Advance if not
		for ($x = 1; $x <= 20; $x++) {
			if ($array_ACTIVE_BID[$x] == 1) {
				$chosenUnitIndex = $x;
				break;
			}
		}
	}

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
	echo "	var originalTMM = ".$array_TMM[$chosenUnitIndex].";\n";
	echo "	var unitType = '".$array_TP[$chosenUnitIndex]."';\n";
	echo "	var ENGN_PREP = ".$array_ENGN_PREP[$chosenUnitIndex].";\n";
	echo "	var FCTL_PREP = ".$array_FRCTRL_PREP[$chosenUnitIndex].";\n";
	echo "	var MP_PREP = ".$array_MP_PREP[$chosenUnitIndex].";\n";
	echo "	var WPNS_PREP = ".$array_WPNS_PREP[$chosenUnitIndex].";\n";
	echo "	var pilotimage = '".$array_PILOT_IMG_URL[$chosenUnitIndex]."';\n";

	// If the page was reloaded, do not fade anything to speed up things
	echo "	var fadeOutDuration = ".$fadeOutDuration.";\n";
	echo "	if (document.referrer === window.location.href) {\n";
	echo "		// console.log('RELOAD');\n";
	echo "		fadeOutDuration = 0;\n";
	echo "	}\n";

	// Build up the crit history for CV
	if ($array_CV_ENGN[$chosenUnitIndex] != null) {
		echo "	var CD_CV_E = ".$array_CV_ENGN[$chosenUnitIndex].";\n";
	}
	if ($array_CV_WPNS[$chosenUnitIndex] != null) {
		echo "	var CD_CV_W = ".$array_CV_WPNS[$chosenUnitIndex].";\n";
	}
	if ($array_CV_MOTV_A[$chosenUnitIndex] != null) {
		echo "	var CD_CV_MA = ".$array_CV_MOTV_A[$chosenUnitIndex].";\n";
	}
	if ($array_CV_MOTV_B[$chosenUnitIndex] != null) {
		echo "	var CD_CV_MB = ".$array_CV_MOTV_B[$chosenUnitIndex].";\n";
	}
	if ($array_CV_MOTV_C[$chosenUnitIndex] != null) {
		echo "	var CD_CV_MC = ".$array_CV_MOTV_C[$chosenUnitIndex].";\n";
	}
	if ($array_CV_ENGN_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_ENGN_PREP = ".$array_CV_ENGN_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_ENGN_PREP = 0;\n";
	}
	if ($array_CV_FRCTRL_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_FCTL_PREP = ".$array_CV_FRCTRL_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_FCTL_PREP = 0;\n";
	}
	if ($array_CV_WPNS_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_WPNS_PREP = ".$array_CV_WPNS_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_WPNS_PREP = 0;\n";
	}
	if ($array_CV_MOTV_A_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVA_PREP = ".$array_CV_MOTV_A_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_MOTVA_PREP = 0;\n";
	}
	if ($array_CV_MOTV_B_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVB_PREP = ".$array_CV_MOTV_B_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_MOTVB_PREP = 0;\n";
	}
	if ($array_CV_MOTV_C_PREP[$chosenUnitIndex] != null) {
		echo "	var CV_MOTVC_PREP = ".$array_CV_MOTV_C_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var CV_MOTVC_PREP = 0;\n";
	}
	if ($array_CRIT_HIST[$chosenUnitIndex] != null) {
		echo "	var crit_hist = '".$array_CRIT_HIST[$chosenUnitIndex]."';\n";
	}
	if ($array_CRIT_HIST_PREP[$chosenUnitIndex] != null) {
		echo "	var crit_hist_prep = '".$array_CRIT_HIST_PREP[$chosenUnitIndex]."';\n";
	}
	if ($array_HT_PREP[$chosenUnitIndex] != null) {
		echo "	var HT_PREP = ".$array_HT_PREP[$chosenUnitIndex].";\n";
	} else {
		echo "	var HT_PREP = 0;\n";
	}
	if ($array_MVTYPE[$chosenUnitIndex] != null) {
		echo "	var MV_TYPE = '".$array_MVTYPE[$chosenUnitIndex]."';\n";
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
	if ($showDistancesHexes != null) {
		echo "	var showDistancesHexes = ".$showDistancesHexes.";\n";
	} else {
		echo "	var showDistancesHexes = 0;\n";
	}
	echo "	var playerId = ".$pid.";\n";
	echo "</script>\n";

	if ($pid == $formationplayerid) {
		// Current Unit is playable by current user
		$playable = true;
		$owned = true;
	} else {
		$playable = false;
		$owned = false;
	}
	if ($array_ACTIVE_BID[$chosenUnitIndex] == "0") {
		$playable = false;
	}

	//echo "<script> console.log('Rounds are out of sync: ".$ROUNDSOUTOFSYNC."'); </script>\n";
?>

<iframe name="saveframe" id="iframe_save"></iframe>
<script type="text/javascript" src="./scripts/log_enable.js"></script>

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

	<table width="100%" height="75%">
		<tr>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<td width="80%">
				<table class="options" width="100%" style="height:100%;" cellspacing=4 cellpadding=8 border=0px>
					<tr>
						<td class="datalabel" id="sa_name" align="left" width="90%" style="font-size:1.2em;">...</td><td nowrap class="datalabel" id="sa_abbreviation" align="right" width="10%" style="font-size:1.2em;">...</td>
					</tr>
					<tr>
						<td class="datavalue_thinflow" style="font-size:0.75em;" align="left">
							<span id="sa_source">...</span>, <span id="sa_page">...</span>
						</td>
					</tr>
					<tr>
						<td nowrap class="datavalue_thinflow" colspan="2" id="sa_type">...</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr>
						<td height="100%" colspan="2" align="left" valign="top" id="scrollcontainer">
							<div class='scroll-pane' width="100%" style="width:100%;">
								<table width="100%"><tr><td class="datavalue_thinflow" id="sa_rule">...</td></tr></table>
							</div>
						</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr>
						<td nowrap class="datavalue_thin" colspan="2" align="center"><a id="linkToCompleteAbilitiesList" href="#">Show all</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">CLOSE</a></td>
					</tr>
				</table>
			</td>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<!-- <td width="10%" align="left" valign="top"><a href="javascript:closeSpecialAbilities();">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-xmark" style="font-size:3em;"></i></a></td> -->
		</tr>
	</table>
</div>

<div id="spaInfoContainer" style="visibility:hidden;" onclick="javascript:closeSpaInfo();">
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

	<table width="100%" height="75%">
		<tr>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<td width="80%">
				<table class="options" width="100%" style="height:100%;" cellspacing=4 cellpadding=8 border=0px>
					<tr>
						<td class="datalabel" id="utspa_name" align="left" width="90%" style="font-size:1.2em;">...</td><td nowrap class="datalabel" id="utspa_variation" align="right" width="10%" style="font-size:1.2em;">...</td>
					</tr>
					<tr>
						<td class="datavalue_thinflow" style="font-size:0.75em;" colspan="2" align="left">
							<span id="utspa_source">...</span>, <span id="utspa_page">...</span>
						</td>
					</tr>
					<tr>
						<td nowrap class="datavalue_thinflow" colspan="2" id="utspa_type">...</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr id="scrollcont">
						<td height="100%" colspan="2" align="left" valign="top" id="scrollcontainer">
							<div class='scroll-pane' id="spaInfo" width="100%" style="width:100%;">
								<table width="100%"><tr><td class="datavalue_thinflow" id="utspa_desc">...</td></tr></table>
							</div>
						</td>
					</tr>
					<tr>
						<td class="datavalue_thin" colspan="2"><hr></td>
					</tr>
					<tr>
						<td nowrap class="datavalue_thin" colspan="2" align="center"><a href="javascript:closeSpaInfo();">CLOSE</a></td>
					</tr>
				</table>
			</td>
			<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
			<!-- <td width="10%" align="left" valign="top"><a href="javascript:closeSpaInfo();">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-xmark" style="font-size:3em;"></i></a></td> -->
		</tr>
	</table>
</div>

<div id='cover'></div>

<script>
	if (fadeOutDuration == 0) {
		document.getElementById("cover").style.background = "none";
		document.getElementById("cover").style.backgroundColor = "#444444";
	} else {
		document.getElementById("cover").style.backgroundColor = "black";
	}
</script>

<div id="header">
	<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
		<tr>
			<td nowrap onclick="location.href='./index.html'" width="60px" style="width:100px;background:rgba(50,50,50,1.0);text-align:center;vertical-align:middle;">
				<div><a style="color:#eee;" href="./index.html">&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
			</td>
			<td nowrap onclick="location.href='./gui_edit_game.php'" style="width:100px;background:rgba(56,87,26,1.0);">
				<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
			</td>
<?php
	$maxNumberOfTabs = 5;
	$startIndex = intval($array_PLAYER_FORMATION_STARTINDS[$formationid]);
	$showRightArrow = false;

	$activeUnitsCount = 0;
	$visibleUnitsCount = 0;
	$unitIsVisible = false;
	$unitOutLeft = false;
	$unitOutRight = false;
	$size = sizeof($array_UNIT_MODEL);

	for ($i11 = 1; $i11 <= sizeof($array_UNIT_MODEL); $i11++) {
		if ($array_ACTIVE_BID[$i11] == "0") {
			$size = $size - 1;
		} else {
			$activeUnitsCount++;

			if ($i11 < $startIndex) {
				// not yet visible
				if ($i11 == $chosenUnitIndex) {
					$unitOutLeft = true;
				}
			} else if ($i11 >= $startIndex) {
				$visibleUnitsCount++;
				// potentially visible
				if ($i11 == $chosenUnitIndex) {
					// This is the currently chosen unit
					if ($visibleUnitsCount <= $maxNumberOfTabs) {
						// Unit visible
						$unitIsVisible = true;
					} else {
						$unitIsVisible = false;
						$unitOutRight = true;
					}
				}
			}
		}
	}

	$moveLeftToMakeUnitVisible = $startIndex - $chosenUnitIndex;
	$moveRightToMakeUnitVisible = $chosenUnitIndex - ($startIndex + $maxNumberOfTabs) + 1;

	//$scrollToView = 1;

	if (!$unitIsVisible) {
		if ($unitOutLeft) {
			if ($scrollToView == 1) {
				$startIndex = $startIndex - $moveLeftToMakeUnitVisible;
				$unitIsVisible = true;
				$unitOutLeft = false;
				$unitOutRight = false;
				// echo "<script>console.log('Shift LEFT to make visible: ".$moveLeftToMakeUnitVisible."');</script>";
				echo "<script>updateFormationStartIndex(".$formationid.",".$startIndex.",\"none\");</script>";
			}
		} else if ($unitOutRight) {
			if ($scrollToView == 1) {
				$startIndex = $startIndex + $moveRightToMakeUnitVisible;
				$unitIsVisible = true;
				$unitOutLeft = false;
				$unitOutRight = false;
				// echo "<script>console.log('Shift RIGHT to make visible: ".$moveRightToMakeUnitVisible."');</script>";
				echo "<script>updateFormationStartIndex(".$formationid.",".$startIndex.",\"none\");</script>";
			}
		}
	}

	if ($size > $maxNumberOfTabs) {
		$width = ceil(100 / $maxNumberOfTabs);
		if ($startIndex > 1) {
			if ($unitOutLeft) {
				echo "			<td nowrap style='background-color:#293647;animation: glow 2s infinite alternate;' onclick='javascript:updateFormationStartIndex(".$formationid.",".$startIndex.",\"down\");' style='width:100px;'>\n";
				echo "				<div style='vertical-align:middle;font-size:22px;color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-chevron-left'></i>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style='font-size:14px;'>".($startIndex-1)."</span></div>\n";
			} else {
				echo "			<td nowrap style='background-color:#293647;' onclick='javascript:updateFormationStartIndex(".$formationid.",".$startIndex.",\"down\");' style='width:100px;'>\n";
				echo "				<div style='vertical-align:middle;font-size:22px;color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-chevron-left'></i>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style='font-size:14px;'>".($startIndex-1)."</span></div>\n";
			}
			echo "			</td>\n";
		}
	} else {
		$width = ceil(100 / $size);
	}

	echo "			<td style='width:5px;'>&nbsp;</td>\n";

	$heatimage = array();
	$currentUnitStatusImage = "./images/check_red.png";
	$currentmeli = "";
	$currentPhaseButton = "./images/top-right_phase01.png";

	$currentUnitMovement = 0;
	$currentUnitFired = 0;
	$atLeastOneValidUnitInFormation = 0;
	$ccount = 1;

	for ($i4 = $startIndex; $i4 <= sizeof($array_UNIT_MODEL); $i4++) {
		if ($ccount > $maxNumberOfTabs) {
			if ($size - $maxNumberOfTabs - ($startIndex - 1)) {
				$showRightArrow = true;
			}
			break;
		}
		$unitstatusimage = "./images/check_red.png";
		$mvmt = $array_MVMT[$i4];
		$wpnsfired = $array_WPNSFIRED[$i4];

		if ($array_TP[$i4] == "BA") {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='42px' width='0px'>";
		} else {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='42px'>";
		}
		$phaseButton = "./images/top-right_phase01.png";
		if ($mvmt == 0 && $wpnsfired == 0) {
			//$unitstatusimage = "./images/check_red.png";
			$unitstatusimage = "./images/top-right_phase01.png";
			$phaseButton = "./images/top-right_phase01.png";
		}
		if ($mvmt > 0 && $wpnsfired == 0) {
			//$unitstatusimage = "./images/check_yellow.png";
			$unitstatusimage = "./images/top-right_phase02.png";
			$phaseButton = "./images/top-right_phase02.png";
		}
		if ($mvmt > 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			//$unitstatusimage = "./images/check_green.png";
			$unitstatusimage = "./images/top-right_phase03.png";
			$phaseButton = "./images/top-right_phase03.png";
		}
		if ($mvmt == 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			// Error! Unit has fired but no movement was specified! Ask again!
		}
		if ($array_UNIT_IMG_STATUS[$i4] == "images/DD_BM_04.png") {
			$phaseButton = "./images/top-right_phase00.png";
		}

		if ($array_UNIT_STATUSSTRING[$i4] == "destroyed") {
			$unitstatusimage = "./images/skull.png";
			$phaseButton = "./images/skull.png";
		}

		//$memodel = $array_UNIT_MODEL[$i4];
		$memodel = $array_UNIT_NAME_CLAN[$i4];

		$maxLength = 100;
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

		$meli="./gui_play_unit.php?formationid=".$formationid."&fod=175&chosenunit=".$i4;
		if ($chosenUnitIndex == $i4) {
			$locmeli = $meli;
			$currentUnitStatusImage = $unitstatusimage;
			$currentmeli = $meli;
			$currentPhaseButton = $phaseButton;

			$currentUnitMovement = $mvmt;
			$currentUnitFired = $wpnsfired;

			if ($array_ACTIVE_BID[$i4] == "1") {
				//<img src='images/chevron.png' height='21px;'>
				echo "			<td width='".$width."%' nowrap><table height='100%' cellspacing='0' cellpadding='0' class='unitselect_button_active_play_left' style='animation: glow 2s infinite alternate;'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img id='unitstatusimagemenu' style='vertical-align:middle;' src='".$array_UNIT_IMG_STATUS[$i4]."' height='25px' width='23px'><br><span style='color:#ccffff;font-size:18px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span></div></td><td>&nbsp;</td><td width='90%' nowrap><table width='100%'><tr><td id='selectWidthMeasure'><div name='unitCell' style='display:block;font-size:26px;width:50px;height:28px;text-align:left;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;'>".textShorten($memodel)."   </div>        </td></tr><tr><td style='font-size:18px;'>".$array_PILOT[$i4]."</td></tr></table>     </td><td width='5%' align='right' valign='middle' style='align:left;' width='100%'>&nbsp;&nbsp;<img id='unitroundstatusimagemenu' src='".$unitstatusimage."' height='24px'></td></tr></table></td>\r\n";
				echo "			<td style='width:5px;'>&nbsp;</td>\r\n";
				$atLeastOneValidUnitInFormation = $atLeastOneValidUnitInFormation + 1;
				$ccount++;
			}
		} else {
			if ($array_ACTIVE_BID[$i4] == "1") {
				echo "			<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table height='100%' cellspacing='0' cellpadding='0' class='unitselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$array_UNIT_IMG_STATUS[$i4]."' height='25px' width='23px'><br><span style='color:#ccffff;font-size:18px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span></div></td><td>&nbsp;</td><td width='90%' nowrap><table width='100%'><tr><td id='selectWidthMeasure'><div name='unitCell' style='display:block;font-size:26px;width:50px;height:28px;text-align:left;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;'>".textShorten($memodel)."   </div>        </td></tr><tr><td style='font-size:18px;'>".$array_PILOT[$i4]."</td></tr></table>     <td width='5%' align='right' valign='middle' style='align:left;' width='100%'>&nbsp;&nbsp;<img id='unitroundstatusimagemenuinactiveunit' src='".$unitstatusimage."' height='24px'></td></tr></table></td>\r\n";
				echo "			<td style='width:5px;'>&nbsp;</td>\r\n";
				$atLeastOneValidUnitInFormation = $atLeastOneValidUnitInFormation + 1;
				$ccount++;
			} else {
				echo "			<td style='display:none;visibility:hidden;' width='".$width."%' nowrap>&nbsp;</td>\r\n";
			}
		}
	}
	if ($atLeastOneValidUnitInFormation == 0) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>\r\n";
		header("Location: ./gui_select_unit.php");
	}

	if ($showRightArrow) {
		if ($unitOutRight) {
			echo "			<td nowrap style='background-color:#293647;animation: glow 2s infinite alternate;' onclick='javascript:updateFormationStartIndex(".$formationid.",".$startIndex.",\"up\");' style='width:100px;'>\n";
			echo "				<div style='vertical-align:middle;font-size:22px;color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-chevron-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style='font-size:14px;'>".($size - $maxNumberOfTabs - ($startIndex - 1))."</span></div>\n";
		} else {
			echo "			<td nowrap style='background-color:#293647;' onclick='javascript:updateFormationStartIndex(".$formationid.",".$startIndex.",\"up\");' style='width:100px;'>\n";
			echo "				<div style='vertical-align:middle;font-size:22px;color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-chevron-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style='font-size:14px;'>".($size - $maxNumberOfTabs - ($startIndex - 1))."</span></div>\n";
		}
		echo "			</td>\n";
	}

	if ($playable) {
		echo "			<td nowrap onclick='javascript:showGameMenu();' width='60px' style='width:60px;min-width:60px;background:rgba(56,87,26,1.0);text-align:center;vertical-align:middle;'>\n";
		echo "				<div id='gamemenubutton'><i style='color:#eee;' class='fa-solid fa-angles-down'></i></div>\n";
		echo "			</td>\n";
	} else {
		echo "			<td nowrap width='60px' style='width:60px;min-width:60px;background:rgba(56,87,26,1.0);text-align:center;vertical-align:middle;'>\n";
		echo "				<div id='gamemenubutton'><i style='color:#eee;' class='fa-regular fa-circle'></i></div>\n";
		echo "			</td>\n";
	}
?>
			<td style='width:5px;'>&nbsp;</td>
			<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' style='height:auto;display:block;' width='60px' height='60px'></td>
		</tr>
<?php
	//if ($playMode) {
		echo "		<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>\r\n";
	//} else {
	//	echo "		<tr><td colspan='999' style='background:#da8e25;height:5px;'></td></tr>\r\n";
	//}
?>
	</table>
</div>

<div id="gamemenu" onclick="javascript:showGameMenu();">
	<br>
	<table style="margin: 0 auto;" align="center" width="90%" cellspacing=2 cellpadding=2 border=0px>
		<tr>
<?php
	echo "			<td colspan='3' nowrap style='height:30px;text-align:center;padding:0px;' class='formationselect_button_normal'>\n";
	echo "				<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0'>\n";
	echo "					<td colspan='1' nowrap style='width:60px;height:30px;text-align:left;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "						<a href=''>&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-arrow-left'></i></a>\n";
	echo "					</td>\n";
	echo "						<td colspan='1' nowrap style='height:30px;text-align:center;' class='formationselect_button_normal'>\n";
	echo "						<a href='#'>".$COMMANDNAME."</a>\n";
	echo "					</td>\n";
	echo "					<td colspan='1' nowrap style='width:60px;height:30px;text-align:right;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "						<a href=''><i class='fa-solid fa-arrow-right'></i>&nbsp;&nbsp;&nbsp;</a>\n";
	echo "					</td>\n";
	echo "				</table>\n";
	echo "			</td>\n";
	echo "			<td width='1%' nowrap onclick='location.href=\"save_game_finalizeround.php?pid=".$pid."\"' id='FinalizeRoundButton' style='text-align:center;background:rgba(81,125,37,1.0);' rowspan='3'><div style='color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-redo'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";

	for ($cc = 0; $cc < sizeof($array_PLAYER_FORMATION_IDS); $cc++) {
		$currFormId = $array_PLAYER_FORMATION_IDS[$cc];
		$unitArray = $array_PLAYER_UNITS_IN_FORMATION[$currFormId];

		$active_units_found = false;
		foreach($unitArray as $item) {
			if ($item['active_bid'] == 1) {
				$active_units_found = true;
			}
		}

		if ($unitArray != null && $active_units_found) {
			echo "			<td width='33%' nowrap style='width:270px;height:30px;vertical-align:middle;' onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$array_PLAYER_FORMATION_IDS[$cc]."\"' class='formationselect_button_normal'>\n";
			echo "				<a href='gui_play_unit.php?stv=1&formationid=".$array_PLAYER_FORMATION_IDS[$cc]."'>".$array_PLAYER_FORMATION_NAMES[$cc]."</a>\n";
			echo "			</td>\n";
		} else {
			echo "			<td width='33%' nowrap style='background-color:#444444;width:270px;height:40px;text-align:center;' class='formationselect_button_active'>\n";
			echo "				".$array_PLAYER_FORMATION_NAMES[$cc]."\n";
			echo "			</td>\n";
		}
	}
	echo "		</tr>\n";
	echo "		<tr>\n";

	for ($cc = 0; $cc < sizeof($array_PLAYER_FORMATION_IDS); $cc++) {
		$currFormId = $array_PLAYER_FORMATION_IDS[$cc];
		$unitArray = $array_PLAYER_UNITS_IN_FORMATION[$currFormId];

		echo "			<td style='text-align:center;background-color:#444444;' align='center' valign='top' class='unitselect_button_active'>\n";
		echo "				<table style='margin:auto;border-collapse:collapse;' cellspacing=4 cellpadding=4>\n";
		echo "					<tr>\n";

		$count = 1;
		foreach($unitArray as $item) {
			if ($item['round_moved'] == 0 && $item['round_fired'] == 0) {
				$imagestatuslnk = "./images/top-right_phase01.png";
			}
			if ($item['round_moved'] > 0 && $item['round_fired'] == 0) {
				$imagestatuslnk = "./images/top-right_phase02.png";
			}
			if ($item['round_moved'] == 0 && $item['round_fired'] > 0) { // impossible state
				$imagestatuslnk = "./images/top-right_phase02.png";
			}
			if ($item['round_moved'] > 0 && $item['round_fired'] > 0) {
				$imagestatuslnk = "./images/top-right_phase03.png";
			}
			if ($item['status'] == "destroyed") {
				$imagestatuslnk = "./images/skull.png";
			}

			if ($item['size'] == 1) {
				$sizeString = "L";
			} else if ($item['size'] == 2) {
				$sizeString = "M";
			} else if ($item['size'] == 3) {
				$sizeString = "H";
			} else if ($item['size'] == 4) {
				$sizeString = "A";
			} else if ($item['size'] == 5) {
				$sizeString = "SH";
			}
			if ($item['active_bid'] == 1) {
				if ($count == 6 || $count == 11) {
					echo "		</tr>\n";
					echo "		<tr>\n";
				}
				if ($array_UNIT_DBID[$chosenUnitIndex] == $item['unitid']) {
					echo "						<td onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$array_PLAYER_FORMATION_IDS[$cc]."&fod=175&chosenunit=".$count."\"' align='center' valign='top' style='background-color:#293647;padding:4px;border:2px solid #555;animation: glow 2s infinite alternate;'>\n";
					echo "							<img id='unitstatusimageoverview' src='https://www.ascard.net/app/".$item["status_image"]."' width='32px'><br>\n";
					echo "							<span style='display:inline-block;width:40px;align:center;'><img id='overviewcurrentunitstatus' style='display:block;margin-left:auto;margin-right:auto;height:auto;' src='".$currentPhaseButton."' width='24px'></span>\n";
					echo "							<br><span style='font-size:15px'>".$item['unit_number']."</span>\n";
					echo "						</td>\n";
				} else {
					echo "						<td onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$array_PLAYER_FORMATION_IDS[$cc]."&fod=175&chosenunit=".$count."\"' align='center' valign='top' style='background-color:#333333;padding:4px;border:2px solid #555;'>\n";
					echo "							<img src='https://www.ascard.net/app/".$item["status_image"]."' width='32px'><br>\n";
					echo "							<span style='display:inline-block;width:40px;align:center;'><img style='display:block;margin-left:auto;margin-right:auto;height:auto;' src='".$imagestatuslnk."' width='24px'></span>\n";
					echo "							<br><span style='font-size:15px'>".$item['unit_number']."</span>\n";
					echo "						</td>\n";
				}
			}
			echo "						<td>&nbsp;</td>\n";
			$count++;
		}

		echo "					</tr>\n";
		echo "				</table>\n";
		echo "			</td>\n";
	}
?>
		</tr>
	</table>
</div>

<div><?php echo "<img src='".$array_PILOT_IMG_URL[$chosenUnitIndex]."' id='pilotimage' width='80px' height='80px'>" ?></div>
<div id="faction" align="center"><?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='50px' height='50px'>" ?></div>
<div id="unit_number" align="center" onclick='javascript:hideTopPanels();'>#<?= $array_UNIT_NUMBER[$chosenUnitIndex] ?><br><?= strtoupper($FORMATION) ?></div>

<?php
	if ($ROUNDSOUTOFSYNC == 1) {
		echo "		<div id='roundsyncmessage'>ROUNDS ARE OUT OF SYNC!</div>\n";
	}

	$tempUnitImageURL = $array_UNIT_IMG_URL[$chosenUnitIndex];
	$tempUnitImageURLMUL = getMULImageByName($array_UNIT_MULNAME[$chosenUnitIndex]);

	echo "<script>var unitImageURL='".$tempUnitImageURL."';</script>\n";
	echo "<script>var unitImageURLMUL='".$tempUnitImageURLMUL."';</script>\n";

	if ($useMULImages == 0) {
		echo "<div id='unit'><img id='unitimage' src='".$tempUnitImageURL."'></div>\n";
	} else if ($useMULImages == 1) {
		echo "<div id='unit'><img id='unitimage' src='".$tempUnitImageURLMUL."'></div>\n";
	}
?>

<div id="topleft">
	<span style="font-size: 18px; color: #eeeeee;"><?php echo "$FORMATION"; ?></span>
	<br>
	<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenUnitIndex]"; ?></span>
	<br>
	<span style="font-size: 20px; color: #aaaaaa;"><?php echo $array_UNIT_CLASS[$chosenUnitIndex]." ".$array_UNIT_VARIANT[$chosenUnitIndex]; ?></span>
</div>

<div id="topright_showbutton" onclick='javascript:showTopStatusInfo2();'>
	<img id='toprightimagebutton' onclick='javascript:hideTopPanels();' src='./images/top-right_03.png' style='height:110px;'>
</div>

<div id="topright" onclick='javascript:hideTopPanels();'>
	<img id='toprightimage' onclick='javascript:hideTopPanels();' src='./images/top-right_02.png' style='height:125px;'>
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
	if (!$playable) {
		if ($hideNotOwnedUnit && !$owned) {
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

<div id="pv" onclick='javascript:hideTopPanels();'>
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
								<td colspan="1" class="datalabel_thin_small" width="20%" align="left">Skill</td>
								<td colspan="1" id="TC_SKILL" class="datalabel" width="20%" align="right">
									<?php echo "$array_SKILL[$chosenUnitIndex]"; ?>
								</td>
								<td nowrap width="90%" rowspan="2" colspan="1" align="right" id="ToHitResult" class="datalabel_big" style="color:#da8e25;vertical-align:top;text-align:right;font-weight:bold;">5</td>
							</tr>
							<tr>
								<td nowrap width="1%" style="text-align:left;vertical-align:middle;color:#fff;" class="datalabel_thin_small" rowspan="1" valign="top"><b>A.</b>&nbsp;&nbsp;&nbsp;</td>
								<td colspan="1" class="datalabel_thin_small" width="20%" align="left">AMM</td>
								<td colspan="1" id="TC_AMM" class="datalabel" width="20%" align="right">
									0
								</td>
							</tr>
						</table>
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
					<div class="dataarea_content">
						<table width="100%">
							<tr>
								<td onclick="toggleTargetingComputer();" nowrap style="text-align:center;" width="5%" id="targetcomp" rowspan="2">&nbsp;<i class="fa-solid fa-circle-left" style="color:#999;font-size:35px;"></i>&nbsp;&nbsp;</td>
								<!-- <td nowrap class="datalabel" width="12%">TP:</td> -->
								<td nowrap class="datavalue" width="25%" id="unit_type" colspan="4"><?php echo "$array_TP[$chosenUnitIndex]"; ?>/<?php echo "$array_SZ[$chosenUnitIndex]"; ?><span class='datalabel_thin_small' style='text-transform:lowercase;'> (<?php echo "$array_TON[$chosenUnitIndex]"; ?>t)</span></td>
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
								<td nowrap class="datavalue_small_special" width="50%" colspan="4" style="text-align:left;" valign="middle" onclick="javascript:window.open('http://www.masterunitlist.info/Unit/Details/<?php echo $array_UNIT_MULID[$chosenUnitIndex] ?>');"><?php echo "$array_ROLE[$chosenUnitIndex]"; ?>&nbsp;&nbsp;<i class="fa-solid fa-square-up-right"></i></td>
								<td nowrap class="datalabel" width="13%" colspan="1" valign="middle" >AMM:</td>
								<td nowrap class="datavalue" width="12%" colspan="1" valign="middle" style="top:0px;bottom:0px;vertical-align:middle;"><span class="datavalue" id="AMM">0</span></td>
								<td nowrap class="datalabel" width="12%" colspan="1">SKL:</td>
								<td nowrap class="datavalue" width="12%" colspan="1" valign="middle" id="skillfield" style="top:0px;bottom:0px;vertical-align:middle;"><?php echo "$array_SKILL[$chosenUnitIndex]"; ?></td>
							</tr>
						</table>
					</div>
					<div class="dataarea_divider_horizontal"></div>
					<div class="dataarea_content" id="firepanel">
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
						<div class="dataarea_divider_horizontal"></div>
					</div>
					<div class="dataarea_content" id="firepanelhidden" style="visibility: hidden;display:none">
						<table width="100%">
							<tr>
								<td nowrap class="datavalue_thin" width="10%" style="text-align: center;">TRADE ABILITY TO FIRE FOR SPEED</td>
							</tr>
						</table>
						<div class="dataarea_divider_horizontal"></div>
					</div>
<?php
	if ($array_TP[$chosenUnitIndex] == "BA" || $array_TP[$chosenUnitIndex] == "CV") {
		// Do not show the heat block for all Battle Armor and combat vehicle units
		echo "					<div class='dataarea_content' style='display:none;'>\r\n";
	} else {
		echo "					<div class='dataarea_content'>\r\n";
	}
?>
						<table width="100%">
							<tr>
								<td nowrap class="datalabel" width="5%">OV:</td>
								<td nowrap width="25%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_OV[$chosenUnitIndex]; $i1++) {
		echo "									<label class='bigcheck'><input onchange='readCircles(this, $array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='UOV".$i1."' id='UOV".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
								</td>
								<td nowrap class="datalabel" width="15%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:&nbsp;&nbsp;</td>
								<td nowrap width="2%" valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseHT_PREP();"><i class="fas fa-plus-square"></i></a></td>
								<td nowrap class="datalabel_thin" width="2%" id="label_HT_PREP" align="center"><?= $array_HT_PREP[$chosenUnitIndex] + $array_HT_PREP_ENGINEHIT[$chosenUnitIndex] ?></td>
								<td nowrap width="36%" style="text-align: right;" id="ht_field" class="datalabel_thin">
									<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H1" id="H1" value="yes"/><span class="bigcheck-target"></span></label>
									<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H2" id="H2" value="yes"/><span class="bigcheck-target"></span></label>
									<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H3" id="H3" value="yes"/><span class="bigcheck-target"></span></label>
									<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="H4" id="H4" value="yes"/><span class="bigcheck-target"></span></label>
								</td>
							</tr>
						</table>
						<div class="dataarea_divider_horizontal"></div>
					</div>

					<div class="dataarea_content">
						<table width="100%">
							<tr>
								<td nowrap width="5%" class="datalabel">A:</td>
								<td nowrap width="95%" class="datalabel_thin">
<?php
	for ($i1 = 1; $i1 <= $array_A_MAX[$chosenUnitIndex]; $i1++) {
		echo "								<label class='bigcheck'><input onchange='readCircles(this, $array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
		if ($i1 == 10) {
			echo "<br>\n";
		}
	}
?>
								</td>
							</tr>
							<tr>
								<td nowrap width="5%" class="datalabel">S:</td>
								<td nowrap width="95%" class="datalabel_thin">
<?php
	for ($i2 = 1; $i2 <= $array_S_MAX[$chosenUnitIndex]; $i2++) {
		echo "								<label class='bigcheck'><input onchange='readCircles(this, $array_UNIT_DBID[$chosenUnitIndex]);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
		if ($i2 == 10) {
			echo "<br>\n";
		}
	}
?>
								</td>
							</tr>
						</table>
					</div>

					<div class="dataarea_divider_horizontal"></div>

					<div class="dataarea_content">
						<table width="100%">
							<tr style="line-height: 24px;">
								<td class="datavalue_thin" style="text-align:left;margin-top:5px;" id="sa_field">
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
				echo "									<span class='unitSpecialAbility' onclick='javascript:showSpecialAbility(\"".$saParameter."\");'>".$part."</span>\n";

				$i++;
			}
		}
	}

	$spaParts = explode(',', $array_PILOT_SPA[$chosenUnitIndex]);
	if (count($spaParts) >= 1) {
		foreach ($spaParts as $spaPart) {
			if ($spaPart !== "") {
				$spaPart = preg_replace("/\[[^)]+\]/","",$spaPart); // Remove costs: "[2]" from String to save space in gui
				$order = array("\"", "'");
				$replace = "";
                $spaPartClean = str_replace($order, $replace, $spaPart);
				echo "									<span class='pilotSpecialAbility' onclick='javascript:showSpaInfo(\"".trim($spaPartClean)."\");'>".trim($spaPart)."</span>\n";
			}
		}
	}
?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="dataarea">
					<table width="100%" cellspacing=0 cellpadding=0>
						<tr>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:right;vertical-align:middle;">NARC:&nbsp;</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:left;vertical-align:middle;">
								<label class='bigcheck'><input onchange='readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>);' type='checkbox' class='bigcheck' name='NARC' id='NARC' value='yes'/><span class='bigcheck-target'></span></label>
							</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:right;vertical-align:middle;">TAG:&nbsp;</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:left;vertical-align:middle;">
								<label class='bigcheck'><input onchange='readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>);' type='checkbox' class='bigcheck' name='TAG' id='TAG' value='yes'/><span class='bigcheck-target'></span></label>
							</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:right;vertical-align:middle;">WATER:&nbsp;</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:left;vertical-align:middle;">
								<label class='bigcheck'><input onchange='readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>);' type='checkbox' class='bigcheck' name='WATER' id='WATER' value='yes'/><span class='bigcheck-target'></span></label>
							</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:right;vertical-align:middle;">ROUTED:&nbsp;</td>
							<td nowrap valign="middle" class="datavalue_thin" style="text-align:left;vertical-align:middle;">
								<label class='bigcheck'><input onchange='readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>);' type='checkbox' class='bigcheck' name='ROUTED' id='ROUTED' value='yes'/><span class='bigcheck-target'></span></label>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td width="40%" valign="bottom" align="left">
				<div id="movementtoken" width="100%" valign="top" align="left">
					<img valign="top" id="movementtokenimage" src="./images/dice/yd6_4.png" height="80px">
				</div>
				<div class="dataarea">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td nowrap rowspan="3" style="vertical-align: middle;" valign="middle" align="center" width="15px">
								<div style="padding: 0 15 0 15;" id="phasebutton" name="phasebutton"><img id="phasebuttonimage" src=<?php echo "'$currentPhaseButton'"; ?> style='height:50px;'></div>
							</td>
							<td nowrap width="65%" id="movementcontainer" class="datalabel_thin">
								<table cellspacing="2" cellpadding="0">
									<tr>
										<td align="center"><img src="./images/buttons/mov01.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov02.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov03.png" height='17px' style="border: 0px solid #000000;"></td>
										<td align="center"><img src="./images/buttons/mov04.png" height='17px' style="border: 0px solid #000000;"></td>
<?php
	if ($array_MVJ[$chosenUnitIndex] != null && $array_MVJ[$chosenUnitIndex] > 0) {
		echo "										<td align='center'><img src='./images/buttons/mov05.png' height='17px' style='border: 0px solid #000000;'></td>\n";
	} else {
		echo "										<td style='visibility:hidden;' align='center'><img src='./images/buttons/mov05.png' height='17px' style='border: 0px solid #000000;'></td>\n";
	}
?>
									</tr>
									<tr>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 2, -1);' class='bigcheck' name='MV2_moved2_standstill' id='MV2_moved2_standstill' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 10,-1);' class='bigcheck' name='MV10_moved10_hulldown' id='MV10_moved10_hulldown' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 3, -1);' class='bigcheck' name='MV3_moved3_moved' id='MV3_moved3_moved' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, 9, -1);' class='bigcheck' name='MV9_moved9_sprinted' id='MV9_moved9_sprinted' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
<?php
	if ($array_MVJ[$chosenUnitIndex] != null && $array_MVJ[$chosenUnitIndex] > 0) {
		echo "										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, ".$array_UNIT_DBID[$chosenUnitIndex].", ".$array_A_MAX[$chosenUnitIndex].", ".$array_S_MAX[$chosenUnitIndex].", 4, -1);' class='bigcheck' name='MV4_moved4_jumped' id='MV4_moved4_jumped' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>\n";
	} else {
		echo "										<td style='visibility:hidden;'><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, ".$array_UNIT_DBID[$chosenUnitIndex].", ".$array_A_MAX[$chosenUnitIndex].", ".$array_S_MAX[$chosenUnitIndex].", 4, -1);' class='bigcheck' name='MV4_moved4_jumped' id='MV4_moved4_jumped' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>\n";
	}
?>
									</tr>
								</table>
							</td>
							<td id="INFOMOVED" nowrap width="20%" class="datalabel_thin"></td>
						</tr>
						<tr id="INFOLINE" style='margin:2px;height:2px;padding:2px;line-height:2px;font-size:2px;'><td colspan='2' style='margin:2px;height:2px;padding:2px;line-height:2px;font-size:2px;'><hr style='margin:2px;'></td></tr>
						<tr>
							<td nowrap width="65%" id="firecontainer" class="datalabel_thin">
								<table cellspacing="2" cellpadding="0">
									<tr>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, -1, 1);' class='bigcheck' name='WF5_WEAPONSFIRED2' id='WF5_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
										<td><label class='bigcheck'><input type='checkbox' onchange='readCircles2(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>, -1, 2);' class='bigcheck' name='WF6_WEAPONSFIRED2' id='WF6_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>&nbsp;</td>
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
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" id="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_2" id="CD_E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+1 HT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FC:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseFCTL_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_FCTL_PREP" align="center"><?= $array_FRCTRL_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="90%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" id="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" id="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" id="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" id="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMP_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_MP_PREP" align="center"><?= $array_MP_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" id="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" id="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" id="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" id="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">½ MV</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">W:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" valign="middle" href="javascript:increaseWPNS_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_WPNS_PREP" align="center"><?= $array_WPNS_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" id="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" id="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" id="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" id="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
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
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-E_1" id="CD_CV-E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-E_2" id="CD_CV-E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" colspan="2" width="5%" style="text-align: right;">½ MV, ½ DMG</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FC:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" href="javascript:increaseFCTL_CV_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_CV_FCTL_PREP" align="center"><?= $array_CV_FRCTRL_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="90%" colspan='2' style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_1" id="CD_CV-FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_2" id="CD_CV-FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_3" id="CD_CV-FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-FC_4" id="CD_CV-FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align:right;">W:&nbsp;</td>
							<td nowrap valign="middle"><a style="padding-right:5px;" href="javascript:increaseWPNS_CV_PREP();"><i class="fas fa-plus-square"></i></a></td>
							<td nowrap class="datalabel_thin" id="label_CV_WPNS_PREP" align="center"><?= $array_CV_WPNS_PREP[$chosenUnitIndex] ?></td>
							<td nowrap class="datalabel">&nbsp;</td>
							<td nowrap width="55%" colspan='2' style="text-align: left;" class="datalabel_thin">
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_1" id="CD_CV-W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_2" id="CD_CV-W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_3" id="CD_CV-W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-W_4" id="CD_CV-W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin_small" width="5%" style="text-align: right;">-1 DMG</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;" rowspan="2">MO:&nbsp;</td>
							<td colspan="7" style="padding-top:10px;">
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td nowrap colspan="2" width="33%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MA_1" id="CD_CV-MA_1" value="yes"/><span class="bigcheck-target"></span></label>
											<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MA_2" id="CD_CV-MA_2" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
										<td nowrap width="32%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MB_1" id="CD_CV-MB_1" value="yes"/><span class="bigcheck-target"></span></label>
											<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MB_2" id="CD_CV-MB_2" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
										<td nowrap width="33%" style="text-align:center;" class="datalabel_thin">
											<label class="bigcheck"><input onchange="readCircles(this, <?= $array_UNIT_DBID[$chosenUnitIndex] ?>, <?= $array_A_MAX[$chosenUnitIndex] ?>, <?= $array_S_MAX[$chosenUnitIndex] ?>);" type="checkbox" class="bigcheck" name="CD_CV-MC_1" id="CD_CV-MC_1" value="yes"/><span class="bigcheck-target"></span></label>
										</td>
									</tr>
									<tr>
										<td nowrap width="33%" colspan="2" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">-2</td>
													<td nowrap style="text-align:right;"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMOTIVEA_PREP();"><i class="fas fa-plus-square"></i></a></td>
													<td nowrap style="text-align:left;" class="datalabel_thin" id="label_CV_MOTIVA_PREP" valign="middle"><?= $array_CV_MOTV_A_PREP[$chosenUnitIndex] ?></td>
												</tr>
											</table>
										</td>
										<td nowrap width="32%" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">½</td>
													<td nowrap style="text-align:right;"><a style="padding-right:5px;" valign="middle" href="javascript:increaseMOTIVEB_PREP();"><i class="fas fa-plus-square"></i></a></td>
													<td nowrap style="text-align:left;" class="datalabel_thin" id="label_CV_MOTIVB_PREP" valign="middle"><?= $array_CV_MOTV_B_PREP[$chosenUnitIndex] ?></td>
												</tr>
											</table>
										</td>
										<td nowrap width="33%" style="text-align:center;" class="datalabel_thin">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td nowrap style="text-align:right;" class="datalabel_thin_small" valign="middle">//</td>
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
					<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_UNIT_CLASS[$chosenUnitIndex]" ?></span><br>
					<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_UNIT_VARIANT[$chosenUnitIndex]" ?>&nbsp;(<?php echo "$array_TON[$chosenUnitIndex]" ?>t&nbsp;<?php echo "$array_TP[$chosenUnitIndex]" ?>)</span><br><br>

					<span style="font-size: 20px; color: #aaaaaa;">Clan: <?php echo "$array_UNIT_NAME_CLAN[$chosenUnitIndex]" ?></span><br>
					<span style="font-size: 20px; color: #aaaaaa;">IS: <?php echo "$array_UNIT_NAME_IS[$chosenUnitIndex]" ?></span><br><br>

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

<div style="display:none;" id="topmiddlebackground">
	<img style="pointer-events:auto;height:100px;" src='./images/top-middle_01.png' onclick="javascript:hideTopPanels();">
</div>
<div style="display:none;" id="destroyedIndicator">
	<img style="pointer-events:auto;" src='./images/skull.png' onclick="javascript:hideSkull();" height='250px'>
</div>
<div style="display:none;" id="crippledIndicator">
	<img style="pointer-events:auto;height:160px;" src='./images/crippled.png' onclick="javascript:hideCrippled();">
</div>
<div style="display:none;" id="shutdownIndicator">
	<img style="pointer-events:auto;" src='./images/heat.png' onclick="javascript:hideShutdownIndicator();" height='250px'>
</div>
<div style="display:none;" id="narcIndicator">
	<img style="pointer-events:auto;" src='./images/narc.png' onclick="javascript:hideTopPanels();" height='50px'>
</div>
<div style="display:none;" id="tagIndicator">
	<img style="pointer-events:auto;" src='./images/tag.png' onclick="javascript:hideTopPanels();" height='50px'>
</div>
<div style="display:none;" id="waterIndicator">
	<img style="pointer-events:auto;" src='./images/water.png' onclick="javascript:hideTopPanels();" height='50px'>
</div>
<div style="display:none;" id="routedIndicator">
	<img style="pointer-events:auto;" src='./images/routed.png' onclick="javascript:hideTopPanels();" height='50px'>
</div>

<script type="text/javascript">
	$("#infobar").hide();
	$("#dicebar").hide();
	$("#movebar").hide();
	$("#soundboard").hide();
	$("#topmiddlebackground").hide();
	$("#destroyedIndicator").hide();
	$("#crippledIndicator").hide();
	$("#shutdownIndicator").hide();
	$("#narcIndicator").hide();
	$("#tagIndicator").hide();
	$("#waterIndicator").hide();
	$("#routedIndicator").hide();
	setCircles(<?=$array_HT[$chosenUnitIndex]?>,<?=$array_HT_PREP_ENGINEHIT[$chosenUnitIndex]?>,<?=$array_A[$chosenUnitIndex]?>,<?=$array_S[$chosenUnitIndex]?>,<?=$array_ENGN[$chosenUnitIndex]?>,<?=$array_FRCTRL[$chosenUnitIndex]?>,<?=$array_MP[$chosenUnitIndex]?>,<?=$array_WPNS[$chosenUnitIndex]?>,<?=$array_CV_ENGN[$chosenUnitIndex]?>,<?=$array_CV_FRCTRL[$chosenUnitIndex]?>,<?=$array_CV_WPNS[$chosenUnitIndex]?>,<?=$array_CV_MOTV_A[$chosenUnitIndex]?>,<?=$array_CV_MOTV_B[$chosenUnitIndex]?>,<?=$array_CV_MOTV_C[$chosenUnitIndex]?>,<?=$array_USEDOVERHEAT[$chosenUnitIndex]?>,<?=$array_MVMT[$chosenUnitIndex]?>,<?=$array_WPNSFIRED[$chosenUnitIndex]?>,2,0,'<?=$array_UNIT_STATUSSTRING[$chosenUnitIndex]?>', <?=$array_NARCED[$chosenUnitIndex]?>, <?=$array_TAGED[$chosenUnitIndex]?>, <?=$array_WATER[$chosenUnitIndex]?>, <?=$array_ROUTED[$chosenUnitIndex]?>);
</script>

<div id="footer"></div>

<div id="bottomleft"><img src="./images/bottom-left.png" width="200px"></div>

<div align="center" id="settings">
	<a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:showUnit()"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<!-- <a href="#" onclick="javascript:window.location.reload(true)"><i class="fas fa-redo"></i></a>&nbsp;&nbsp; -->
	<a href="javascript:textSize(0)"><i class="fas fa-minus-square"></i></a>&nbsp;&nbsp;
	<a href="javascript:textSize(1)"><i class="fas fa-plus-square"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
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
			if (fadeOutDuration > 0) {
				$('#cover').fadeOut(".$fadeOutDuration.", 'linear', function() {
					$('#cover').hide();
					document.getElementById('cover').style.visibility = 'hidden';
				});
			} else {
				document.getElementById('cover').style.visibility = 'hidden';
			}

			let widthOfUnitCell = document.getElementById("selectWidthMeasure").getBoundingClientRect().width;
			//console.info("Width of unit cell: " + widthOfUnitCell);
			let cellArray = document.getElementsByName("unitCell");
			for (var i = 0; i < cellArray.length; i++) {
				cellArray[i].style.width = (widthOfUnitCell-30)+"px";
			}
			//console.log("Page ready.");
		}
	});
</script>

</body>

</html>
