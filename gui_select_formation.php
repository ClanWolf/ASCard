<?php
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

	// Get data on units from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Enemies</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75, user-scalable=no" />

	<meta http-equiv="refresh" content="5" />

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
	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});
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
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="width: 100px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<!--
				<td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background: rgba(56,87,26,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				-->
				<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_formation.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_active'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></div></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_unit.php'>ADD</a><br><span style='font-size:16px;'>Create a unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td style="width: 100px;" nowrap width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<table align="center" cellspacing=2 cellpadding=2 border=0px>

<?php
	if (!($stmt = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player where bid_pv is not null and bid_pv > 0 and opfor = 1 and gameid = ".$gid." ORDER BY bid_pv asc;"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if ($stmt->execute()) {
		$res = $stmt->get_result();
		$jj = 0;
		$pv_total_opfor = 0;
		$tonnage_total_opfor = 0;
		while ($row = $res->fetch_assoc()) {
			if ($row['opfor'] == 1) {
				$playerid = $row['playerid'];
				$playername = $row['name'];
				$pv_bidden = $row['bid_pv'];
				$tonnage_bidden = $row['bid_tonnage'];
				$currRound = $row['round'];
				$jj++;

				echo "<tr>\n";
				if ($jj == 1) {
					echo "	<td style='color:#eee;font-size:22;'>OPFOR&nbsp;&nbsp;&nbsp;</td>\n";
				} else {
					echo "	<td style='color:#eee;font-size:22;'>&nbsp;&nbsp;&nbsp;</td>\n";
				}
				echo "	<td nowrap style='background-color:#812c2c;width:170px;height:40px;' class='mechselect_button_active'>".$playername."&nbsp;(R".$currRound.")</td>\n";

				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='mechselect_button_active'>jkjj</td>\n";
				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='mechselect_button_active'>jkjj</td>\n";
				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='mechselect_button_active'>jkjj</td>\n";

				// Select units for this player
				if (!($stmtUnits = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_unit where playerid = ".$playerid." ORDER BY unitid;"))) {
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

						$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
						$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
						if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
							echo "	<td nowrap style='background-color:#b43c3e;width:170px;height:40px;' onclick='location.href=\"gui_play_unit.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
							echo "		<table cellspacing='0' cellpadding='0'>\n";
							echo "			<tr>\n";
							echo "				<td width='90%' style='text-align:left;'>\n";
							echo "					<a href='gui_play_unit.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
							echo "				</td>\n";
							echo "				<td width='10%' style='text-align:right;'>\n";
							echo "					<img src='./images/factions/".$unitlogo."' width='20px' style='border:1px solid;'>\n";
							echo "				</td>\n";
							echo "			</tr>\n";
							echo "		</table>\n";
							echo "	</td>\n";
						} else {
							echo "	<td nowrap style='background-color:#973232;width:170px;height:40px;' class='mechselect_button_active'>\n";
							echo "		<table cellspacing='0' cellpadding='0'>\n";
							echo "			<tr>\n";
							echo "				<td width='90%' style='text-align:left;'>\n";
							echo "					".$forcenameSelected."\n";
							echo "				</td>\n";
							echo "				<td width='10%' style='text-align:right;'>\n";
							echo "					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
							echo "				</td>\n";
							echo "			</tr>\n";
							echo "		</table>\n";
							echo "	</td>\n";
						}
					}
				}
				echo "	<td nowrap style='font-size:24px;text-align:right;color:#dddddd;background-color:#b33939;height:40px;padding-left:10px;padding-right:10px'>PV ".$pv_bidden."</td><td nowrap style='text-align:right;color:#ffff00;background-color:#b33939;height:40px;padding-left:10px;padding-right:10px'>".$tonnage_bidden." t</td>\n";

				$pv_total_opfor = $pv_total_opfor + $pv_bidden;
				$tonnage_total_opfor = $tonnage_total_opfor + $tonnage_bidden;

				if ($jj == 1) {
					echo "	<td style='color:#eee;font-size:22;'>&nbsp;&nbsp;&nbsp;OPFOR</td>\n";
				} else {
					echo "	<td style='color:#eee;font-size:22;'>&nbsp;&nbsp;&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
		}
		if ($jj > 1) {
			echo "<tr>\n";
			echo "<td colspan='5' align='right' nowrap style='font-size:18px;color:#eee;'>&nbsp;</td>\n";
			echo "<td colspan='1' align='center' nowrap style='font-size:18px;color:#dddddd;'>PV ".$pv_total_opfor."</td>\n";
			echo "<td colspan='1' align='center' nowrap style='font-size:18px;color:#ffff00;'>".$tonnage_total_opfor." t</td>\n";
			echo "</tr>\n";
		} else {
			echo "<td colspan='7' align='right' nowrap style='font-size:18px;color:#eee;'>&nbsp;</td>\n";
		}
	}

	if (!($stmt2 = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player where bid_pv is not null and bid_pv > 0 and opfor = 0 and gameid = ".$gid." ORDER BY bid_pv, bid_tonnage asc limit 5;"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if ($stmt2->execute()) {
		$res = $stmt2->get_result();
		$jj = 0;
		$pv_total_blufor = 0;
		$tonnage_total_blufor = 0;

		while ($row = $res->fetch_assoc()) {
			if ($row['opfor'] == 0) {
				$playerid = $row['playerid'];
				$playername = $row['name'];
				$pv_bidden = $row['bid_pv'];
				$tonnage_bidden = $row['bid_tonnage'];
				$currRound = $row['round'];
				$jj++;

				$selectBorder='';
				if ($pid == $playerid) {
					$selectBorder='border-top:3px solid yellow;border-bottom:3px solid yellow;';
					echo "<tr>\n";
					echo "<td style='color:eee;font-size:24;color:#ffaa00;text-align:center;$selectBorder'><img src='./images/indicator.png' height='24px'></td>\n";
				} else {
					$selectBorder='';
					echo "<tr>\n";
					echo "<td></td>\n";
				}
				echo "<td nowrap style='height:40px;padding-left:20px;padding-right:20px;$selectBorder' class='mechselect_button_active'>".$playername."&nbsp;(R".$currRound.")</td>\n";

				// Select units for this player
				if (!($stmtUnits = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_unit where playerid = ".$playerid." ORDER BY unitid;"))) {
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

						$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
						$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
						if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
							echo "<td nowrap style='width:170px;height:40px;$selectBorder' onclick='location.href=\"gui_play_unit.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
							echo "	<table cellspacing='0' cellpadding='0'>\n";
							echo "		<tr>\n";
							echo "			<td width='90%' style='text-align:left;'>\n";
							echo "				<a href='gui_play_unit.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
							echo "			</td>\n";
							echo "			<td width='10%' style='text-align:right;'>\n";
							echo "				<img src='./images/factions/".$unitlogo."' width='20px' style='border:1px solid;'>\n";
							echo "			</td>\n";
							echo "		</tr>\n";
							echo "	</table>\n";
							echo "</td>\n";
						} else {
							echo "<td nowrap style='background-color:#444444;width:170px;height:40px;$selectBorder' class='mechselect_button_active'>\n";
							echo "	<table cellspacing='0' cellpadding='0'>\n";
							echo "		<tr>\n";
							echo "			<td width='90%' style='text-align:left;'>\n";
							echo "				".$forcenameSelected."\n";
							echo "			</td>\n";
							echo "			<td width='10%' style='text-align:right;'>\n";
							echo "				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
							echo "			</td>\n";
							echo "		</tr>\n";
							echo "	</table>\n";
							echo "</td>\n";
						}
					}
				}

				$pv_total_blufor = $pv_total_blufor + $pv_bidden;
				$tonnage_total_blufor = $tonnage_total_blufor + $tonnage_bidden;

				echo "<td nowrap style='font-size:24px;text-align:right;color:#ddd;background-color:#666666;height:40px;padding-left:10px;padding-right:10px;$selectBorder'>PV ".$pv_bidden."</td><td nowrap style='font-size:24px;text-align:right;color:#00ff00;background-color:#666666;height:40px;padding-left:10px;padding-right:10px;$selectBorder'>".$tonnage_bidden." t</td>\n";
				if ($pid == $playerid) {
					echo "<td style='color:eee;font-size:24;color:#ffaa00;text-align:center;$selectBorder'><img src='./images/indicatorl.png' height='24px'></td>\n";
				} else {
					echo "<td></td>\n";
				}
				echo "</tr>\n";
			}
		}
		if ($jj > 1) {
			echo "<tr>\n";
			echo "<td colspan='5' align='right' nowrap style='font-size:18px;color:#eee;'>&nbsp;</td>\n";
			echo "<td colspan='1' align='center' nowrap style='font-size:18px;color:#dddddd;'>PV ".$pv_total_blufor."</td>\n";
			echo "<td colspan='1' align='center' nowrap style='font-size:18px;color:#00ff00;'>".$tonnage_total_blufor." t</td>\n";
			echo "</tr>\n";
		} else {
			echo "<td colspan='7' align='right' nowrap style='font-size:18px;color:#eee;'>&nbsp;</td>\n";
		}
	}
?>
		<tr><td colspan="8" style="color:#eee;font-size:20;text-align:center;"><br>Use the Roster view to add or remove units from your bid.<br>Only the 5 lowest bidders in PointValue (PV) with the same Game-ID will be visible.<br><br></td></tr>
	</table>
</body>

</html>
