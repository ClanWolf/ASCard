<?php
	session_start();
	if (!isset($_SESSION['userid'])) {
		// if not logged in, redirect to the login page
		//echo "<meta http-equiv='refresh' content='0;url=./login.php'> ";
		//die();
	}
	// Get data on units from db

?>

<html lang="en">

<head>
	<link rel="stylesheet" href="./styles/styles.css" type="text/css">
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
	<table class="box" cellspacing=10 cellpadding=10 border=0px>
		<tr>
			<td onclick="location.href='./unit.php?unit=5'" class='mechselect_button_active'><a href="./unit.php?unit=5">Meldric</a></td>
			<td onclick="location.href='./unit.php?unit=6'" class='mechselect_button_active'><a href="./unit.php?unit=6">Nimrod</a></td>
		</tr>
	</table>
</body>

</html>
