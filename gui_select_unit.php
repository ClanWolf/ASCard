<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
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
	$togglebid = isset($_GET["activebid"]) ? $_GET["activebid"] : "";

	if ($deletemech=="1") {
		$mechid = isset($_GET["mechid"]) ? $_GET["mechid"] : "";
		$pilotid = isset($_GET["pilotid"]) ? $_GET["pilotid"] : "";

		// delete assignment
		// only the assignment is deleted
		// the mech and the pilot are kept in the database for later re-assignment
		// the model number probably stays the same
		//$sqldeleteassignment = "DELETE FROM asc_assign WHERE pilotid = ".$pilotid." and mechid = " . $mechid . ";";
		$sqldeleteassignment = "UPDATE asc_assign set unitid=null WHERE pilotid = ".$pilotid." and mechid = " . $mechid . ";";
		if (mysqli_query($conn, $sqldeleteassignment)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteassignment . "<br>" . mysqli_error($conn);
		}

		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
	}

	if ($togglebid == "1" || $togglebid == "0") {
		$mechid = isset($_GET["mechid"]) ? $_GET["mechid"] : "";
	    $sqltogglebid = "UPDATE asc_mech set active_bid=".$togglebid." WHERE mechid = " . $mechid . ";";
		if (mysqli_query($conn, $sqltogglebid)) {
			// Success
			//echo "Error: " . $sqltogglebid . "<br>";
		} else {
			// Error
			echo "Error: " . $sqltogglebid . "<br>" . mysqli_error($conn);
		}

		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
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
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="17%"><div class='mechselect_button_active'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>Other combatants</span></div></td>
				<td nowrap onclick="location.href='./gui_assign_unit.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td>
				<td nowrap onclick="location.href='./gui_create_mech.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_create_mech.php'>ADD</a><br><span style='font-size:16px;'>Create a Mech/BA</span></div></td>
				<td nowrap onclick="location.href='./gui_create_player.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_edit_option.php'" width="17%"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
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
	$pointvaluetotal = 0;
	$pointvaluetotalactivebid = 0;
	$tonnagetotal = 0;
	$tonnagetotalactivebid = 0;

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

			array_push($addMechToUnitLinkArray, "gui_create_mech.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);
			array_push($assignMechToUnitLinkArray, "gui_assign_unit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);

			$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
			$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
			if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
				echo "			<td nowrap style='width:270px;height:40px;' onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
				echo "				<table style='width:100%;' cellspacing=0 cellpadding=0>\n";
				echo "					<tr>\n";
				if (!$hideMinusButtons) {
					echo "						<td style='text-align:left;'>\n";
					echo "							<a href='gui_edit_unit.php?unit=".$unitidSelected."'><i class='fa fa-edit'></i></a>\n";
					echo "						</td>\n";
				}
				echo "						<td style='text-align:center;'>\n";
				echo "							<a href='gui_play_mech.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
				echo "						</td>\n";
				echo "						<td style='text-align:right;'>\n";
				echo "							<img src='https://www.clanwolf.net/apps/ASCard/images/factions/CW.png' width='20px' style='border:1px solid;'>\n";
				echo "						</td>\n";
				echo "					</tr>\n";
				echo "				</table>\n";
				echo "			</td>\n";
			} else {
				echo "			<td nowrap style='background-color:#444444;width:270px;height:40px;' class='mechselect_button_active'>\n";
				echo "				".$forcenameSelected."\n";
				echo "			</td>\n";
			}

			$mechsInSingleUnit = array();
			$c = 0;
			while ($rowUnitAssignment = $result_asc_checkunitassignments->fetch_assoc()) {

				$c++;
				$assignedMechID = $rowUnitAssignment['mechid'];
				$assignedPilotID = $rowUnitAssignment['pilotid'];

				$sql_asc_mech = "SELECT SQL_NO_CACHE * FROM asc_mech where mechid=".$assignedMechID." order by mech_tonnage desc;";
				$result_asc_mech = mysqli_query($conn, $sql_asc_mech);
				if (mysqli_num_rows($result_asc_mech) > 0) {
					while($rowMech = mysqli_fetch_assoc($result_asc_mech)) {

						$clan = "";
						if ($rowMech["tech"] == "2") {
							//$clan = "c ";
							$clan = "";
						}

						$mechnumber = $rowMech['mech_number'];
						$mechchassisname = $clan.$rowMech['as_model'];
						$mechstatusimage = $rowMech['mech_statusimageurl'];
						$mechpointvalue = $rowMech['as_pv'];
						$mechtonnage = $rowMech['mech_tonnage'];
						$activebid = $rowMech['active_bid'];

						$pointvaluetotal = $pointvaluetotal + intval($mechpointvalue);
						$tonnagetotal = $tonnagetotal + intval($mechtonnage);

						if ($activebid == "1") {
							$pointvaluetotalactivebid = $pointvaluetotalactivebid + intval($mechpointvalue);
							$tonnagetotalactivebid = $tonnagetotalactivebid + intval($mechtonnage);
						}
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

				$numStr = $mechnumber;
				if ($mechnumber == null || $mechnumber == "") {
					$numStr = "-";
				}

				if ($activebid == "1") {
					// active in current bid
					$bidcolor = "#444444;";
				} else {
					// given away in bidding
					$bidcolor = "#741300;";
				}

				$mechDetailString = "";

				$mechDetailString = $mechDetailString."						<td nowrap width='1%'  onclick='location.href=\"\"' style='background-color:#121212;text-align:right;'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
				if (!$hideMinusButtons) {
					$mechDetailString = $mechDetailString."								\n";
				} else {
					if ($activebid == "1") {
						$mechDetailString = $mechDetailString."								<span><a href='./gui_select_unit.php?activebid=0&mechid=".$assignedMechID."'>&nbsp;<i class='fa fa-arrow-circle-left' aria-hidden='true' style='font-size:26;color:#741300;'></i></a>&nbsp;</span>\n";
					} else {
						$mechDetailString = $mechDetailString."								<span><a href='./gui_select_unit.php?activebid=1&mechid=".$assignedMechID."'>&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true' style='font-size:26;color:#2f7c2f;'></i></a>&nbsp;</span>\n";
					}
				}
				$mechDetailString = $mechDetailString."							</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";

				$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='background-color:".$bidcolor."' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$mechstatusimage."' height='30px'><br><span style='font-size:12px;'>".$numStr."</span></div></td>\n";
				$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='width:100%;background-color:".$bidcolor."' class='mechselect_button_active'>\n";
				$mechDetailString = $mechDetailString."				<table width='100%' cellspacing=0 cellpadding=0 border=0px>\n";
				$mechDetailString = $mechDetailString."					<tr>\n";

				$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><a href=gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."> <span style='font-size:30px;'><!--".$pilotrank." -->".$pilotname."</span> <span style='font-weight:bold;font-size:24px;color:#da8e25;'> (".$mechpointvalue.")</span></a></span>\n";
				$mechDetailString = $mechDetailString."							<br><span style='font-size:16px;'>".$mechchassisname."</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";

				$mechDetailString = $mechDetailString."						<td nowrap width='1%' style='background-color:".$bidcolor."text-align:right;'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
				
				if ($hideMinusButtons) {
					$mechDetailString = $mechDetailString."								&nbsp;\n";
				} else {
					$mechDetailString = $mechDetailString."								<a href='./gui_select_unit.php?dm=1&mechid=".$assignedMechID."&pilotid=".$assignedPilotID."'><i class='fa fa-fw fa-minus-square'></i></a>\n";
				}
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
	if (!$hideMinusButtons) {
		echo "		<tr>\n";
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
	}
	echo "		<tr>\n";

	foreach ($mechsInAllUnits as &$mechsInSingleUnit) {
		echo "			<td style='width:170px;background-color:#333333;' valign='top'>\n";
		echo "				<table cellspacing=2 cellpadding=0 border=0px style='border-collapse: collapse;'>\n";
		foreach ($mechsInSingleUnit as &$mech) {
			echo "					<tr>\n";
			echo "						".$mech."\n";
			echo "					</tr>\n";
		}
		echo "				</table>\n";
		echo "			</td>\n";
	}
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td colspan='3' style='background-color:#333333;' align='center' valign='top'>";
	echo "				<span style='font-size:20;color:#eeeeee;'>Bid:&nbsp;</span><span style='font-size:20;color:#da8e25;'>PV: ".$pointvaluetotalactivebid."</span><span style='font-size:20;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:20;color:#ff33ee;'>".$tonnagetotalactivebid." t</span>";
	echo "				<span style='font-size:20;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
	echo "				<span style='font-size:20;color:#eeeeee;'>Total:&nbsp;PV ".$pointvaluetotal."&nbsp;/&nbsp;".$tonnagetotal." t</span>";
	echo "			</td>\n";
	echo "		</tr>\n";
?>

	</table>
</body>

</html>
