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

	$deletemech = isset($_GET["dm"]) ? $_GET["dm"] : "";

	if ($deletemech=="1") {
		$mechid = isset($_GET["mechid"]) ? $_GET["mechid"] : "";
		$pilotid = isset($_GET["pilotid"]) ? $_GET["pilotid"] : "";

		// delete assignment
		// only the assignment is deleted
		// the mech and the pilot are kept in the database for later re-assignment
		// the model number probably stays the same
		$sqldeleteassignment = "DELETE FROM asc_assign WHERE pilotid = ".$pilotid." and mechid = " . $mechid . ";";
		if (mysqli_query($conn, $sqldeleteassignment)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteassignment . "<br>" . mysqli_error($conn);
		}

		echo "<meta http-equiv='refresh' content='0;url=./gui_selectunit.php'>";
	}
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit selector</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
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
	</script>

<?php
	echo "	<div id='player_image'>";
	echo "		<img src='./images/player/".$pimage."' width='60px' height='60px'>";
	echo "	</div>";
?>

	<div id="cover"></div>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="17%"><div class='mechselect_button_active'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_assignunit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_assignunit.php'>ASSIGN MECH</a><br><span style='font-size:16px;'>Assign Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<table align="center" cellspacing=2 cellpadding=2 border=0px>
		<tr>
<?php

	$addMechToUnitLinkArray = array();
	$assignMechToUnitLinkArray = array();
	$mechsInAllUnits = array();

	//echo "		<td nowrap style='width:170px;height:70px;' class='mechselect_button_active'>".$pname."</td>";
	// Select units for this player
	if (!($stmtUnits = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_unit where playerid = ".$pid." ORDER BY unitid;"))) {
		echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
	}
	if ($stmtUnits->execute()) {
		$resUnits = $stmtUnits->get_result();
		while ($rowUnit = $resUnits->fetch_assoc()) {
			$unitidSelected = $rowUnit['unitid'];
			$factionidSelected = $rowUnit['factionid'];
			$forcenameSelected = $rowUnit['forcename'];

			array_push($addMechToUnitLinkArray, "gui_createunit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);
			array_push($assignMechToUnitLinkArray, "gui_assignunit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);

			$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
			$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
			if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
				echo "			<td nowrap style='width:240px;height:40px;' onclick='location.href=\"gui_unit.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
				echo "				<a href='gui_unit.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
				echo "			</td>\n";
			} else {
				echo "			<td nowrap style='background-color:#444444;width:240px;height:40px;' class='mechselect_button_active'>\n";
				echo "				".$forcenameSelected."\n";
				echo "			</td>\n";
			}

			$mechsInSingleUnit = array();
			$c = 0;
			while ($rowUnitAssignment = $result_asc_checkunitassignments->fetch_assoc()) {

				$c++;
				$assignedMechID = $rowUnitAssignment['mechid'];
				$assignedPilotID = $rowUnitAssignment['pilotid'];

				$sql_asc_mech = "SELECT SQL_NO_CACHE * FROM asc_mech where mechid=".$assignedMechID.";";
				$result_asc_mech = mysqli_query($conn, $sql_asc_mech);
				if (mysqli_num_rows($result_asc_mech) > 0) {
					while($rowMech = mysqli_fetch_assoc($result_asc_mech)) {
						$mechnumber = $rowMech['mech_number'];
						$mechchassisname = $rowMech['as_model'];
						$mechcustomname = $rowMech['custom_name'];
					}
				}

				$sql_asc_pilot = "SELECT SQL_NO_CACHE * FROM asc_pilot where pilotid=".$assignedPilotID.";";
				$result_asc_pilot = mysqli_query($conn, $sql_asc_pilot);
				if (mysqli_num_rows($result_asc_pilot) > 0) {
					while($rowPilot = mysqli_fetch_assoc($result_asc_pilot)) {
						$pilotrank = $rowPilot['rank'];
						$pilotname = $rowPilot['name'];
					}
				}

				$mechDetailString = "";
				$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_unit.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='background-color:#444444;' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align: middle;'><img style='vertical-align:middle;' src='./images/DD_01.png' height='40px'></div></td>\n";
				$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_unit.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='width:240px;background-color:#444444;' class='mechselect_button_active'>\n";
				$mechDetailString = $mechDetailString."				<table width='100%' cellspacing=0 cellpadding=0 border=0px>\n";
				$mechDetailString = $mechDetailString."					<tr>\n";
				$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:#444444;text-align:left;' class='mechselect_button_active'><a href=gui_unit.php?unit=".$unitidSelected."&chosenmech=".$c.">#".$mechnumber." ".$pilotname."</a>\n";
				$mechDetailString = $mechDetailString."							<br><span style='font-size:16px;'>".$mechchassisname."</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";
				$mechDetailString = $mechDetailString."						<td nowrap width='1%' style='background-color:#444444;text-align:right;' class='mechselect_button_active'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
				$mechDetailString = $mechDetailString."								<a href='./gui_selectunit.php?dm=1&mechid=".$assignedMechID."&pilotid=".$assignedPilotID."'><i class='fa fa-fw fa-minus-square'></i></a>\n";
				$mechDetailString = $mechDetailString."							</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";
				$mechDetailString = $mechDetailString."					</tr>\n";
				$mechDetailString = $mechDetailString."				</table>\n";
				$mechDetailString = $mechDetailString."			</td>\n";

				array_push($mechsInSingleUnit, $mechDetailString);
			}
			array_push($mechsInAllUnits, $mechsInSingleUnit);
		}
	}
	echo "		</tr>\n";
	echo "		<tr>\n";
//	echo "			<td></td>\n";
	echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
	echo "				<a href='".$assignMechToUnitLinkArray[0]."'><i class='fa fa-fw fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	echo "				<a href='".$addMechToUnitLinkArray[0]."'><i class='fa fa-asterisk'></i></a>\n";
	echo "			</td>\n";
	echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
	echo "				<a href='".$assignMechToUnitLinkArray[1]."'><i class='fa fa-fw fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	echo "				<a href='".$addMechToUnitLinkArray[1]."'><i class='fa fa-asterisk'></i></a>\n";
	echo "			</td>\n";
	echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
	echo "				<a href='".$assignMechToUnitLinkArray[2]."'><i class='fa fa-fw fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	echo "				<a href='".$addMechToUnitLinkArray[2]."'><i class='fa fa-asterisk'></i></a>\n";
	echo "			</td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";
//	echo "			<td></td>\n";

	foreach ($mechsInAllUnits as &$mechsInSingleUnit) {
		echo "			<td style='width:170px;background-color:#333333;' valign='top'>";
		echo "				<table cellspacing=2 cellpadding=0 border=0px>";
		foreach ($mechsInSingleUnit as &$mech) {
			echo "					<tr>";
			echo "						".$mech;
			echo "					</tr>";
		}
		echo "				</table>";
		echo "			</td>";
	}
	echo "		</tr>\n";
?>

	</table>
</body>

</html>
