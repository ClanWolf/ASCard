<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}
	// Get data on units from db
	$pid = $_SESSION['playerid'];
?>

<html lang="en">

<head>
	<title>Unit selector</title>
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

	<style>
		html, body {
			background-image: url('./images/body-bg_2.png');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 400px;
			height: 200px;
			background-color :#transparent;
			position: fixed;
			margin-left: -200px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
		}
	</style>
</head>

<body>
	<div id="header">
		<table style="width: 100%;" cellspacing="0" cellpadding="0">
			<tr>
				<td onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap>
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td onclick="location.href='./unitselector.php'" width="33%" nowrap><div class='mechselect_button_active'><a href='./unitselector.php'>SELECT UNIT</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td onclick="location.href='./createplayer.php'" width="34%" nowrap><div class='mechselect_button_normal'><a href='./createplayer.php'>CREATE PLAYER</a><br><span style='font-size:16px;'>Create a new player</span></div></td>
				<td onclick="location.href='./createunit.php'" width="33%" nowrap><div class='mechselect_button_normal'><a href='./logout.php'>CREATE UNIT / PILOTS</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
			</tr>
		</table>
	</div>
	
	<table class="box" cellspacing=10 cellpadding=10 border=0px>
		<tr>
			<td onclick="location.href='./unit.php?unit=5'" class='mechselect_button_active'><a href="./unit.php?unit=5">Meldric</a></td>
			<td onclick="location.href='./unit.php?unit=6'" class='mechselect_button_active'><a href="./unit.php?unit=6">Nimrod</a></td>
		</tr>
	</table>
</body>

</html>
