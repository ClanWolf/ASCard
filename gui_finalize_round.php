<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 3");
	}

	// Get data on units from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pname = $_SESSION['name'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

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

		$overallpv = -1;
		$overalltonnage = -1;
		$sqlselectoverallpv = "";
		$sqlselectoverallpv = $sqlselectoverallpv . "SELECT asc_mech.mech_tonnage, asc_mech.as_pv from asc_assign, asc_mech, asc_unit ";
		$sqlselectoverallpv = $sqlselectoverallpv . "WHERE asc_assign.unitid = asc_unit.unitid ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_assign.mechid = asc_mech.mechid ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_mech.active_bid = 1 ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_unit.playerid = ".$pid.";";
		if (mysqli_query($conn, $sqlselectoverallpv)) {
			// Success
			$result_sqlselectoverallpv = mysqli_query($conn, $sqlselectoverallpv);
			if (mysqli_num_rows($result_sqlselectoverallpv) > 0) {
				$overallpv = 0;
				$overalltonnage = 0;
				while($row = mysqli_fetch_assoc($result_sqlselectoverallpv)) {
					$TONNAGE = $row["mech_tonnage"];
					$POINTVALUE = $row["as_pv"];
					$overallpv = $overallpv + $POINTVALUE;
					$overalltonnage = $overalltonnage + $TONNAGE;
				}
			}
		} else {
			// Error
			echo "Error: " . $sqlselectoverallpv . "<br>" . mysqli_error($conn);
		}

		$sqlstoreoverallpv = "UPDATE asc_player set bid_pv=".$overallpv.", bid_tonnage=".$overalltonnage." WHERE playerid = " . $pid . ";";
		if (mysqli_query($conn, $sqlstoreoverallpv)) {
			// Success
			//echo "Error: " . $sqlstoreoverallpv . "<br>";
		} else {
			// Error
			echo "Error: " . $sqlstoreoverallpv . "<br>" . mysqli_error($conn);
		}

		// reset winner flag
		$sqlresetwinner = "UPDATE asc_player set bid_winner=0;";
		if (mysqli_query($conn, $sqlresetwinner)) {
			// Success
			//echo "Error: " . $sqlresetwinner . "<br>";
		} else {
			// Error
			echo "Error: " . $sqlresetwinner . "<br>" . mysqli_error($conn);
		}

		// find winner
		$sqlfindwinner = "SELECT * FROM asc_player where opfor = 0 and bid_pv != -1 order by bid_tonnage, bid_pv limit 1;";
		if (mysqli_query($conn, $sqlfindwinner)) {
			// Success
			$result_sqlsqlfindwinner = mysqli_query($conn, $sqlfindwinner);
			if (mysqli_num_rows($result_sqlsqlfindwinner) > 0) {
				$winneruserid = 0;
				while($row = mysqli_fetch_assoc($result_sqlsqlfindwinner)) {
					$winnerplayerid = $row["playerid"];
				}
			}
		} else {
			// Error
			echo "Error: " . $sqlfindwinner . "<br>" . mysqli_error($conn);
		}

		// set winner flag for lowest bid
		$sqlsetwinner = "UPDATE asc_player set bid_winner=1 WHERE playerid = " . $winnerplayerid . ";";
		if (mysqli_query($conn, $sqlsetwinner)) {
			// Success
			//echo "Error: " . $sqlsetwinner . "<br>";
		} else {
			// Error
			echo "Error: " . $sqlsetwinner . "<br>" . mysqli_error($conn);
		}

		//echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Finalize</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75, user-scalable=no" />

	<link rel="manifest" href="./manifest.json">
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
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

	<script type="text/javascript" src="./scripts/jquery-3.6.1.min.js"></script>
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
	<iframe name="saveframe" src="./save_finalize_round.php"></iframe>

	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});

		function finalizeRound(playerId) {
			var url="./save_finalize_round.php?pid=" + playerId;
			window.frames["saveframe"].location.replace(url);
		}
		function resetRound(playerId) {
			var url="./save_reset_round.php?pid=" + playerId;
			window.frames["saveframe"].location.replace(url);
		}
	</script>

	<div id="cover"></div>

