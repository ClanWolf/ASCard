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
		//die("Check position 6");
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$isAdmin = $_SESSION['isAdmin'];

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	function textTruncate($text, $chars=25) {
		if (strpos($text, " | ") !== false) {
			$parts = explode(" | ", $text);
			$text = $parts[1];
		}

		if (strlen($text) <= $chars) {
			return $text;
		}
		$text = $text." ";
        $textb = mb_convert_encoding($text, 'UTF-8', mb_list_encodings());
		$textc = html_entity_decode($textb, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = mb_substr($textc,0,$chars,'ASCII');
		$text = $text."...";

		return $text;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Formations</title>
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

	<meta http-equiv="refresh" content="5" />

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
				<td nowrap onclick="location.href='./gui_edit_game.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_select_unit.php'>ROSTER</a></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth." class='menu_button_active'><a href='./gui_select_formation.php'>CHALLENGE</a></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_unit.php'>CREATE</a></td><td style='width:5px;'>&nbsp;</td>\n";
		//echo "				<td nowrap onclick=\"location.href='./gui_edit_game.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_edit_game.php'>GAME</a></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_create_player.php'>PLAYER</a></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_admin.php'>ADMIN</a></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>
				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
			<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<table align="center" width="90%" cellspacing=2 cellpadding=2 border=0px>
<?php
	if (!($stmt = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player where bid_pv is not null and bid_pv>0 and opfor=1 and gameid=".$gid." ORDER BY bid_pv asc;"))) {
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
					echo "	<td nowrap style='color:#eee;font-size:22;text-align:right;'>\n";
					//echo "		<a href='./gui_play_batchall_sound.php'><i class='fa-solid fa-circle-play'></i>&nbsp;&nbsp;&nbsp;</a>\n";
					echo "		OPFOR&nbsp;&nbsp;&nbsp;\n";
					echo "	</td>\n";
				} else {
					echo "	<td style='color:#eee;font-size:22;'>&nbsp;&nbsp;&nbsp;</td>\n";
				}
				echo "	<td nowrap style='background-color:#812c2c;width:170px;height:40px;' class='unitselect_button_active'>".$playername."&nbsp;(R".$currRound.")</td>\n";

				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='unitselect_button_active'>jkjj</td>\n";
				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='unitselect_button_active'>jkjj</td>\n";
				//echo "	<td nowrap style='background-color:#148dee;width:170px;height:40px;' class='unitselect_button_active'>jkjj</td>\n";

				// Select units for this player
				if (!($stmtFormations = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_formation where playerid = ".$playerid." ORDER BY formationid;"))) {
					echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
				}
				if ($stmtFormations->execute()) {
					$resFormations = $stmtFormations->get_result();
					while ($rowFormation = $resFormations->fetch_assoc()) {
						$formationidSelected = $rowFormation['formationid'];
						$factionidSelected = $rowFormation['factionid'];
						$formationnameSelected = $rowFormation['formationshort'];

						// Select faction logo
						if (!($stmtFactionLogo = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_faction where factionid = ".$factionidSelected." ORDER BY factionid;"))) {
							echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
						}
						if ($stmtFactionLogo->execute()) {
							$resFactionLogo = $stmtFactionLogo->get_result();
							while ($rowFactionLogo = $resFactionLogo->fetch_assoc()) {
								$factionlogo = $rowFactionLogo['factionimage'];
							}
						}

						$sql_asc_checkformationassignments = "SELECT SQL_NO_CACHE * FROM asc_assign a, asc_unitstatus us where a.formationid=".$formationidSelected." and a.unitid=us.unitid and us.round=".$CURRENTROUND." and us.active_bid=1;";
						$result_asc_checkformationassignments = mysqli_query($conn, $sql_asc_checkformationassignments);
						if (mysqli_num_rows($result_asc_checkformationassignments) > 0) {
							echo "	<td nowrap style='background-color:#b43c3e;width:170px;height:40px;' onclick='location.href=\"gui_play_unit.php?formationid=".$formationidSelected."\"' class='unitselect_button_normal'>\n";
							echo "		<table cellspacing='0' cellpadding='0'>\n";
							echo "			<tr>\n";
							echo "				<td width='90%' style='text-align:left;'>\n";
							echo "					<a href='gui_play_unit.php?formationid=".$formationidSelected."'>&nbsp;&nbsp;&nbsp;".$formationnameSelected."</a>\n";
							echo "				</td>\n";
							echo "				<td width='10%' style='text-align:right;'>\n";
							echo "					<img src='./images/factions/".$factionlogo."' width='20px' style='border:1px solid;'>&nbsp;&nbsp;&nbsp;\n";
							echo "				</td>\n";
							echo "			</tr>\n";
							echo "		</table>\n";
							echo "	</td>\n";
						} else {
							echo "	<td nowrap style='background-color:#973232;width:170px;height:40px;' class='formationselect_button_active'>\n";
							echo "		<table cellspacing='0' cellpadding='0'>\n";
							echo "			<tr>\n";
							echo "				<td width='90%' style='text-align:center;'>\n";
							echo "					".$formationnameSelected."\n";
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
					echo "	<td nowrap style='color:#eee;font-size:22;text-align:left;'>\n";
					echo "		&nbsp;&nbsp;&nbsp;OPFOR\n";
					//echo "		<a href='./gui_play_batchall_sound.php'>&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-play'></a></i>\n";
					echo "	</td>\n";
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
			//echo "<tr><td colspan='8' align='right' nowrap style='font-size:18px;color:#eee;'>&nbsp;</td></tr>\n";
		}
		if ($jj > 0) {
			echo "<tr><td colspan='8' style='color:#eee;font-size:20;text-align:center;'><div style='padding-top:10px;padding-bottom:10px;'>VS.</div></td></tr>\n";
		}
	}

	if (!($stmt2 = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player where bid_pv is not null and bid_pv > 0 and opfor = 0 and gameid = ".$gid." ORDER BY bid_pv, bid_tonnage asc limit 4;"))) {
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
					echo "<td style='color:eee;font-size:24;color:#ffaa00;text-align:right;'><img src='./images/indicator.png' height='24px'></td>\n";
				} else {
					$selectBorder='';
					echo "<tr>\n";
					echo "<td></td>\n";
				}
				echo "<td nowrap style='height:40px;padding-left:20px;padding-right:20px;$selectBorder' class='unitselect_button_active'>".$playername."&nbsp;(R".$currRound.")</td>\n";

				// Select units for this player
				if (!($stmtFormations = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_formation where playerid = ".$playerid." ORDER BY formationid;"))) {
					echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
				}
				if ($stmtFormations->execute()) {
					$resFormations = $stmtFormations->get_result();
					while ($rowFormation = $resFormations->fetch_assoc()) {
						$formationidSelected = $rowFormation['formationid'];
						$factionidSelected = $rowFormation['factionid'];
						$formationnameSelected = $rowFormation['formationname'];

						// Select faction logo
						if (!($stmtFactionLogo = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_faction where factionid = ".$factionidSelected." ORDER BY factionid;"))) {
							echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
						}
						if ($stmtFactionLogo->execute()) {
							$resFactionLogo = $stmtFactionLogo->get_result();
							while ($rowFactionLogo = $resFactionLogo->fetch_assoc()) {
								$factionlogo = $rowFactionLogo['factionimage'];
							}
						}

						//$sql_asc_checkformationassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where formationid=".$formationidSelected.";";
						$sql_asc_checkformationassignments = "SELECT SQL_NO_CACHE * FROM asc_assign a, asc_unitstatus us where a.formationid=".$formationidSelected." and a.unitid=us.unitid and us.round=".$CURRENTROUND." and us.active_bid=1;";
						$result_asc_checkformationassignments = mysqli_query($conn, $sql_asc_checkformationassignments);
						if (mysqli_num_rows($result_asc_checkformationassignments) > 0) {
							echo "<td nowrap style='width:170px;height:40px;$selectBorder' onclick='location.href=\"gui_play_unit.php?formationid=".$formationidSelected."\"' class='formationselect_button_normal'>\n";
							echo "	<table cellspacing='0' cellpadding='0'>\n";
							echo "		<tr>\n";
							echo "			<td width='90%' style='text-align:left;'>\n";
							echo "				<a href='gui_play_unit.php?formationid=".$formationidSelected."'>&nbsp;&nbsp;&nbsp;".$formationnameSelected."</a>\n";
							echo "			</td>\n";
							echo "			<td width='10%' style='text-align:right;'>\n";
							echo "				<img src='./images/factions/".$factionlogo."' width='20px' style='border:1px solid;'>&nbsp;&nbsp;&nbsp;\n";
							echo "			</td>\n";
							echo "		</tr>\n";
							echo "	</table>\n";
							echo "</td>\n";
						} else {
							echo "<td nowrap style='background-color:#444444;width:170px;height:40px;$selectBorder' class='formationselect_button_active'>\n";
							echo "	<table cellspacing='0' cellpadding='0'>\n";
							echo "		<tr>\n";
							echo "			<td width='90%' style='text-align:center;'>\n";
							echo "				".$formationnameSelected."\n";
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
					echo "<td style='color:eee;font-size:24;color:#ffaa00;text-align:left;'><img src='./images/indicatorl.png' height='24px'></td>\n";
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
	</table>

	<p align="center" class="footerInfo">Change bid in roster. OpFor and lowest 4 bidders (PV) in this Game show up here.</p>

</body>

</html>
