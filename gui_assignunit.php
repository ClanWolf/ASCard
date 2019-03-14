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
	$pname = $_SESSION['name'];
	$pimage = $_SESSION['playerimage'];
	$hideMinusButtons = $_SESSION['option3'];

	$paramunitid = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
    $paramunitname = isset($_GET["unitname"]) ? $_GET["unitname"] : "";
	$assignmech = isset($_GET["assignmech"]) ? $_GET["assignmech"] : "";
	$deletestoredmech = isset($_GET["deletestoredmech"]) ? $_GET["deletestoredmech"] : "";

	if ($assignmech == 1) {
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";
		$MECHID = isset($_GET["MECHID"]) ? $_GET["MECHID"] : "";

		$sql_update_assignment = "UPDATE asc_assign set unitid = ".$UNITID." where mechid = ".$MECHID;
		if (mysqli_query($conn, $sql_update_assignment)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_update_assignment . "<br>" . mysqli_error($conn);
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_selectunit.php'>";
	}

	if ($deletestoredmech == 1) {
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";
		$MECHID = isset($_GET["MECHID"]) ? $_GET["MECHID"] : "";

		//$PILOTID =

		// TODO: !!! Delete the mech (by mechid)
		// TODO: !!! Delete the mechstatus (by mechid)
		// TODO: !!! Delete the pilot (by pilotid)
		// TODO: !!! Delete the assignment (by mechid and pilotid / unitid is null at this point)

		//"delete from asc_mech where mechid = ".$MECHID;
		//"delete from asc_mechstatus where mechid = ".$MECHID;
		//"delete from asc_pilot where pilotid = ".$PILOTID;
		//"delete from asc_assign where pilotid = ".$PILOTID." and mechid = ".$MECHID;

		echo "<meta http-equiv='refresh' content='0;url=./gui_selectunit.php'>";
	}
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit assignment</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='viewport' content='user-scalable=0'>

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
		});

		function assignMech() {
			var url="./gui_assignunit.php?assignmech=1";

			// Assign existing mech
			var UNITID = document.getElementById('UNITID').value;
			var MECHID = document.getElementById('existingMechs').value;

			if (MECHID == 0) {
				alert("Select a stored Mech!");
				return;
			}

			url=url+"&UNITID="+encodeURIComponent(UNITID);
			url=url+"&MECHID="+encodeURIComponent(MECHID);

			// alert(url);
			window.location.href = url;
		}

		function deleteStoredMech() {
			var url="./gui_assignunit.php?deletestoredmech=1";

			// Assign existing mech
			var UNITID = document.getElementById('UNITID').value;
			var MECHID = document.getElementById('existingMechs').value;

			if (MECHID == 0) {
				alert("Select a stored Mech!");
				return;
			}

			url=url+"&UNITID="+encodeURIComponent(UNITID);
			url=url+"&MECHID="+encodeURIComponent(MECHID);

			// alert(url);
			window.location.href = url;
		}
	</script>
<?php
	echo "<div id='player_image'>\n";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>\n";
	echo "</div>\n";
?>
	<div id="cover"></div>
	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_assignunit.php'" width="17%"><div class='mechselect_button_active'><a href='./gui_assignunit.php'>ASSIGN MECH</a><br><span style='font-size:16px;'>Assign Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<form>
		<table class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='4'>
					Existing Mechs: <select required name='existingMechs' id='existingMechs' size='1' onchange="" style='width:400px;'>
						<option value="0"><<< Select a Mech >>></option>
<?php
	$sql_asc_mechs = "select m.mechid, m.mech_number, m.as_model, p.name from asc_assign a, asc_mech m, asc_pilot p where a.unitid is null and a.mechid = m.mechid and a.pilotid = p.pilotid";
	$result_asc_mechs = mysqli_query($conn, $sql_asc_mechs);
	if (mysqli_num_rows($result_asc_mechs) > 0) {
		while($rowMechs = mysqli_fetch_assoc($result_asc_mechs)) {
			// #81 | Timber Wolf (Mad Cat) E (Mike)
			$mechid = $rowMechs['mechid'];
			$mechnumber = $rowMechs['mech_number'];
			$model = $rowMechs['as_model'];
			$pilotname = $rowMechs['name'];

			$entryValue = $mechid;
			$entryString = $mechnumber." | ".$model." [".$pilotname."]";

			echo "						<option value=".$entryValue.">".$entryString."</option>";
		}
	}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='3'>Add to unit: <select required name='UNITID' id='UNITID' size='1' style='width:250px;'>
<?php
	$sql_asc_playersunits = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid=".$pid;
	$result_asc_playersunits = mysqli_query($conn, $sql_asc_playersunits);
	if (mysqli_num_rows($result_asc_playersunits) > 0) {
		while($rowUnits = mysqli_fetch_assoc($result_asc_playersunits)) {
			$unitid = $rowUnits['unitid'];
			$forcename = $rowUnits['forcename'];
			if ($paramunitid == $unitid) {
				echo "										<option value='".$unitid."' selected>".$forcename."</option>\n";
			} else {
				echo "										<option value='".$unitid."'>".$forcename."</option>\n";
			}
		}
	}
?>
					</select>
				</td>
				<td align="right">
					<a href='#' onClick='assignMech();'><i class='fa fa-fw fa-plus-square'></i></a>
				</td>
			</tr>
<?php
	if ($hideMinusButtons) {
		echo "			<tr>";
		echo "			    <td colspan='4'>";
		echo "			</tr>";
	} else {
		echo "			<tr>";
		echo "				<td colspan='4'><hr></td>";
		echo "			</tr>";
		echo "			<tr>";
		echo "				<td colspan='3'>Delete selected Mech from Hangar (!)</td>";
		echo "				<td align='right'>";
		echo "					<a href='#' onClick='deleteStoredMech();'><i class='fa fa-fw fa-minus-square'></i></a>";
		echo "				</td>";
		echo "			</tr>";
	}
?>
		</table>
	</form>
</body>

</html>
