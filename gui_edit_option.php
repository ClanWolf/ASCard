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
		//die("Check position 8");
	}

	// Get data from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];

	$isAdmin = $_SESSION['isAdmin'];

	$opt1 = isset($_GET["opt1"]) ? $_GET["opt1"] : "";
	$opt2 = isset($_GET["opt2"]) ? $_GET["opt2"] : "";
	$opt3 = isset($_GET["opt3"]) ? $_GET["opt3"] : "";
	$opt4 = isset($_GET["opt4"]) ? $_GET["opt4"] : "";

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	if ($opt1 == true || $opt2 == true || $opt3 == true || $opt4 == true) {
		// storing changed options to database
		$sql_update_options = "UPDATE asc_options SET OPTION1=".$opt1.", OPTION2=".$opt2.", OPTION3=".$opt3.", OPTION4=".$opt4." WHERE playerid = ".$pid;
		$result_update_options = mysqli_query($conn, $sql_update_options);
		$playMode = $opt3;
		$distancesHexes = $opt4;
		echo "<meta http-equiv='refresh' content='0;url=./gui_edit_option.php'>";
		header("Location: ./gui_edit_option.php");
		//die("Check position 7");
	} else {
		// getting options from database
		$sql_asc_options = "SELECT SQL_NO_CACHE * FROM asc_options where playerid = ".$pid;
		$result_asc_options = mysqli_query($conn, $sql_asc_options);
		if (mysqli_num_rows($result_asc_options) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_options)) {
				$opt1 = $row["option1"];
				$opt2 = $row["option2"];
				$opt3 = $row["option3"];
				$opt4 = $row["option4"];
				$_SESSION['option1'] = $opt1;
				$_SESSION['option2'] = $opt2;
				$_SESSION['option3'] = $opt3;
				$_SESSION['option4'] = $opt4;
			}
		}
	}
	$playMode = $opt3;

	$file_cacheversion = file_get_contents('./cache/mul/cache.version', true);
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Options</title>
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
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});

		function changeOption() {
			var na = "";
			var opt1 = 0;
			var opt2 = 0;
			var opt3 = 0;
			var opt4 = 0;
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 4) == "OPT1") { opt1 = el1.checked }
					if (na.substring(0, 4) == "OPT2") { opt2 = el1.checked }
					if (na.substring(0, 4) == "OPT3") { opt3 = el1.checked }
					if (na.substring(0, 4) == "OPT4") { opt4 = el1.checked }
				}
			})
			var url="./gui_edit_option.php?opt1="+opt1+"&opt2="+opt2+"&opt3="+opt3+"&opt4="+opt4;
			// alert (url);
			window.location.href = url;
		}

		function setOptions() {
			var na = "";
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
			na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 4) == "OPT1") { el1.checked = <?php echo $opt1 ?> }
					if (na.substring(0, 4) == "OPT2") { el1.checked = <?php echo $opt2 ?> }
					if (na.substring(0, 4) == "OPT3") { el1.checked = <?php echo $opt3 ?> }
					if (na.substring(0, 4) == "OPT4") { el1.checked = <?php echo $opt4 ?> }
				}
			})
		}
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
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
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

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_active'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<div>
		<table class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT1" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Block other players units
				</td>
			</tr>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT2" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Show pilot info in playmode (top left)
				</td>
			</tr>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT4" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Show distances in hexes
				</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<td align="left" class='datalabel'>
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT3" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Play mode (deactivate for unit editing)
				</td>
			</tr>
		</table>
	</div>

	<script>
		setOptions();
	</script>
</body>

</html>
