<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 6");
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$isAdmin = $_SESSION['isAdmin'];
	$unitId  = isset($_GET["unitid"]) ? filter_var($_GET["unitid"], FILTER_VALIDATE_INT) : -1;

	$stringMalePilotImages = "";
	$stringFemalePilotImages = "";

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}
	$sql_asc_unit = "SELECT SQL_NO_CACHE * FROM asc_assign a, asc_unit u, asc_pilot p, asc_formation fo, asc_faction fa WHERE a.unitid = ".$unitId." AND u.unitid = a.unitid AND a.pilotid = p.pilotid AND fo.formationid = a.formationid AND fa.factionid = fo.factionid;";
	$result_asc_unit = mysqli_query($conn, $sql_asc_unit);
	if (mysqli_num_rows($result_asc_unit) > 0) {
		while($row452 = mysqli_fetch_assoc($result_asc_unit)) {
			$ASSIGNID = $row452["assignid"];
			$ASSIGNCOMMANDID = $row452["commandid"];
			$ASSIGNFORMATIONID = $row452["formationid"];
			$UNITID = $row452["unitid"];
			$UNITNUMBER = $row452["unit_number"];
			$UNITCLASS = $row452["unit_class"];
			$UNITVARIANT = $row452["unit_variant"];
			$UNITNAME = $row452["unit_name"];
			$UNITCOMMANDER = $row452["commander"];
			$UNITSUBCOMMANDER = $row452["subcommander"];
			$UNITSKILL = $row452["as_skill"];
			$UNITBASEPV = $row452["pointvalue"];
			$UNITPV = $row452["as_pv"];
			$PILOTID = $row452["pilotid"];
			$PILOTNAME = $row452["name"];
			$PILOTRANK = $row452["rank"];
			$PILOTIMAGEURL = $row452["pilot_imageurl"];
			$PILOTSPA = $row452["SPA"];
			$PILOTSPACOSTSUM = $row452["SPA_cost_sum"];
			$FORMATIONID = $row452["formationid"];
			$FORMATIONFACTIONID = $row452["factionid"];
			$FORMATIONSHORT = $row452["formationshort"];
			$FACTIONID = $row452["factionid"];
			$FACTIONSHORT = $row452["factionshort"];
			$FACTIONIMAGE = $row452["factionimage"];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Edit Command</title>
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
	<script type="text/javascript" src="./scripts/adjustPointValue.js"></script>
	<script type="text/javascript" src="./scripts/spa.js"></script>

	<script>
		let unitId = "<?php echo $UNITID; ?>";
		let assignId = "<?php echo $ASSIGNID; ?>";
		let assignCommandId = "<?php echo $ASSIGNCOMMANDID; ?>";
		let assignFormationId = "<?php echo $ASSIGNFORMATIONID; ?>";
		let unitNumber = "<?php echo $UNITNUMBER; ?>";
		let unitName = "<?php echo $UNITNAME; ?>";
		let unitClass = "<?php echo $UNITCLASS; ?>";
		let unitVariant = "<?php echo $UNITVARIANT; ?>";
		let unitCommander = "<?php echo $UNITCOMMANDER; ?>";
		let unitSubCommander = "<?php echo $UNITSUBCOMMANDER; ?>";
		let unitSkill = "<?php echo $UNITSKILL; ?>";
		let unitBasePv = "<?php echo $UNITBASEPV; ?>";
		let unitPv = "<?php echo $UNITPV; ?>";
		let pilotId = "<?php echo $PILOTID; ?>";
		let pilotName = "<?php echo $PILOTNAME; ?>";
		let pilotRank = "<?php echo $PILOTRANK.'.png'; ?>";
		let pilotImageUrl = "<?php echo $PILOTIMAGEURL; ?>";
		let pilotSpa = "<?php echo $PILOTSPA; ?>";
		let pilotSpaCostSum = "<?php echo $PILOTSPACOSTSUM; ?>";
		let formationId = "<?php echo $FORMATIONID; ?>";
		let formationFactionId = "<?php echo $FORMATIONFACTIONID; ?>";
		let formationshort = "<?php echo $FORMATIONSHORT; ?>";
		let factionid = "<?php echo $FACTIONID; ?>";
		let factionshort = "<?php echo $FACTIONSHORT; ?>";
		let factionimage = "<?php echo $FACTIONIMAGE; ?>";

		//console.log(factionshort);

		var api;
	</script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
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
	<iframe name="saveframe" id="iframe_save"></iframe>
	<script type="text/javascript" src="./scripts/log_enable.js"></script>

	<div id="heightmeasure"></div>
	<div id="cover"></div>

	<script>
		var pilotSpaArray;
		var oldRank;
		var rx = /\[(-?\d+)\]/ // Extract the number from []

		$(function() {
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			//$('.scroll-pane').jScrollPane();
			//api = $('.scroll-pane').jScrollPane().data('jsp');

			// do not initialize here already because that leads to scrollbars even if the content is smaller than
			// the scrollcontainer
		});

		function formationChanged() {
			let selectObject = document.getElementById("FORMATIONID");
			let index = selectObject.selectedIndex;
			if (document.getElementById("rank").value != "") {
				oldRank = document.getElementById("rank").value;
			}

			//console.log("Old rank: " + oldRank);

			formationFactionId = formationFactionIdArray[index];
			document.getElementById("rank").innerHTML = formationFactionRankOptions[index];

			document.getElementById("factionname").innerHTML = formationFactionShortsArray[index];
			document.getElementById("factionlogo").src = "./images/factions/" + formationFactionLogosArray[index];
			let oldRankWasFound = false;
			for (i = 0; i < document.getElementById("rank").length; ++i) {
				if (document.getElementById("rank").options[i].value == oldRank) {
					document.getElementById("rank").value = oldRank;
					oldRankWasFound = true;
				}
			}

			let newRank = document.getElementById("rank").value;
			if (oldRankWasFound) {
				document.getElementById("newpilotrank").src = "./images/ranks/" + formationFactionId + "/" + newRank;
			} else {
				document.getElementById("newpilotrank").src = "./images/ranks/notFound.png";
			}
			document.getElementById("rank").style.color="#ddd";
		}

		function showMaleImageSelectorDiv() {
			document.getElementById("maleSelectorDiv").style.visibility = "visible";
			$('.scroll-pane').jScrollPane();
		}

		function showFemaleImageSelectorDiv() {
			document.getElementById("femaleSelectorDiv").style.visibility = "visible";
			$('.scroll-pane').jScrollPane();
		}

		function selectNewMaleImage(imgName) {
			document.getElementById("malePilotImage").value = imgName;
			maleImageSelected();
			document.getElementById("maleSelectorDiv").style.visibility = "hidden";
		}

		function selectNewFemaleImage(imgName) {
			document.getElementById("femalePilotImage").value = imgName;
			femaleImageSelected();
			document.getElementById("femaleSelectorDiv").style.visibility = "hidden";
		}

		function maleImageSelected() {
			let newImage = document.getElementById("malePilotImage").value;
			document.getElementById("femalePilotImage").value = "";
			document.getElementById("newpilotimage").src = "images/pilots/" + newImage;
		}

		function femaleImageSelected() {
			let newImage = document.getElementById("femalePilotImage").value;
			document.getElementById("malePilotImage").value = "";
			document.getElementById("newpilotimage").src = "images/pilots/" + newImage;
		}

		function newRankSelected() {
			let newRank = document.getElementById("rank").value;
			document.getElementById("newpilotrank").src = "./images/ranks/" + formationFactionId + "/" + newRank;
			oldRank = newRank;

			document.getElementById("rank").style.color="#ddd";
		}

		function skillChanged() {
			let newUnitSkill = document.getElementById("NewUnitSkill").value;
			let newPV = adjustPointValue(unitBasePv, newUnitSkill);
			document.getElementById("newPV").innerHTML = newPV;
		}

		function showSpaInfoControl() {
			let newSpaSelected = document.getElementById("addNewSPA").value;
			if (newSpaSelected !== "") {
				document.getElementById("showSpaInfo").style.visibility = "visible";
			} else {
				document.getElementById("showSpaInfo").style.visibility = "hidden";
			}
		}

		function showSpaInfo(spa) {
			if (spa !== "") {
				document.getElementById("spaInfoContainer").style.visibility = "visible";
				showSpa(spa);
			}
		}

		function closeSpaInfo() {
			// If fadeIn is used here, css animation does not work anymore
			document.getElementById("spaInfoContainer").style.visibility = "hidden";
		}

		function closeMaleSelector() {
			// If fadeIn is used here, css animation does not work anymore
			document.getElementById("maleSelectorDiv").style.visibility = "hidden";
		}

		function closeFemaleSelector() {
			// If fadeIn is used here, css animation does not work anymore
			document.getElementById("femaleSelectorDiv").style.visibility = "hidden";
		}

		function save() {
			let newUnitName = document.getElementById("NewUnitName").value;
			let newUnitSkill = document.getElementById("NewUnitSkill").value;
			let newPV = document.getElementById("newPV").innerHTML;
			let newUnitNUmber = document.getElementById("NewUnitNumber").value;
			let newFormationId = document.getElementById("FORMATIONID").value;
			let newPilotName = document.getElementById("NewPilotName").value;
			let newRank = document.getElementById("rank").value;
			let newSPASum = document.getElementById("sumlabel").innerHTML;
			let newChain = document.getElementById("newChain").value;

			let newRankShortened = newRank.substring(0, newRank.length - 4);

			let newPilotImage = document.getElementById("malePilotImage").value;
			if (newPilotImage === null || newPilotImage === undefined || newPilotImage === "" || newPilotImage == 0) {
				newPilotImage = document.getElementById("femalePilotImage").value;
			}

			let newSPAs = "";
			for (var i = 0; i < pilotSpaArray.length; i++) {
				spaElement = pilotSpaArray[i].trim();
				newSPAs = newSPAs + spaElement;
				if (i < pilotSpaArray.length - 1) {
					newSPAs = newSPAs + ","
				}
			}

			if (newRankShortened === "") {
				//console.log("Check fields!");
				document.getElementById("rank").style.color="#f00";
			} else {
				var url="./save_unit_changes.php";
				url = url + "?unitId=" + encodeURIComponent(unitId);
				url = url + "&assignId=" + encodeURIComponent(assignId);
				url = url + "&pilotId=" + encodeURIComponent(pilotId);
				url = url + "&nun=" + encodeURIComponent(newUnitName.trim());
				url = url + "&nus=" + encodeURIComponent(newUnitSkill);
				url = url + "&npv=" + encodeURIComponent(newPV);
				url = url + "&nunbr=" + encodeURIComponent(newUnitNUmber.trim());
				url = url + "&nf=" + encodeURIComponent(newFormationId);
				url = url + "&npn=" + encodeURIComponent(newPilotName.trim());
				if (newPilotImage === null || newPilotImage === undefined || newPilotImage === "" || newPilotImage == 0) {
					//url = url + "&npi=";
				} else {
					url = url + "&npi=" + encodeURIComponent(newPilotImage.trim());
				}
				url = url + "&nr=" + encodeURIComponent(newRankShortened.trim());
				url = url + "&nspa=" + encodeURIComponent(newSPAs.trim());
				url = url + "&nspasum=" + encodeURIComponent(newSPASum);
				url = url + "&nch=" + encodeURIComponent(newChain.trim());
				//alert(url);
				window.frames["saveframe"].location.replace(url);
			}
		}

		function addSpecialPilotAbility() {
			let newPilotSpaSelected = document.getElementById("addNewSPA").value;
			let existingSpas = document.getElementById("newSPAs").innerHTML;
			if (newPilotSpaSelected !== "") {
				if (!existingSpas.includes(newPilotSpaSelected)) {
					pilotSpaArray.push(newPilotSpaSelected.trim());
					let indexCounter = 0;
					let spaCalculatedSum = 0;
					let spaStringList = "";
					for (var i = 0; i < pilotSpaArray.length; i++) {
						spaElement = pilotSpaArray[i].trim();
						spaCostElement = Number(spaElement.match(rx)[1]);
						spaStringList = spaStringList + "<span onclick='javascript:removeSpa("+ indexCounter + ");'>" + spaElement + "&nbsp;<i class='fas fa-minus-square'></i></span>&nbsp;&nbsp;&nbsp;";
						spaCalculatedSum = spaCalculatedSum + spaCostElement;
						indexCounter++;
					}
					document.getElementById("newSPAs").innerHTML = spaStringList;
					document.getElementById("sumlabel").innerHTML = spaCalculatedSum;
					document.getElementById("addNewSPA").value = "";
					document.getElementById("showSpaInfo").style.visibility = "hidden";
				}
			}
		}

		function removeSpa(index) {
			let indexCounter = 0;
			let spaCalculatedSum = 0;
			let spaStringList = "";
			let newPilotSpaArray = [];
			for (var i = 0; i < pilotSpaArray.length; i++) {
				if (i !== index) {
					spaElement = pilotSpaArray[i].trim();
					spaCostElement = Number(spaElement.match(rx)[1]);
					spaStringList = spaStringList + "<span onclick='javascript:removeSpa("+ indexCounter + ");'>" + spaElement + "&nbsp;<i class='fas fa-minus-square'></i></span>&nbsp;&nbsp;&nbsp;";
					spaCalculatedSum = spaCalculatedSum + spaCostElement;
					indexCounter++;
					newPilotSpaArray.push(spaElement);
				}
			}
			pilotSpaArray = newPilotSpaArray;
			document.getElementById("newSPAs").innerHTML = spaStringList;
			document.getElementById("sumlabel").innerHTML = spaCalculatedSum;
		}

		function fillValues() {
			pilotSpaArray = pilotSpa.split(",");
			let indexCounter = 0;
			let spaCalculatedSum = 0;
			let spaStringList = "";

			for (var i = 0; i < pilotSpaArray.length; i++) {
				spaElement = pilotSpaArray[i].trim();
				if (spaElement !== "") {
					spaCostElement = Number(spaElement.match(rx)[1]);
					spaStringList = spaStringList + "<span onclick='javascript:removeSpa("+ indexCounter + ");'>" + spaElement + "&nbsp;<i class='fas fa-minus-square'></i></span>&nbsp;&nbsp;&nbsp;";
					spaCalculatedSum = spaCalculatedSum + spaCostElement;
					indexCounter++;
				}
			}

			//console.log("Rank: " + "./images/ranks/" + formationFactionId + "/" + pilotRank + "--");

			document.getElementById("unitnameToEdit").innerHTML = unitClass + " " + unitVariant + " '" + unitName + "' - PV: " + unitPv + " (" + unitBasePv + ")";
			document.getElementById("factionname").innerHTML = factionshort;
			document.getElementById("factionlogo").src = "./images/factions/" + factionimage;
			document.getElementById("NewUnitName").value = unitName;
			document.getElementById("NewUnitNumber").value = unitNumber;
			document.getElementById("FORMATIONID").value = formationId;
			document.getElementById("NewPilotName").value = pilotName;
			document.getElementById("newpilotimage").src = pilotImageUrl;
			document.getElementById("newpilotrank").src = "./images/ranks/" + formationFactionId + "/" + pilotRank;
			document.getElementById("NewUnitSkill").value = unitSkill;
			document.getElementById("newSPAs").innerHTML = spaStringList;
			document.getElementById("sumlabel").innerHTML = pilotSpaCostSum; // spaCalculatedSum
			document.getElementById("rank").value = pilotRank;

			if (document.getElementById("rank").value === "") {
				document.getElementById("newpilotrank").src = "./images/ranks/notFound.png";
				document.getElementById("rank").selectedIndex = 0;
			}

			document.getElementById("newChain").value = "Warrior";
			if (unitCommander == 1) {
				document.getElementById("newChain").value = "Commander";
			} else if (unitSubCommander == 1) {
				document.getElementById("newChain").value = "Subcommander";
			}

			let newPV = adjustPointValue(unitBasePv, unitSkill);
			document.getElementById("newPV").innerHTML = newPV;
		}

		$(document).ready(function() {
			fillValues();
			$("#cover").hide();

			// Set the height of the local scrollbars to the real height of the container elements (reload only)
			let scrollcontainerstartrow = document.getElementById("scrollcontainertopborder");
			const rect = scrollcontainerstartrow.getBoundingClientRect();
			const hmd = document.getElementById("heightmeasure");
			hmd.style.top = rect.y+"px";
			const resultingHeight = hmd.clientHeight;
			//console.log("Height: " + resultingHeight);
			var scrollcontainerdivs = document.getElementsByClassName("scroll-pane");
			for(var i=0; i < scrollcontainerdivs.length; i++) {
				if (scrollcontainerdivs[i].id !== "spaInfo") {
					scrollcontainerdivs[i].style.height = resultingHeight+"px";
					//console.log(scrollcontainerdivs[i]);
				} else {
					// This is the scroll-pane in the spa detail pane
					let ch = document.getElementById("scrollcont").offsetHeight;
					//console.log("Height: " + ch);
					scrollcontainerdivs[i].style.height = ch+"px";
				}
			}
		});
	</script>

<?php
	if ($playMode) {
		$buttonWidth = "33.3%"; // 3 columns in the middle
	} else {
		if ($isAdmin) {
			$buttonWidth = "14.5%"; // 7 columns
		} else {
			$buttonWidth = "20.4%"; // 5 columns
		}
	}
?>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" style="width: 80px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color:#eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td nowrap onclick="location.href='./gui_edit_game.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>" class='menu_button_active'><a href='./gui_select_unit.php'>ROSTER</a></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_unit.php'>CREATE</a></td><td style='width:5px;'>&nbsp;</td>\n";
		//echo "				<td nowrap onclick=\"location.href='./gui_edit_game.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_edit_game.php'>GAME</a></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_player.php'>PLAYER</a></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_admin.php'>ADMIN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>
				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background:rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
			<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="autocomplete_off_hack_xfr4!k">
		<table width="85%" class="options" cellspacing="2" cellpadding="2" border=0px>
			<tr>
				<td colspan="9" width='100%' class='datalabel' nowrap align="left" id="unitnameToEdit">
					Unitname
				</td>
			</tr>
			<tr>
				<td colspan="9" width='100%' class='datalabel' nowrap align="right"><hr></td>
			</tr>
			<tr>
				<td nowrap width='5%' class="datalabel" style='text-align:right;' colspan='1'>
					Assigned to:
				</td>
				<td nowrap width='85%' class="datalabel" style='text-align:left;' colspan='5'>
					<select required name='FORMATIONID' id='FORMATIONID' size='1' style='width:100%;' onchange='formationChanged();'>
<?php
	$sql_asc_playersformations = "SELECT SQL_NO_CACHE * FROM asc_formation fo, asc_faction fa WHERE playerid=".$pid." AND fo.factionid = fa.factionid;";
	$result_asc_playersformations = mysqli_query($conn, $sql_asc_playersformations);

	$formationcount = 0;

	$array_formationFactionIds = array();
	$array_formationFactionLogos = array();
	$array_formationFactionShorts = array();
	$array_formationFactionNames = array();
	$array_formationFactionRankOptions = array();

	if (mysqli_num_rows($result_asc_playersformations) > 0) {
		while($rowFormations = mysqli_fetch_assoc($result_asc_playersformations)) {
			$formationid = $rowFormations['formationid'];
			$formationname = $rowFormations['formationshort'];
			$formationfactionid = $rowFormations['factionid'];
			$formationfactionlogo = $rowFormations['factionimage'];
			$formationfactionname = $rowFormations['factionname'];
			$formationfactionshort = $rowFormations['factionshort'];

			$array_formationFactionIds[$formationcount] = $formationfactionid;
			$array_formationFactionLogos[$formationcount] = $formationfactionlogo;
			$array_formationFactionShorts[$formationcount] = $formationfactionshort;
			$array_formationFactionNames[$formationcount] = $formationfactionname;

			echo "						<option value='".$formationid."'>".$formationname."</option>\n";

			// https://stackoverflow.com/questions/6364748/change-the-options-array-of-a-select-list

			$ranksdir = './images/ranks/'.$formationfactionid;
			$scanned_directory = array_diff(scandir($ranksdir, SCANDIR_SORT_ASCENDING), array('..', '.'));
			$array_formationFactionRankOptions[$formationcount] = $array_formationFactionRankOptions[$formationcount]."<option disabled=\"\" selected=\"\" value=\"\">Select one...</option>";
			foreach ($scanned_directory as $key => $value) {
				if (str_starts_with($value, '')) {
					$opt = "<option value='".$value."'>".substr($value,3,-4)."</option>\n";
					$array_formationFactionRankOptions[$formationcount] = $array_formationFactionRankOptions[$formationcount].$opt;
				}
			}

			$formationcount++;
		}
	}
?>
					</select>
				</td>
				<td nowrap width='5%' class="datalabel" style='text-align:left;' colspan='2' id="factionname">
					<?php echo $formationfactionshort; ?>
				</td>
				<td nowrap width='5%' class="datalabel" style='text-align:center;vertical-align:top;' colspan='1' rowspan="2">
					<img id="factionlogo" src='./images/factions/<?php echo $formationfactionlogo; ?>' width='50px' style='border:1px solid #000000;vertical-align:top;'>
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Unit name:</td>
				<td colspan="5" width='90%' class='datalabel'>
					<input autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="" onchange="" type="text" id="NewUnitName" width="100%" style="width:100%;">
				</td>
				<td colspan="2" width='5%' class='datalabel' nowrap align="right">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">#:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<input autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="" onchange="" type="text" id="NewUnitNumber" width="100%" style="width:100%;">
				</td>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Pilot:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<input autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="" onchange="" type="text" id="NewPilotName" width="100%" style="width:100%;">
				</td>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Skill:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<select required name='NewUnitSkill' id='NewUnitSkill' onchange="skillChanged();" size='1' style='width:100%;'>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
					</select>
				</td>
				<td colspan="2" width='5%' class='datalabel' nowrap align="left">*PV:</td>
				<td colspan="2" width='50' class='datalabel' style='text-align:center;vertical-align:top;' nowrap align="right" valign="top" rowspan="2">
					<img src="./images/factions/CW.png" width="60px" id="newpilotimage">
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right" onclick="showMaleImageSelectorDiv();">&nbsp;&nbsp;<i class="fa-solid fa-image-portrait"></i>&nbsp;&nbsp;male:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<select required name='malePilotImage' id='malePilotImage' onchange="maleImageSelected();" size='1' style='width:100%;'>
						<option value='0'></option>
<?php
	$directory = './images/pilots';
	$scanned_directory = array_diff(scandir($directory, SCANDIR_SORT_ASCENDING), array('..', '.'));
	$count = 0;
	$stringMalePilotImages = $stringMalePilotImages."<table><tr>";
	foreach ($scanned_directory as $key => $value) {
		if (str_starts_with($value, 'm_')) {
			echo "						<option value='".$value."'>".substr($value,2,-4)."</option>\n";
			$stringMalePilotImages = $stringMalePilotImages."<td onclick='selectNewMaleImage(\"".$value."\");'><img loading='lazy' width='75px' src='./images/pilots/".$value."'></td>";
			if ($count > 3) {
				$stringMalePilotImages = $stringMalePilotImages."</tr><tr>";
				$count = 0;
			} else {
				$count++;
			}
		}
	}
	$stringMalePilotImages = $stringMalePilotImages."</tr></table>";
?>
					</select>
				</td>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right" onclick="showFemaleImageSelectorDiv();">&nbsp;&nbsp;<i class="fa-solid fa-image-portrait"></i>&nbsp;&nbsp;female:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<select required name='femalePilotImage' id='femalePilotImage' onchange="femaleImageSelected();" size='1' style='width:100%;'>
						<option value='0'></option>
<?php
	$directory = './images/pilots';
	$scanned_directory = array_diff(scandir($directory, SCANDIR_SORT_ASCENDING), array('..', '.'));
	$count = 0;
	$stringFemalePilotImages = $stringFemalePilotImages."<table><tr>";
	foreach ($scanned_directory as $key => $value) {
		if (str_starts_with($value, 'f_')) {
			echo "						<option value='".$value."'>".substr($value,2,-4)."</option>\n";
			$stringFemalePilotImages = $stringFemalePilotImages."<td onclick='selectNewFemaleImage(\"".$value."\");'><img loading='lazy' width='75px' src='./images/pilots/".$value."'></td>";
			if ($count > 3) {
				$stringFemalePilotImages = $stringFemalePilotImages."</tr><tr>";
				$count = 0;
			} else {
				$count++;
			}
		}
	}
?>
					</select>
				</td>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Rank:</td>
				<td colspan="1" width='20%' class='datalabel'>
					<select required name='rank' id='rank' onchange="newRankSelected();" size='1' style='width:100%;'>
						<option disabled="" selected="" value="">Select one...</option>
<?php
	$directory = './images/ranks/'.$FACTIONID;
	$scanned_directory = array_diff(scandir($directory, SCANDIR_SORT_ASCENDING), array('..', '.'));
	foreach ($scanned_directory as $key => $value) {
		if (str_starts_with($value, '')) {
			echo "						<option value='".$value."'>".substr($value,3,-4)."</option>\n";
		}
	}
?>
					</select>
				</td>
				<td colspan="2" width='5%' class='datalabel' nowrap id="newPV" align="left">xx</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Chain:</td>
				<td colspan="5" width='40%' class='datalabel' valign="top">
					<select required name='newChain' id='newChain' onchange="" size='1' style='width:100%;'>
						<option value="Commander">Commander</option>
						<option value="Subcommander">Subcommander</option>
						<option value="Warrior">Warrior</option>
					</select>
				</td>
				<td colspan="2" width='5%' class='datalabel' nowrap align="right">&nbsp;</td>
				<td colspan="2" width='20%' class='datalabel' style='text-align:center;vertical-align:top;' nowrap align="right" valign="top" rowspan="2">
					<img src="./images/factions/CW.png" width="25px" id="newpilotrank">
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right" onclick="javascript:showSpaInfo(document.getElementById('addNewSPA').value);"><span id="showSpaInfo" style="visibility:hidden;"><i class="fa-solid fa-circle-info"></i>&nbsp;&nbsp;&nbsp;</span>Add SPA:</td>
				<td colspan="5" width='90%' class='datalabel' style="width:100%;">
					<select required name='addNewSPA' id='addNewSPA' onchange="javascript:showSpaInfoControl();" size='1' style='width:100%;'>
						<option value=""></option>
						<option value="Animal Mimicry [2]">Animal Mimicry [2]</option>
						<option value="Antagonizer [3]">Antagonizer [3]</option>
						<option value="Blood Stalker [2]">Blood Stalker [2]</option>
						<option value="Cluster Hitter [2]">Cluster Hitter [2]</option>
						<option value="Combat Intuition [3]">Combat Intuition [3]</option>
						<option value="Cross-Country [2]">Cross-Country [2]</option>
						<option value="Demoralizer [3]">Demoralizer [3]</option>
						<option value="Dodge [2]">Dodge [2]</option>
						<option value="Dust-Off [2]">Dust-Off [2]</option>
						<option value="Eagle's Eyes [2]">Eagle’s Eyes [2]</option>
						<option value="Environmental Specialist [2]">Environmental Specialist [2]</option>
						<option value="Fist Fire [2]">Fist Fire [2]</option>
						<option value="Float Like a Butterfly 1 [1]">Float Like a Butterfly 1 [1]</option>
						<option value="Float Like a Butterfly 2 [2]">Float Like a Butterfly 2 [2]</option>
						<option value="Float Like a Butterfly 3 [3]">Float Like a Butterfly 3 [3]</option>
						<option value="Float Like a Butterfly 4 [4]">Float Like a Butterfly 4 [4]</option>
						<option value="Forward Observer [1]">Forward Observer [1]</option>
						<option value="Golden Goose [3]">Golden Goose [3]</option>
						<option value="Ground-Hugger [2]">Ground-Hugger [2]</option>
						<option value="Headhunter [2]">Headhunter [2]</option>
						<option value="Heavy Lifter [1]">Heavy Lifter [1]</option>
						<option value="Hopper [1]">Hopper [1]</option>
						<option value="Hot Dog [2]">Hot Dog [2]</option>
						<option value="Human TRO [1]">Human TRO [1]</option>
						<option value="Iron Will [1]">Iron Will [1]</option>
						<option value="Jumping Jack [2]">Jumping Jack [2]</option>
						<option value="Lucky 1 [1]">Lucky 1 [1]</option>
						<option value="Lucky 2 [2]">Lucky 2 [2]</option>
						<option value="Lucky 3 [3]">Lucky 3 [3]</option>
						<option value="Lucky 4 [4]">Lucky 4 [4]</option>
						<option value="Maneuvering Ace [2]">Maneuvering Ace [2]</option>
						<option value="Marksman [2]">Marksman [2]</option>
						<option value="Melee Master [2]">Melee Master [2]</option>
						<option value="Melee Specialist [1]">Melee Specialist [1]</option>
						<option value="Multi-Tasker [2]">Multi-Tasker [2]</option>
						<option value="Natural Grace [3]">Natural Grace [3]</option>
						<option value="Oblique Artilleryman [1]">Oblique Artilleryman [1]</option>
						<option value="Oblique Attacker [1]">Oblique Attacker [1]</option>
						<option value="Range Master [2]">Range Master [2]</option>
						<option value="Ride the Wash [4]">Ride the Wash [4]</option>
						<option value="Sandblaster [2]">Sandblaster [2]</option>
						<option value="Shaky Stick [2]">Shaky Stick [2]</option>
						<option value="Sharpshooter [4]">Sharpshooter [4]</option>
						<option value="Slugger [1]">Slugger [1]</option>
						<option value="Sniper [3]">Sniper [3]</option>
						<option value="Speed Demon [2]">Speed Demon [2]</option>
						<option value="Stand-Aside [1]">Stand-Aside [1]</option>
						<option value="Street Fighter [2]">Street Fighter [2]</option>
						<option value="Sure-Footed [2]">Sure-Footed [2]</option>
						<option value="Swordsman [2]">Swordsman [2]</option>
						<option value="Tactical Genius [3]">Tactical Genius [3]</option>
						<option value="Terrain Master (Drag Racer) [3]">Terrain Master (Drag Racer) [3]</option>
						<option value="Terrain Master (Forest Ranger) [3]">Terrain Master (Forest Ranger) [3]</option>
						<option value="Terrain Master (Frogman) [3]">Terrain Master (Frogman) [3]</option>
						<option value="Terrain Master (Mountaineer) [3]">Terrain Master (Mountaineer) [3]</option>
						<option value="Terrain Master (Nightwalker) [3]">Terrain Master (Nightwalker) [3]</option>
						<option value="Terrain Master (Sea Monster) [3]">Terrain Master (Sea Monster) [3]</option>
						<option value="Terrain Master (Swamp Beast) [3]">Terrain Master (Swamp Beast) [3]</option>
						<option value="Weapon Specialist [3]">Weapon Specialist [3]</option>
						<option value="Wind Walker [2]">Wind Walker [2]</option>
						<option value="Zweihander [2]">Zweihander [2]</option>
						<option value="Light Horseman [2]">Light Horseman [2]</option>
						<option value="Heavy Horse [2]">Heavy Horse [2]</option>
						<option value="Foot Cavalry [1]">Foot Cavalry [1]</option>
						<option value="Urban Guerrilla [1]">Urban Guerrilla [1]</option>
					</select>
				</td>
				<td nowrap class="datalabel" style='text-align:left;' colspan='2' onclick='addSpecialPilotAbility();'>
					&nbsp;<i class='fas fa-plus-square'></i></a>
				</td>
			</tr>
			<tr>
				<td colspan="9">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' id="spa_sum" nowrap class="datalabel" style='text-align:center;vertical-align:middle;' colspan='1' rowspan="1">
					&nbsp;&nbsp;&nbsp;&nbsp;∑ <b><span id="sumlabel">4</span></b>
				</td>
				<td colspan="7" width='95%' class='datalabel' id="newSPAs">
					---
				</td>
				<td nowrap class="datalabel" style='text-align:right;vertical-align:top;' colspan='1' rowspan="1" valign="top">
				</td>
			</tr>
			<tr>
				<td colspan="9" class='datalabel' align="right">
					<span style='font-size:16px;'>
						<a href="#" onClick="save();"><i class="fa-solid fa-floppy-disk"></i></a>
					</span>
				</td>
			</tr>
		</table>
	</form>

	<div id="maleSelectorDiv" style="visibility:hidden;" onclick="javascript:closeMaleSelector();">
		<br>
		<table class="options" cellspacing="2" cellpadding="2" border=0px width="70%" height="70%">
			<tr id='scrollcontainertopborder'>
				<td>
					<div class='scroll-pane' width="100%" style="width:100%;">
						<?php echo $stringMalePilotImages."\n"; ?>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div id="femaleSelectorDiv" style="visibility:hidden;" onclick="javascript:closeFemaleSelector();">
		<br>
		<table class="options" cellspacing="2" cellpadding="2" border=0px width="70%" height="70%">
			<tr id='scrollcontainertopborder'>
				<td>
					<div class='scroll-pane' width="100%" style="width:100%;">
						<?php echo $stringFemalePilotImages."\n"; ?>
					</div>
				</td>
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

		<table width="100%" height="70%">
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

	<script>
		var formationFactionIdArray = <?php echo json_encode($array_formationFactionIds); ?>;
		var formationFactionLogosArray = <?php echo json_encode($array_formationFactionLogos); ?>;
		var formationFactionShortsArray = <?php echo json_encode($array_formationFactionShorts); ?>;
		var formationFactionNamesArray = <?php echo json_encode($array_formationFactionNames); ?>;
		var formationFactionRankOptions = <?php echo json_encode($array_formationFactionRankOptions); ?>;

		//for(var i=0;i<3;i++){
		//	alert(formationFactionRankOptions[i]);
		//}
	</script>
</body>

</html>
