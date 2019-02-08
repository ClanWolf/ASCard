<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}
	// Get data on units from db
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Player creator</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
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

	<script type="text/javascript" src="./scripts/jquery-3.3.1.min.js"></script>
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
		.box {
			width: 400px;
			height: 200px;
			background-color: #transparent;
			position: fixed;
			margin-left: -200px;
			// margin-top: -100px;
			// top: 50%;
			left: 50%;
		}
		.options {
			z-index: 3;
			position: absolute;
			vertical-align: middle;
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 25px;
			background: rgba(60,60,60,0.75);
			width: 300px;
			height: 70px;
			top: 80px;
			right: 20px;
			color: #ddd;
			border-color: #aaa;
		}
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});
	</script>

<?php
	echo "<div id='player_image'>";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>";
	echo "</div>";
?>

	<div id="cover"></div>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap>
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td onclick="location.href='./unitselector.php'" width="25%" nowrap><div class='mechselect_button_normal'><a href='./unitselector.php'>SELECT UNIT</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td onclick="location.href='./createplayer.php'" width="25%" nowrap><div class='mechselect_button_active'><a href='./createplayer.php'>CREATE PLAYER</a><br><span style='font-size:16px;'>Create a new player</span></div></td>
				<td onclick="location.href='./createunit.php'" width="25%" nowrap><div class='mechselect_button_normal'><a href='./createunit.php'>CREATE MECH / PILOTS</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td onclick="location.href='./options.php'" width="25%" nowrap><div class='mechselect_button_normal'><a href='./options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>
</body>

</html>