<?php
	if ($playMode) {
		$buttonWidth = "34%";
	} else {
		$buttonWidth = "17%";
	}
?>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="100px" style="width: 100px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color:#eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<!--
				<td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background:rgba(81,125,37,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color:#fff;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				-->
				<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width: 100px;background:rgba(81,125,37,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#fff;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>All bidding units</span></div></td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_mech.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_mech.php'>ADD</a><br><span style='font-size:16px;'>Create a Mech/BA</span></div></td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>\n";
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width: 100px;" nowrap width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<br>

	<table align="center" cellspacing="2" cellpadding="2" border="0px">
		<tr>
			<td nowrap colspan='3'>
				<table cellspacing="2" cellpadding="2">

				<?php
					if (!$playMode) {
						echo "<tr>\n";
						echo "	<td nowrap width='98%' style='background-color:#517D25;width:810px;height:40px;' class='mechselect_button_active' onclick='javascript:finalizeRound(".$pid.");'>\n";
						echo "		&nbsp;&nbsp;&nbsp;<i class='fas fa-redo'></i>&nbsp;&nbsp;&nbsp;Finalize round ".$CURRENTROUND." of game ".$gid."\n";
						echo "	</td>\n";
						echo "	<td nowrap width='1%' style='background-color:#da8e25;height:40px;' class='mechselect_button_active' onclick='javascript:editGame(".$pid.");'>\n";
						echo "		&nbsp;&nbsp;&nbsp;Edit Game&nbsp;&nbsp;&nbsp;\n";
						echo "	</td>\n";
						echo "	<td nowrap width='1%' style='background-color:#da8e25;height:40px;' class='mechselect_button_active' onclick='javascript:resetRound(".$pid.");'>\n";
						echo "		&nbsp;&nbsp;&nbsp;RESET Round&nbsp;&nbsp;&nbsp;\n";
						echo "	</td>\n";
						echo "</tr>\n";
					} else {
						echo "<tr>\n";
						echo "	<td nowrap width='100%' style='background-color:#517D25;width:810px;height:40px;' class='mechselect_button_active' onclick='javascript:finalizeRound(".$pid.");'>\n";
						echo "		&nbsp;&nbsp;&nbsp;<i class='fas fa-redo'></i>&nbsp;&nbsp;&nbsp;Finalize round ".$CURRENTROUND." of game ".$gid."\n";
						echo "	</td>\n";
						echo "</tr>\n";
					}
				?>

				</table>
			</td>
		</tr>
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

			// Select faction logo
			if (!($stmtFactionLogo = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_faction where factionid = ".$factionidSelected." ORDER BY factionid;"))) {
				echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
			}
			if ($stmtFactionLogo->execute()) {
				$resFactionLogo = $stmtFactionLogo->get_result();
				while ($rowFactionLogo = $resFactionLogo->fetch_assoc()) {
					$unitlogo = $rowFactionLogo['faction_imageurl'];
				}
			}

			array_push($addMechToUnitLinkArray, "gui_create_mech.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);
			array_push($assignMechToUnitLinkArray, "gui_assign_unit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);

			$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
			$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
//			if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
//				echo "			<td nowrap style='width:270px;height:40px;' onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
//				echo "				<table style='width:100%;' cellspacing=0 cellpadding=0>\n";
//				echo "					<tr>\n";
//				echo "						<td style='text-align:center;'>\n";
//				echo "							<a href='gui_play_mech.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
//				echo "						</td>\n";
//				echo "						<td style='text-align:right;'>\n";
//				echo "							<img src='./images/factions/".$unitlogo."' width='20px' style='border:1px solid;'>\n";
//				echo "						</td>\n";
//				echo "					</tr>\n";
//				echo "				</table>\n";
//				echo "			</td>\n";
//			} else {
//				echo "			<td nowrap style='background-color:#444444;width:270px;height:40px;' class='mechselect_button_active'>\n";
//				echo "				".$forcenameSelected."\n";
//				echo "			</td>\n";
//			}

			$mechsInSingleUnit = array();
			$c = 0;
			while ($rowUnitAssignment = $result_asc_checkunitassignments->fetch_assoc()) {

				$c++;
				$assignedMechID = $rowUnitAssignment['mechid'];
				$assignedPilotID = $rowUnitAssignment['pilotid'];

				$mechHasMoved = $rowUnitAssignment['round_moved'];
				$mechHasFired = $rowUnitAssignment['round_fired'];

				$mechStatusImage = "";
				if ($mechHasMoved == 0 && $mechHasFired == 0) {
					$mechStatusImage = "./images/top-right_phase01.png";
				}
				if ($mechHasMoved == 0 && $mechHasFired > 0) {
					$mechStatusImage = "./images/top-right_phase01.png";
				}
				if ($mechHasMoved > 0 && $mechHasFired == 0) {
					$mechStatusImage = "./images/top-right_phase02.png";
				}
				if ($mechHasMoved > 0 && $mechHasFired > 0) {
					$mechStatusImage = "./images/top-right_phase03.png";
				}

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

				$mechDetailString = $mechDetailString."						<td nowrap width='1%' valign='middle' onclick='location.href=\"\"' style='background-color:#121212;text-align:right;'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
				$mechDetailString = $mechDetailString."						        &nbsp;&nbsp;&nbsp;<img src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='28px' height='28px'>&nbsp;&nbsp;&nbsp;";
				//$mechDetailString = $mechDetailString."								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
				$mechDetailString = $mechDetailString."							</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";

				if ($activebid == "1") {
					$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='background-color:".$bidcolor."' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img src='".$mechStatusImage."' width='30px'></div></td>\n";
					$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='width:100%;background-color:".$bidcolor."' class='mechselect_button_active'>\n";
				} else {
					$mechDetailString = $mechDetailString."			<td nowrap style='background-color:".$bidcolor."' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img src='".$mechStatusImage."' width='30px'></div></td>\n";
					$mechDetailString = $mechDetailString."			<td nowrap style='width:100%;background-color:".$bidcolor."' class='mechselect_button_active'>\n";
				}
				$mechDetailString = $mechDetailString."				<table width='100%' cellspacing=0 cellpadding=0 border=0px>\n";
				$mechDetailString = $mechDetailString."					<tr>\n";

				if ($activebid == "1") {
					$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><a href=gui_play_mech.php?unit=".$unitidSelected."&chosenmech=".$c."> <span style='font-size:26px;'>";
				} else {
					$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><a href='' target='_SELF'> <span style='font-size:26px;'>";
				}
//				$mechDetailString = $mechDetailString."						<img src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='18px' height='18px'>";
				$mechDetailString = $mechDetailString."						".$pilotname."</span></a></span>\n";
				$mechDetailString = $mechDetailString."							<br><span style='font-size:16px;'>".$mechchassisname."</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";

				$mechDetailString = $mechDetailString."						<td nowrap width='1%' style='background-color:".$bidcolor."text-align:right;'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
				$mechDetailString = $mechDetailString."								&nbsp;\n";
				$mechDetailString = $mechDetailString."							</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";
				$mechDetailString = $mechDetailString."					</tr>\n";
				$mechDetailString = $mechDetailString."				</table>\n";
				$mechDetailString = $mechDetailString."			</td>\n";

				if ($mechstatusimage != "images/DD_ELE_04.png" && $mechstatusimage != "images/DD_04.png") {
					if ($activebid == "1") {
						array_push($mechsInSingleUnit, $mechDetailString);
					}
				}
			}
			array_push($mechsInAllUnits, $mechsInSingleUnit);
		}
	}
	echo "		</tr>\n";
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
?>

	<tr>
		<td valign='top' align='center' colspan='3'>
			<br><span style='font-size:24px;color:#fff;'>Round can be finalized as soon as all units have reported.<br>Disable play mode (<a href="https://www.clanwolf.net/apps/ASCard/gui_edit_option.php">Options</a>) to reset round or edit OpFor / Game-ID.</span>
		</td>
	</tr>

	</table>
</body>

</html>
