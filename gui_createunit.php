<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit creator</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

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
	<script type="text/javascript" src="./scripts/basic.js"></script>
	<script type="text/javascript" src="./scripts/masterunitlist.js"></script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 80%;
			background-color :#transparent;
			top: 50%;
			left: 50%;
		}
		.options {
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 5px;
			background: rgba(60,60,60,0.75);
			color: #ddd;
			border-color: #aaa;
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
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
			fetchMechList();
			document.getElementById("units").selectedIndex = "1";
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
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="20%"><div class='mechselect_button_active'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<form>
		<table class="options" cellspacing=10 cellpadding=5 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;'>
					<div>
						<table cellspacing=5 cellpadding=5>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%' colspan='3'>
									Tech: <select required name='tech' id='tech' size='1' onchange="fetchMechList();">
										<option value="2">Clan</option>
										<option value="1">IS</option>
									</select>

									Tons: <select required name='tonnage' id='tonnage' size='1' onchange="fetchMechList();">
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
										<option value="35">35</option>
										<option value="40">40</option>
										<option value="45">45</option>
										<option value="50">50</option>
										<option value="55">55</option>
										<option value="60">60</option>
										<option value="65">65</option>
										<option value="70">70</option>
										<option value="75">75</option>
										<option value="80">80</option>
										<option value="85">85</option>
										<option value="90">90</option>
										<option value="95">95</option>
										<option value="100">100</option>
									</select>

									<input required type="text" id="NameFilter" name="NameFilter" onchange="fetchMechList();" style="width:100px">
								</td>
							</tr>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%' colspan='3'>
									<!-- will be filled by 'getMechList();' -->
									<select required name='units' id='units' size='1' onchange="mechSelected();" style="width:300px"></select>
								</td>
							</tr>

							<!--<tr> -->
							<!-- 	<td nowrap class="datalabel" style='text-align:left;' width='50%' colspan='2'> -->
							<!-- 		<textarea rows="10" cols="80" id="url"></textarea> -->
							<!-- 	</td> -->
							<!--</tr> -->

							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%'>
									<input required type="text" id="MNA" name="MNA"> MNA<br>
									<input required type="text" id="MNU" name="MNU"> MNU<br>
									<input required type="text" id="TP" name="TP"> TP<br>
									<input required type="text" id="SZ" name="SZ"> SZ<br>
									<input required type="text" id="TMM" name="TMM"> TMM<br>
								</td>
								<td nowrap class="datalabel" style='text-align:left;' width='50%'>
									<input required type="text" id="MV" name="MV"> MV<br>
									<input required type="text" id="ROLE" name="ROLE"> ROLE<br>
									<input required type="text" id="DMGS" name="DMGS"> DMG S<br>
									<input required type="text" id="DMGM" name="DMGM"> DMG M<br>
									<input required type="text" id="DMGL" name="DMGL"> DMG L<br>
								</td>
								<td nowrap class="datalabel" style='text-align:left;' width='50%'>
									<input required type="text" id="OV" name="OV"> OV<br>
									<input required type="text" id="A" name="A"> A<br>
									<input required type="text" id="S" name="S"> S<br>
									<input required type="text" id="PVA" name="PVA"> PV<br>
									<input required type="text" id="SPCL" name="SPCL"> SPCL<br>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td nowrap style='text-align:left;vertical-align:top'>
					<div>
						<table width='100%' cellspacing=5 cellpadding=5>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%'>
									<input type="text" required id="PN" name="PN"> PilotName<br>
									<input type="text" required id="PCS" name="PCS"> PilotCallsign<br>
									<input type="text" required id="PR" name="PR"> PilotRank<br>
									<input type="text" required id="PI" name="PI"> PilotImage<br>
									<input type="text" required id="SKILL" name="SKILL"> SKILL<br>

									<br>Add to unit:<br>

									<select required name='UID' id='UID' size='1' style='width:250px;'>
										<option><<< Select Unit >>></option>
										<option value="AlphaCommandStar">Alpha Command Star</option>
										<option value="BravoCommandStar">Bravo Command Star</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
