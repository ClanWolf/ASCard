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
		function changeResultingName() {
			var na = "";
			var autobuildChecked = 0;
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 13) == "AUTOBUILDNAME") { autobuildChecked = el1.checked }
				}
			})

			let n1 = document.getElementById("NewFormationName").value;
			let n2 = document.getElementById("NewFormationCategory").value;
			let n3 = document.getElementById("NewFormationType").value;

			if (autobuildChecked) {
				document.getElementById("resultingName").innerHTML = n1 + " " + n2 + " " + n3;
			} else {
				document.getElementById("resultingName").innerHTML = n1;
			}
		}
		function save() {
		}
	</script>
	<script type="text/javascript" src="./scripts/passive-events-support/main.js"></script>

	<script type="text/javascript" src="./scripts/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>

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
			background: rgba(40,40,40,0.75);;
		}
		select:valid, input:valid {
			background: rgba(70,70,70,0.75);;
		}
		.scroll-pane {
			width: 100%;
			height: 200px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 200px;
		}
	</style>
</head>

<body>
	<iframe name="saveframe" id="iframe_save"></iframe>
	<script type="text/javascript" src="./scripts/log_enable.js"></script>

	<script>
		$(document).ready(function() {
			$("#cover").hide();
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
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_active'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_unit.php'>ADD</a><br><span style='font-size:16px;'>Create a unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_edit_game.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_edit_game.php'>GAME</a><br><span style='font-size:16px;'>Game settings</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_admin.php'>ADMIN</a><br><span style='font-size:16px;'>Administration</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="autocomplete_off_hack_xfr4!k">
		<table width="50%" class="options" cellspacing="2" cellpadding="2" border=0px>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="left">Formation name:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<input autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="this.value = this.value.toUpperCase();changeResultingName();" onchange="changeResultingName();" type="text" id="NewFormationName" width="100%" style="width:100%;">
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="left">Formation type:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<select required name='NewFormationCategory' id='NewFormationCategory' onchange="changeResultingName();" size='1' style='width:100%;'>
						<option value="" selected></option>
						<option value="BATTLE" selected>BATTLE</option>
						<option value="ASSAULT">ASSAULT</option>
						<option value="STRIKER">STRIKER</option>
						<option value="CAVALRY">CAVALRY</option>
						<option value="FIRE">FIRE</option>
						<option value="RECON">RECON</option>
						<option value="PURSUIT">PURSUIT</option>
						<option value="COMMAND">COMMAND</option>
						<option value="SUPPORT">SUPPORT</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="left">Formation type:</td>
				<td colspan="1" width='90%' class='datalabel' style="width:100%;">
					<select required name='NewFormationType' id='NewFormationType' onchange="changeResultingName();" size='1' style='width:100%;'>
						<option value="STAR" selected>STAR</option>
						<option value="LANCE">LANCE</option>
						<option value="LEVEL II">LEVEL II</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" width='5%' class='datalabel' nowrap align="left"><hr></td>
			</tr>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeResultingName();" type="checkbox" class="bigcheck" name="AUTOBUILDNAME" value="yes" checked="true"/><span class="bigcheck-target"></span></label>
				</td>
				<td align="left" nowrap class="datalabel">
					Auto build name
				</td>
			</tr>
			<tr>
				<td colspan="2" width='5%' class='datalabel' nowrap align="left"><hr></td>
			</tr>
			<tr>
				<td colspan="1" width='5%' class='datalabel' nowrap align="left">Resulting name:</td>
				<td colspan="1" width='90%' class='datalabel' nowrap style="width:100%;">
					<span id="resultingName"><?php echo $FORMATIONNAME ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2" class='datalabel' align="right">
					<span style='font-size:16px;'>
						<a href="#" onClick="save();"><i class="fa-solid fa-floppy-disk"></i></a>
					</span>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
