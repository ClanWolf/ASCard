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
	$formationId  = isset($_GET["formationid"]) ? filter_var($_GET["formationid"], FILTER_VALIDATE_INT) : -1;

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}
	$sql_asc_formation = "SELECT SQL_NO_CACHE * FROM asc_formation where formationid = " . $formationId . ";";
	$result_asc_formation = mysqli_query($conn, $sql_asc_formation);
	if (mysqli_num_rows($result_asc_formation) > 0) {
		while($row444 = mysqli_fetch_assoc($result_asc_formation)) {
			$FORMATIONNAME = $row444["formationname"];
			$FORMATIONTYPE = $row444["formationtype"];
			$FORMATION = $row444["formation"];
			$FORMATIONSHORT = $row444["formationshort"];
			$AUTOBUILDNAME = $row444["autobuildname"];
			$FACTION = $row444["factionid"];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Edit Formation</title>
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
	<script type="text/javascript" src="./scripts/formationtypes.js"></script>

	<script>
		let formationName = "<?php echo $FORMATIONNAME; ?>";
		let formationShort = "<?php echo $FORMATIONSHORT; ?>";
		let formationType = "<?php echo $FORMATIONTYPE; ?>";
		let formation = "<?php echo $FORMATION; ?>";
		let autobuild = "<?php echo $AUTOBUILDNAME; ?>";
		let faction = "<?php echo $FACTION; ?>";

		function showFormationTypeInfo(formType) {
			// If fadeIn is used here, css animation does not work anymore
			if (formType !== "") {
				document.getElementById("formationtypescontainer").style.visibility = "visible";
				showFormationType(formType);
			}
		}
		function closeFormationTypeInfo() {
			// If fadeIn is used here, css animation does not work anymore
			document.getElementById("formationtypescontainer").style.visibility = "hidden";
		}
		function getFirstLetters(str) {
			const firstLetters = str
				.split(' ')
				.map(word => word.charAt(0))
				.join('');
			//console.log(str);
			//console.log(firstLetters);
			return firstLetters;
		}
		function changeResultingName() {
			var na = "";
			var autobuildChecked = 0;
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 13) == "AUTOBUILDNAME") { autobuildChecked = el1.checked }
				}
			});

			let n1 = document.getElementById("NewFormationName").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let n2 = document.getElementById("NewFormationType").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let n3 = document.getElementById("NewFormation").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let fa = document.getElementById("NewFormationFaction").value;

			document.getElementById("NewFormationName").value = n1;
			document.getElementById("NewFormationType").value = n2;
			document.getElementById("NewFormation").value = n3;

			if (autobuildChecked) {
				let resultingName = n1 + " " + n2 + " " + n3;
				let resultingShort = n1 + " " + getFirstLetters(n2 + " " + n3);
				document.getElementById("resultingName").innerHTML = resultingName;
				document.getElementById("resultingShort").innerHTML = resultingShort;
				//console.log(resultingName);
				//console.log(resultingShort);
			} else {
				let resultingName = n1;
				let resultingShort = getFirstLetters(resultingName);
				document.getElementById("resultingName").innerHTML = n1;
				document.getElementById("resultingShort").innerHTML = resultingShort;
				//console.log(resultingName);
				//console.log(resultingShort);
			}
		}
		function save() {
			let n1 = document.getElementById("NewFormationName").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let n2 = document.getElementById("NewFormationType").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let n3 = document.getElementById("NewFormation").value.replace(/[^A-Za-z0-9 ]/g, '').replace(/  +/g, ' ');
			let n4 = document.getElementById("resultingShort").innerHTML;
			let fa = document.getElementById("NewFormationFaction").value;

			var na = "";
			var autobuildChecked = 0;
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 13) == "AUTOBUILDNAME") { autobuildChecked = el1.checked }
				}
			});

			//if (!n1 || !n2 || !n3 || !n4) {
			if (!n1) {
				alert("Enter valid name!");
			} else {
				let param_n1 = encodeURIComponent(n1);
				let param_n2 = encodeURIComponent(n2);
				let param_n3 = encodeURIComponent(n3);
				let param_n4 = encodeURIComponent(n4);

				var url="./save_formation_data.php?formationid="+<?php echo $formationId; ?>+"&newformationname="+param_n1+"&newformationtype="+param_n2+"&newformation="+param_n3+"&formationshort="+param_n4+"&autobuild="+autobuildChecked+"&factionid="+fa;
				window.frames['saveframe'].location.replace(url);
			}
		}
	</script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
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
			background: rgba(60,60,60,0.95);
		}
		select:valid, input:valid {
			background: rgba(70,70,70,0.75);
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

	<script>
		$(document).ready(function() {
			$("#cover").hide();

			// console.log("Name: " + formationName);
			// console.log("Type: " + formationType);
			// console.log("Formation: " + formation);

			document.getElementById("NewFormationName").value = formationName;
			document.getElementById("NewFormationType").value = formationType;
			document.getElementById("NewFormation").value = formation;
			document.getElementById("resultingShort").value = formationShort;
			document.getElementById("NewFormationFaction").value = faction;

			var na = "";
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 13) == "AUTOBUILDNAME") {
						if (autobuild === "1") {
							//console.log("autobuild true");
							el1.checked = true;
						} else {
							//console.log("autobuild false");
							el1.checked = false;
						}
					}
				}
			});

			let res = formationName;
			if (autobuild === "1") {
				if (formationType) {
					res = res + " " + formationType;
				}
				if (formation) {
					res = res + " " + formation;
				}
			}

			let resultingShort = formationName + " " + getFirstLetters(formationType + " " + formation);

			document.getElementById("resultingName").innerHTML = res;
			document.getElementById("resultingShort").innerHTML = resultingShort;

			// Set the height of the local scrollbars to the real height of the container elements (reload only)
			let realhightofscrollbar = document.getElementById("scrollcontainer").offsetHeight;
			var scrollcontainerdivs = document.getElementsByClassName("scroll-pane");
			for(var i=0; i < scrollcontainerdivs.length; i++) {
				scrollcontainerdivs[i].style.height = realhightofscrollbar+"px";
			}
		});
	</script>

	<div id="cover"></div>

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

	<div id="formationtypescontainer" style="visibility:hidden;" onclick="javascript:closeFormationTypeInfo();">
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
							<td class="datalabel" id="ut_name" align="left" width="90%" style="font-size:1.2em;">...</td><td nowrap class="datalabel" id="ut_variation" align="right" width="10%" style="font-size:1.2em;">...</td>
						</tr>
						<tr>
							<td class="datavalue_thinflow" style="font-size:0.75em;" align="left">
								<span id="ut_source">...</span>, <span id="ut_page">...</span>
							</td>
							<td nowrap class="datavalue_thinflow" id="ut_type">...</td>
						</tr>
						<tr>
							<td class="datavalue_thin" colspan="2"><hr></td>
						</tr>
						<tr>
							<td height="100%" colspan="2" align="left" valign="top" id="scrollcontainer">
								<div class='scroll-pane' width="100%" style="width:100%;">
									<table width="100%"><tr><td class="datavalue_thinflow" id="ut_desc">...</td></tr></table>
								</div>
							</td>
						</tr>
						<tr>
							<td class="datavalue_thin" colspan="2"><hr></td>
						</tr>
						<tr>
							<td nowrap class="datavalue_thin" colspan="2" align="center"><a href="javascript:closeFormationTypeInfo();">CLOSE</a></td>
						</tr>
					</table>
				</td>
				<td width="10%" align="right" valign="top" class="datalabel">&nbsp;</td>
				<!-- <td width="10%" align="left" valign="top"><a href="javascript:closeSpecialAbilities();">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-xmark" style="font-size:3em;"></i></a></td> -->
			</tr>
		</table>
	</div>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" style="width: 80px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>" class='menu_button_active'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_unit.php'>CREATE</a><br><span style='font-size:16px;'>Command / Unit</span></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_edit_game.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_edit_game.php'>GAME</a><br><span style='font-size:16px;'>Game settings</span></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_admin.php'>ADMIN</a><br><span style='font-size:16px;'>Administration</span></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
			<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="autocomplete_off_hack_xfr4!k">
		<table width="60%" class="options" cellspacing="2" cellpadding="2" border=0px>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Formation name:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<input autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="this.value = this.value.toUpperCase();changeResultingName();" onchange="changeResultingName();" type="text" id="NewFormationName" width="100%" style="width:100%;">
				</td>
				<td rowspan="4" nowrap valign="middle"><a href="javascript:showFormationTypeInfo(document.getElementById('NewFormationType').value);">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-circle-info"></i>&nbsp;&nbsp;</a></td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Formation type:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<select required name='NewFormationType' id='NewFormationType' onchange="changeResultingName();" size='1' style='width:100%;'>
						<option value=""></option>
						<option value="AEROSPACE SUPERIORITY">AEROSPACE SUPERIORITY</option>
						<option value="AIR">AIR</option>
						<option value="ANTI MECH">ANTI MECH</option>
						<option value="ASSAULT">ASSAULT</option>
						<option value="FAST ASSAULT">FAST ASSAULT</option>
						<option value="BATTLE" selected>BATTLE</option>
						<option value="LIGHT BATTLE">LIGHT BATTLE</option>
						<option value="MEDIUM BATTLE">MEDIUM BATTLE</option>
						<option value="HEAVY BATTLE">HEAVY BATTLE</option>
						<option value="BERSERKER">BERSERKER</option>
						<option value="CAVALRY">CAVALRY</option>
						<option value="LIGHT CAVALRY">LIGHT CAVALRY</option>
						<option value="MECHANIZED COMBINED TRANSPORT">MECHANIZED COMBINED TRANSPORT</option>
						<option value="NOVA COMBINED TRANSPORT">NOVA COMBINED TRANSPORT</option>
						<option value="COMMAND">COMMAND</option>
						<option value="VEHICLE COMMAND">VEHICLE COMMAND</option>
						<option value="ELECTRONIC WARFARE">ELECTRONIC WARFARE</option>
						<option value="FIRE">FIRE</option>
						<option value="SUPPORT FIRE">SUPPORT FIRE</option>
						<option value="ARTILLERY FIRE">ARTILLERY FIRE</option>
						<option value="DIRECT FIRE">DIRECT FIRE</option>
						<option value="ANTI-AIR FIRE">ANTI-AIR FIRE</option>
						<option value="FIRE SUPPORT">FIRE SUPPORT</option>
						<option value="HORDE">HORDE</option>
						<option value="HUNTER">HUNTER</option>
						<option value="INTERCEPTOR">INTERCEPTOR</option>
						<option value="LIGHT FIRE">LIGHT FIRE</option>
						<option value="ORDER">ORDER</option>
						<option value="PHALANX">PHALANX</option>
						<option value="PURSUIT">PURSUIT</option>
						<option value="PROBE PURSUIT">PROBE PURSUIT</option>
						<option value="SWEEP PURSUIT">SWEEP PURSUIT</option>
						<option value="RECCON">RECCON</option>
						<option value="LIGHT RECCON">LIGHT RECCON</option>
						<option value="HEAVY RECCON">HEAVY RECCON</option>
						<option value="RIFLE">RIFLE</option>
						<option value="ROGUE">ROGUE</option>
						<option value="STRATEGIC COMMAND">STRATEGIC COMMAND</option>
						<option value="STRIKE">STRIKE</option>
						<option value="STRIKER">STRIKER</option>
						<option value="LIGHT STRIKER">LIGHT STRIKER</option>
						<option value="HEAVY STRIKER">HEAVY STRIKER</option>
						<option value="SUPPORT">SUPPORT</option>
						<option value="TRANSPORT">TRANSPORT</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right">Formation:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<select required name='NewFormation' id='NewFormation' onchange="changeResultingName();" size='1' style='width:100%;'>
						<option value=""></option>
						<option value="STAR" selected>STAR</option>
						<option value="LANCE">LANCE</option>
						<option value="LEVEL II">LEVEL II</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='5%' class='datalabel' colspan="1" align="right">Faction:</td>
				<td width='90%' class='datalabel' colspan="1" style="width:100%;">
					<select required name='NewFormationFaction' id='NewFormationFaction' size='1' style='width:100%;'>
						<option  value="3" selected>ComStar [CS]</option>
						<option  value="1">Clan Wolf [CW]</option>
						<option value="13">Clan Wolf in Exile [CWiE]</option>
						<option  value="9">Clan Jade Falcon [CJF]</option>
						<option  value="5">Clan Ghostbear [CGB]</option>
						<option value="12">Clan Smoke Jaguar [CSJ]</option>
						<option value="14">Clan Snow Raven [CSR]</option>
						<option value="15">Clan Nova Cat [CNC]</option>
						<option  value="2">Lyran Alliance [LA]</option>
						<option  value="7">Lyran Commonwealth [LC]</option>
						<option  value="4">Draconis Combine [DC]</option>
						<option  value="8">Federated Suns [FS]</option>
						<option value="10">Free Worlds League [FWL]</option>
						<option value="11">Capellan Confederation [CC]</option>
						<option  value="6">Wolfs Dragoons [M-WD]</option>
					</select>
				</td>
				<td width='10px'></td>
			</tr>
			<tr>
				<td colspan="3" width='5%' class='datalabel' nowrap align="left"><hr></td>
			</tr>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeResultingName();" type="checkbox" class="bigcheck" name="AUTOBUILDNAME" value="false" checked="false"/><span class="bigcheck-target"></span></label>
				</td>
				<td colspan="2" align="left" nowrap class="datalabel">
					Auto build name
				</td>
			</tr>
			<tr>
				<td colspan="3" width='5%' class='datalabel' nowrap align="left"><hr></td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right" valign="top" style="vertical-align:top;">Resulting name:</td>
				<td colspan="2" width='90%' class='datalabel' nowrap valign="top" style="width:100%;">
					<span id="resultingName"><?php echo $FORMATIONNAME ?></span><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="right" valign="top" style="vertical-align:top;">Short:</td>
				<td colspan="2" width='90%' class='datalabel' nowrap valign="top" style="width:100%;">
					<span id="resultingShort"><?php echo $FORMATIONSHORT ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="3" class='datalabel' align="right">
					<span style='font-size:16px;'>
						<a href="#" onClick="save();"><i class="fa-solid fa-floppy-disk"></i></a>
					</span>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
