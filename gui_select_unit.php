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
		//die("Check position 3");
	}

	// Get data from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pname = $_SESSION['name'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$isAdmin = $_SESSION['isAdmin'];

	$update_logintime = "UPDATE asc_player SET last_login=now() WHERE playerid = ".$pid;
	$result_update_logintime = mysqli_query($conn, $update_logintime);

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	$deleteunit = isset($_GET["dm"]) ? $_GET["dm"] : "";
	$togglebid = isset($_GET["activebid"]) ? $_GET["activebid"] : "";

	if ($deleteunit == "1") {
		$unitid = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
		$pilotid = isset($_GET["pilotid"]) ? $_GET["pilotid"] : "";
		$formationidparam = isset($_GET["formationid"]) ? $_GET["formationid"] : "";

		// delete assignment
		// only the assignment is deleted
		// the unit and the pilot are kept in the database for later re-assignment
		// the model number probably stays the same
		//$sqldeleteassignment = "DELETE FROM asc_assign WHERE pilotid = ".$pilotid." and unitid = " . $unitid . ";";
		$sqldeleteassignment = "UPDATE asc_assign set formationid=null WHERE pilotid = ".$pilotid." and unitid = " . $unitid . ";";
		if (mysqli_query($conn, $sqldeleteassignment)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteassignment . "<br>" . mysqli_error($conn);
		}

		if ($formationidparam != "") {
			$sqlresetstartindex = "UPDATE asc_formation set startindex=1 WHERE formationid=".$formationidparam.";";
			if (mysqli_query($conn, $sqlresetstartindex)) {
				// Success
			} else {
				// Error
				echo "Error: " . $sqlresetstartindex . "<br>" . mysqli_error($conn);
			}
		}

		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php?activebid=0&unitid=".$unitid."'>";
	}

	if ($togglebid == "1" || $togglebid == "0") {
		$unitid = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
		$formationidparam = isset($_GET["formationid"]) ? $_GET["formationid"] : "";

		//var_dump($formationidparam);

		$sqltogglebid = "UPDATE asc_unitstatus set active_bid=".$togglebid." WHERE unitid=".$unitid." and round=".$CURRENTROUND." and gameid=".$gid.";";
		if (mysqli_query($conn, $sqltogglebid)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqltogglebid . "<br>" . mysqli_error($conn);
		}

		if ($formationidparam != "") {
			$sqlresetstartindex = "UPDATE asc_formation set startindex=1 WHERE formationid=".$formationidparam.";";
			if (mysqli_query($conn, $sqlresetstartindex)) {
				// Success
			} else {
				// Error
				echo "Error: " . $sqlresetstartindex . "<br>" . mysqli_error($conn);
			}
		}

		$overallpv = -1;
		$overalltonnage = -1;
		$sqlselectoverallpv = "";
		$sqlselectoverallpv = $sqlselectoverallpv . "SELECT asc_unit.unit_tonnage, asc_unit.as_pv from asc_assign, asc_unit, asc_unitstatus, asc_formation ";
		$sqlselectoverallpv = $sqlselectoverallpv . "WHERE asc_assign.formationid = asc_formation.formationid ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_assign.unitid = asc_unit.unitid ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_assign.unitid = asc_unitstatus.unitid ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_unitstatus.round = ".$CURRENTROUND." "; // runde
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_unitstatus.gameid = ".$gid." "; // gameid
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_unitstatus.active_bid = 1 ";
		$sqlselectoverallpv = $sqlselectoverallpv . "AND asc_formation.playerid = ".$pid.";";
		if (mysqli_query($conn, $sqlselectoverallpv)) {
			// Success
			$result_sqlselectoverallpv = mysqli_query($conn, $sqlselectoverallpv);
			if (mysqli_num_rows($result_sqlselectoverallpv) > 0) {
				$overallpv = 0;
				$overalltonnage = 0;
				while($row = mysqli_fetch_assoc($result_sqlselectoverallpv)) {
					$TONNAGE = $row["unit_tonnage"];
					$POINTVALUE = $row["as_pv"];
					$overallpv = $overallpv + $POINTVALUE;
					$overalltonnage = $overalltonnage + $TONNAGE;
				}
			}
		} else {
			// Error
			echo "Error: " . $sqlselectoverallpv . "<br>" . mysqli_error($conn);
		}

		if ($overallpv == -1) {
			$sqlstoreoverallpv = "UPDATE asc_player set bid_pv=".$overallpv.", bid_tonnage=".$overalltonnage.", active_ingame=0 WHERE playerid = " . $pid . ";";
		} else {
			$sqlstoreoverallpv = "UPDATE asc_player set bid_pv=".$overallpv.", bid_tonnage=".$overalltonnage.", active_ingame=1 WHERE playerid = " . $pid . ";";
		}
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

		if (isset($winnerplayerid)) {
			// set winner flag for lowest bid
			$sqlsetwinner = "UPDATE asc_player set bid_winner=1 WHERE playerid = " . $winnerplayerid . ";";
			if (mysqli_query($conn, $sqlsetwinner)) {
				// Success
				//echo "Error: " . $sqlsetwinner . "<br>";
			} else {
				// Error
				echo "Error: " . $sqlsetwinner . "<br>" . mysqli_error($conn);
			}
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
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Roster</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

	<link rel="manifest" href="./manifest.json">
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/jquery.jscrollpane.css">
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
	<script type="text/javascript" src="./scripts/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.mousewheel.js"></script>
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
		.scroll-pane {
			width: 100%;
			height: 280px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 280px;
		}
	</style>
</head>

<body>
	<iframe name="saveframe" id="iframe_save"></iframe>

	<div id="cover"></div>

	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});
		$(function() {
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			$('.scroll-pane').jScrollPane();
        });
		function finalizeRound(playerId) {
			var url="./save_game_finalizeround.php?pid=" + playerId;
			//window.frames["saveframe"].location.replace(url);
			window.location.href = url;
		}
	</script>

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
				<td nowrap onclick="location.href='./gui_select_unit.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_active'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_unit.php'>ADD</a><br><span style='font-size:16px;'>Create a unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_game.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_game.php'>GAME</a><br><span style='font-size:16px;'>Game settings</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		if ($isAdmin) {
			echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
			echo "				<td nowrap onclick=\"location.href='./gui_admin.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_admin.php'>ADMIN</a><br><span style='font-size:16px;'>Administration</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		}
	}
?>
				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<table align="center" width="90%" cellspacing=2 cellpadding=2 border=0px>
		<tr>
<?php
if (!$playMode) {
	echo "						<td colspan='3' nowrap style='height:30px;text-align:center;padding:0px;' class='formationselect_button_normal'>\n";
	echo "							<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0'>\n";
	echo "								<td colspan='1' nowrap style='width:60px;height:30px;text-align:left;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "									<a href=''>&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-arrow-left'></i></a>\n";
	echo "								</td>\n";
	echo "									<td colspan='1' nowrap style='height:30px;text-align:center;' onclick='location.href=\"gui_edit_command.php\"' class='formationselect_button_normal'>\n";
	echo "									<a href='gui_edit_command.php'><i class='fas fa-edit'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMMAND</a>\n";
	echo "								</td>\n";
	echo "								<td colspan='1' nowrap style='width:60px;height:30px;text-align:right;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "									<a href=''><i class='fa-solid fa-arrow-right'></i>&nbsp;&nbsp;&nbsp;</a>\n";
	echo "								</td>\n";
	echo "							</table>\n";
	echo "						</td>\n";
} else {
	echo "						<td colspan='3' nowrap style='height:30px;text-align:center;padding:0px;' class='formationselect_button_normal'>\n";
	echo "							<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0'>\n";
	echo "								<td colspan='1' nowrap style='width:60px;height:30px;text-align:left;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "									<a href=''>&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-arrow-left'></i></a>\n";
	echo "								</td>\n";
	echo "									<td colspan='1' nowrap style='height:30px;text-align:center;' onclick='location.href=\"gui_select_command.php\"' class='formationselect_button_normal'>\n";
	echo "									<a href='gui_select_command.php'>COMMAND</a>\n";
	echo "									&nbsp;&nbsp;&nbsp;<span id='bidOverviewCommand'>(PV 10 / 100)</span>\n";
	echo "								</td>\n";
	echo "								<td colspan='1' nowrap style='width:60px;height:30px;text-align:right;' onclick='location.href=\"\"' class='formationselect_button_normal'>\n";
	echo "									<a href=''><i class='fa-solid fa-arrow-right'></i>&nbsp;&nbsp;&nbsp;</a>\n";
	echo "								</td>\n";
	echo "							</table>\n";
	echo "						</td>\n";
}
if ($playMode) {
	// FINALIZE ROUND
	echo "  		<td nowrap onclick='javascript:finalizeRound(".$pid.");' id='FinalizeRoundButton' style='text-align:center;width:100px;background:rgba(81,125,37,1.0);' rowspan='5'><div style='color:#eee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-redo'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>\n";
}
?>
		</tr>
		<tr>
<?php
	$addUnitToFormationLinkArray = array();
	$assignUnitToFormationLinkArray = array();
	$unitsInAllFormations = array();
	$pointvaluetotal = 0;
	$pointvaluetotalactivebid = 0;
	$tonnagetotal = 0;
	$tonnagetotalactivebid = 0;

	$readyToFinalizeRound = 1;

	// Select formations for this player
	if (!($stmtFormations = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_formation where playerid = ".$pid." ORDER BY formationid;"))) {
		echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
	}
	if ($stmtFormations->execute()) {
		$resFormations = $stmtFormations->get_result();

		$formationind = 0;
		while ($rowFormation = $resFormations->fetch_assoc()) {
			$formationidSelected = $rowFormation['formationid'];
			$factionidSelected = $rowFormation['factionid'];
			$formationnameSelected = $rowFormation['formationname'];

			$tonnageformation[$formationind] = 0;
			$pvformation[$formationind] = 0;
			$tonnageformationbid[$formationind] = 0;
			$pvformationbid[$formationind] = 0;

			// Select faction logo
			if (!($stmtFactionLogo = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_faction WHERE factionid = ".$factionidSelected." ORDER BY factionid;"))) {
				echo "Prepare failed: (" . $conn->errno . ")" . $conn->error;
			}
			if ($stmtFactionLogo->execute()) {
				$resFactionLogo = $stmtFactionLogo->get_result();
				while ($rowFactionLogo = $resFactionLogo->fetch_assoc()) {
					$factionlogo = $rowFactionLogo['factionimage'];
				}
			}

			array_push($addUnitToFormationLinkArray, "gui_create_unit.php?formationid=".$formationidSelected."&formationname=".$formationnameSelected);
			array_push($assignUnitToFormationLinkArray, "gui_assign_unit.php?formationid=".$formationidSelected."&formationname=".$formationnameSelected);

			// This select exists 3 times!
			$sql_asc_checkformationassignments = "SELECT "
				."SQL_NO_CACHE "
				."asc_assign.unitid, "
				."asc_assign.pilotid, "
				."asc_assign.round_moved, "
				."asc_assign.round_fired, "
				."asc_unit.unitid, "
				."asc_unit.as_tp, "
				."asc_unit.commander, "
				."asc_unit.subcommander, "
				."asc_unit.unit_tonnage, "
				."asc_unitsortorder.sortorder, "
				."asc_unitstatus.active_bid "
				."FROM "
				."asc_assign, "
				."asc_unit, "
				."asc_unitsortorder, "
				."asc_unitstatus "
				."WHERE asc_assign.formationid=".$formationidSelected." "
				."AND asc_unitsortorder.unittype=asc_unit.as_tp "
				."AND asc_unit.unitid=asc_assign.unitid "
				."AND asc_unit.unitid=asc_unitstatus.unitid "
				."AND asc_unitstatus.round=".$CURRENTROUND." "
				."AND asc_unitstatus.gameid=".$gid." "
				."ORDER BY "
				."  asc_unitstatus.active_bid DESC, "
				."  asc_unit.commander DESC, "
				."  asc_unit.subcommander DESC, "
				."  asc_unitsortorder.sortorder ASC, "
				."  asc_unit.unit_tonnage DESC, "
				."  asc_unit.unitid ASC;";
			$result_asc_checkformationassignments = mysqli_query($conn, $sql_asc_checkformationassignments);

			$formationsFound = 0;
			$activeUnitsFound = 0;
			foreach($result_asc_checkformationassignments as $rowCheckFormationAssignments) {
			// while ($rowCheckFormationAssignments = $result_asc_checkformationassignments->fetch_assoc()) {
				$formationsFound = $formationsFound + 1;
				$cUnitId = $rowCheckFormationAssignments['unitid'];
				$sql_checkactiveunits = "SELECT SQL_NO_CACHE * FROM asc_unitstatus where unitid=".$cUnitId." AND gameid=".$gid." AND round=".$CURRENTROUND;
				$result_checkactiveunits = mysqli_query($conn, $sql_checkactiveunits);
				while ($row_checkactiveunits = $result_checkactiveunits->fetch_assoc()) {
					$uIsActiveBid = $row_checkactiveunits['active_bid'];
					if ($uIsActiveBid == 1) {
						$activeUnitsFound = $activeUnitsFound + 1;
					}
				}
			}

			if ($formationsFound > 0 && $activeUnitsFound > 0) {
				echo "			<td nowrap style='width:270px;height:30px;' onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$formationidSelected."\"' class='formationselect_button_normal'>\n";
				echo "				<table style='width:100%;' cellspacing=0 cellpadding=0>\n";
				echo "					<tr>\n";
				if (!$playMode) {
					echo "						<td width='1%' style='text-align:left;'>\n";
					echo "							<a href='gui_edit_formation.php?formationid=".$formationidSelected."'><i class='fas fa-edit'></i></a>\n";
					echo "						</td>\n";
				}
				echo "						<td width='98%' style='text-align:center;'>\n";
				echo "							<a href='gui_play_unit.php?stv=1&formationid=".$formationidSelected."'>".$formationnameSelected."</a>\n";
				if (!$playMode) {
					echo "							&nbsp;&nbsp;&nbsp;<span id='bidOverviewFormation".$formationind."'>&nbsp;</span>\n";
				} else {
					echo "							&nbsp;&nbsp;&nbsp;<span id='bidOverviewFormation".$formationind."'>(PV 10 / 100)</span>\n";
				}
				echo "						</td>\n";
				echo "						<td width='1%' style='text-align:right;'>\n";
				echo "							<img src='./images/factions/".$factionlogo."' width='20px' style='border:1px solid #000000;'>\n";
				echo "						</td>\n";
				echo "					</tr>\n";
				echo "				</table>\n";
				echo "			</td>\n";
			} else {
				echo "			<td nowrap width='99%' style='background-color:#444444;width:270px;height:30px;text-align:center;' class='formationselect_button_active'>\n";
				echo "				<table style='width:100%;' cellspacing=0 cellpadding=0>\n";
				echo "					<tr>\n";
				echo "						<td nowrap width='99%' style='text-align:center;'>\n";
				echo "							".$formationnameSelected."\n";
				if (!$playMode) {
					echo "							&nbsp;&nbsp;&nbsp;<span id='bidOverviewFormation".$formationind."'>&nbsp;</span>\n";
				} else {
					echo "							&nbsp;&nbsp;&nbsp;<span id='bidOverviewFormation".$formationind."'>(PV 10 / 100)</span>\n";
				}
				echo "						</td>\n";
				echo "						<td width='1%' style='text-align:right;'>\n";
				echo "							<img src='./images/factions/".$factionlogo."' width='20px' style='border:1px solid #000000;'>\n";
				echo "						</td>\n";
				echo "					</tr>\n";
				echo "				</table>\n";
				echo "			</td>\n";
			}

			$unitsInSingleFormation = array();
			$c = 0;

			foreach($result_asc_checkformationassignments as $rowUnitAssignment) {
			// while ($rowUnitAssignment = $result_asc_checkformationassignments->fetch_assoc()) {

				$c++;
				$assignedUnitID = $rowUnitAssignment['unitid'];
				$assignedPilotID = $rowUnitAssignment['pilotid'];

				$unitHasMoved = $rowUnitAssignment['round_moved'];
				$unitHasFired = $rowUnitAssignment['round_fired'];

				$sql_asc_unitstatus = "SELECT SQL_NO_CACHE * FROM asc_unitstatus WHERE unitid=".$assignedUnitID." AND round=".$CURRENTROUND." AND gameid=".$gid.";";
				$result_asc_unitstatus = mysqli_query($conn, $sql_asc_unitstatus);
				if (mysqli_num_rows($result_asc_unitstatus) > 0) {
					while($rowUnitStatus = mysqli_fetch_assoc($result_asc_unitstatus)) {
						$unitstatus = $rowUnitStatus['unit_status'];
						$unitstatusimage = $rowUnitStatus['unit_statusimageurl'];
						$activebid = $rowUnitStatus['active_bid'];
						$activenarc = $rowUnitStatus['active_narc'];
						$activewater = $rowUnitStatus['active_water'];
						$heat = $rowUnitStatus['heat'];
					}
				}

				$sql_asc_unit = "SELECT "
							."SQL_NO_CACHE "
							."asc_unit.tech, asc_unit.unit_number, asc_unit.as_model, asc_unit.as_pv, asc_unit.unit_tonnage, asc_unit.as_tp, "
							."asc_unit.commander, asc_unit.subcommander, "
							."asc_unitstatus.active_bid "
							."FROM "
							."asc_unit, asc_unitstatus "
							."WHERE asc_unit.unitid=".$assignedUnitID." "
							."AND asc_unit.unitid=asc_unitstatus.unitid "
							."AND asc_unitstatus.round=".$CURRENTROUND." "
							."AND asc_unitstatus.gameid=".$gid." "
							."ORDER BY asc_unitstatus.active_bid ASC, asc_unit.unit_tonnage DESC;";
				$result_asc_unit = mysqli_query($conn, $sql_asc_unit);

				if (mysqli_num_rows($result_asc_unit) > 0) {
					while($rowUnit = mysqli_fetch_assoc($result_asc_unit)) {

						$clan = "";
						if ($rowUnit["tech"] == "2") {
							//$clan = "c ";
							$clan = "";
						}

						$unitnumber = $rowUnit['unit_number'];
						$unitchassisname = $clan.$rowUnit['as_model'];
						$unitpointvalue = $rowUnit['as_pv'];
						$unittonnage = $rowUnit['unit_tonnage'];
						$unittype = $rowUnit['as_tp'];

						$commander = $rowUnit['commander'];
						$subcommander = $rowUnit['subcommander'];

						// Unitstatusimage will be set to "_01.png" when the round is reset to 1
						// This is cleaned up here
						if ($unitstatusimage == "_01.png") {
							$unitstatusimage = "images/DD_".$unittype."_01.png";
						}

						$pointvaluetotal = $pointvaluetotal + intval($unitpointvalue);
						$tonnagetotal = $tonnagetotal + intval($unittonnage);
						$pvformation[$formationind] = $pvformation[$formationind] + intval($unitpointvalue);
						$tonnageformation[$formationind] = $tonnageformation[$formationind] + intval($unittonnage);

						if ($activebid == "1") {
							$pointvaluetotalactivebid = $pointvaluetotalactivebid + intval($unitpointvalue);
							$tonnagetotalactivebid = $tonnagetotalactivebid + intval($unittonnage);
							$pvformationbid[$formationind] = $pvformationbid[$formationind] + intval($unitpointvalue);
							$tonnageformationbid[$formationind] = $tonnageformationbid[$formationind] + intval($unittonnage);
						}

						$unitRoundStatusImage = "";
						if ($unitHasMoved == 0 && $unitHasFired == 0) {
							$unitRoundStatusImage = "./images/top-right_phase01.png";
							if ($unitstatus != "destroyed" && $activebid != 0) {
								$readyToFinalizeRound = 0;
								// echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
							}
						}
						if ($unitHasMoved == 0 && $unitHasFired > 0) {
							$unitRoundStatusImage = "./images/top-right_phase01.png";
							if ($unitstatus != "destroyed" && $activebid != 0) {
								$readyToFinalizeRound = 0;
								// echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
							}
						}
						if ($unitHasMoved > 0 && $unitHasFired == 0) {
							$unitRoundStatusImage = "./images/top-right_phase02.png";
							if ($unitstatus != "destroyed" && $activebid != 0) {
								$readyToFinalizeRound = 0;
								// echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
							}
						}
						if ($unitHasMoved > 0 && $unitHasFired > 0) {
							$unitRoundStatusImage = "./images/top-right_phase03.png";
						}
						if ($heat == 4) {
							$unitRoundStatusImage = "./images/heat.png";
						}
					}
				}

				$sql_asc_pilot = "SELECT SQL_NO_CACHE * FROM asc_pilot WHERE pilotid=".$assignedPilotID.";";
				$result_asc_pilot = mysqli_query($conn, $sql_asc_pilot);
				if (mysqli_num_rows($result_asc_pilot) > 0) {
					while($rowPilot = mysqli_fetch_assoc($result_asc_pilot)) {
						$pilotrank = $rowPilot['rank'];
						$pilotname = $rowPilot['name'];
					}
				}

				$numStr = $unitnumber;
				if ($unitnumber == null || $unitnumber == "") {
					$numStr = "-";
				}

				if ($activebid == "1") {
					// active in current bid
					$bidcolor = "#444444;";
				} else {
					// given away in bidding
					$bidcolor = "#741300;";
				}

				if ($unitstatus == "destroyed") {
					$unitRoundStatusImage = "./images/skull.png";
					$bidcolor = "#222;";
					// background-image:repeating-linear-gradient(45deg, #444444 0%, #444444 2%, #aaaa00 2%, #aaaa00 4%, #444444 4%);
				}

				$unitDetailString = "";

				if ($activebid == "1") {
					if (!$playMode) {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_edit_unit.php?unitid=".$assignedUnitID."'\" style='background-color:#444;color:#aaa;text-align:right;'>\n";
						$unitDetailString = $unitDetailString."							<span style='font-size:16px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-edit'></i>&nbsp;&nbsp;&nbsp;\n";
						$unitDetailString = $unitDetailString."							</span>\n";
						$unitDetailString = $unitDetailString."						</td>\n";
					} else {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_select_unit.php?activebid=0&formationid=".$formationidSelected."&unitid=".$assignedUnitID."'\" style='background-color:#121212;text-align:right;'>\n";
						$unitDetailString = $unitDetailString."							<span style='font-size:16px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-left' aria-hidden='true' style='font-size:40;color:#741300;'></i>&nbsp;&nbsp;&nbsp;\n";
						$unitDetailString = $unitDetailString."							</span>\n";
						$unitDetailString = $unitDetailString."						</td>\n";
					}
				} else {
					if (!$playMode) {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_edit_unit.php?unitid=".$assignedUnitID."'\" style='background-color:#444;color:#aaa;text-align:right;'>\n";
						$unitDetailString = $unitDetailString."							<span style='font-size:16px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-edit'></i>&nbsp;&nbsp;&nbsp;\n";
						$unitDetailString = $unitDetailString."							</span>\n";
						$unitDetailString = $unitDetailString."						</td>\n";
					} else {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_select_unit.php?activebid=1&formationid=".$formationidSelected."&unitid=".$assignedUnitID."'\" style='background-color:#121212;text-align:right;'>\n";
						$unitDetailString = $unitDetailString."							<span style='font-size:16px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-right' aria-hidden='true' style='font-size:40;color:#2f7c2f;'></i>&nbsp;&nbsp;&nbsp;\n";
						$unitDetailString = $unitDetailString."							</span>\n";
						$unitDetailString = $unitDetailString."						</td>\n";
					}
				}

				if ($activebid == "1") {
					$unitDetailString = $unitDetailString."			<td nowrap onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$formationidSelected."&chosenunit=".$c."\"' style='background-color:".$bidcolor."' class='unitselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$unitstatusimage."' height='24px'><br><span style='font-size:14px;'>".$numStr."</span></div></td>\n";
				} else {
					$unitDetailString = $unitDetailString."			<td nowrap style='background-color:".$bidcolor."' class='unitselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$unitstatusimage."' height='24px'><br><span style='font-size:14px;'>".$numStr."</span></div></td>\n";
				}
				$unitDetailString = $unitDetailString."			<td nowrap style='width:100%;background-color:".$bidcolor."' class='unitselect_button_active'>\n";
				$unitDetailString = $unitDetailString."				<table width='100%' height='100%' cellspacing=0 cellpadding=0 border=0px>\n";
				$unitDetailString = $unitDetailString."					<tr>\n";

				if ($activebid == "1") {
					$unitDetailString = $unitDetailString."						<td nowrap onclick='location.href=\"gui_play_unit.php?stv=1&formationid=".$formationidSelected."&chosenunit=".$c."\"' width='99%' align='left' valign='bottom' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><span style='font-size:24px;'>";
				} else {
					$unitDetailString = $unitDetailString."						<td nowrap width='99%' align='left' valign='bottom' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;overflow:hidden;white-space:nowrap;text-overflow:ellipsis'><span style='font-size:24px;'>";
				}
				//$unitDetailString = $unitDetailString."						".textTruncate($unitchassisname, 15)."</span><span style='font-weight:normal;font-size:20px;color:#ffc677;'> ".$unitpointvalue."/".$unittonnage."t</span>\n";
				$unitDetailString = $unitDetailString."						".textTruncate($unitchassisname, 10)."</span><span style='font-weight:normal;font-size:20px;color:#ffc677;'>&nbsp;&nbsp;PV&nbsp;".$unitpointvalue."</span> <span style='font-weight:normal;font-size:20px;color:#aaaaaa;'>(".$unittonnage."t)</span>\n";
				$unitDetailString = $unitDetailString."						<br>";
				if ($commander == 1) {
					$unitDetailString = $unitDetailString."						<div style='font-size:18px;top:0px;bottom:0px;left:0px;right:0px;'><img style='vertical-align:bottom;padding-top:3px' src='./images/command.png' width='16px' height='16px'>&nbsp;&nbsp;<img style='vertical-align:bottom;padding-top:3px' src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='16px' height='16px'>&nbsp;&nbsp;".$pilotname."</div>\n";
				} else if ($subcommander == 1) {
					$unitDetailString = $unitDetailString."						<div style='font-size:18px;top:0px;bottom:0px;left:0px;right:0px;'><img style='vertical-align:bottom;padding-top:3px' src='./images/subcommand.png' width='16px' height='16px'>&nbsp;&nbsp;<img style='vertical-align:bottom;padding-top:3px' src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='16px' height='16px'>&nbsp;&nbsp;".$pilotname."</div>\n";
				} else {
					$unitDetailString = $unitDetailString."						<div style='font-size:18px;top:0px;bottom:0px;left:0px;right:0px;'><img style='vertical-align:bottom;padding-top:3px' src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='16px' height='16px'>&nbsp;&nbsp;".$pilotname."</div>\n";
				}
				$unitDetailString = $unitDetailString."						</td>\n";

				if ($playMode) {
					if ($activenarc == "1") {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' class='datalabel_disabled_dashed' style='vertical-align:middle;text-align:right;'>\n";
					} else {
						$unitDetailString = $unitDetailString."						<td nowrap width='1%' style='background-color:".$bidcolor.";vertical-align:middle;text-align:right;'>\n";
					}
					if ($activebid == "1") {
						$unitDetailString = $unitDetailString."							<span style='font-size:12px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;<img width='25px' src='".$unitRoundStatusImage."'>\n";
						$unitDetailString = $unitDetailString."							</span>\n";
					} else {
						$unitDetailString = $unitDetailString."							<span style='font-size:12px;'>\n";
						$unitDetailString = $unitDetailString."								&nbsp;&nbsp;\n";
						$unitDetailString = $unitDetailString."							</span>\n";
					}
					$unitDetailString = $unitDetailString."						</td>\n";
				} else {
					$unitDetailString = $unitDetailString."						<td onclick='location.href=\"gui_select_unit.php?dm=1&unitid=".$assignedUnitID."&formationid=".$formationidSelected."&pilotid=".$assignedPilotID."\"' nowrap width='1%' valign='middle' style='background-color:".$bidcolor."text-align:right;'>\n";
					$unitDetailString = $unitDetailString."							<span style='font-size:12px;'>\n";
					$unitDetailString = $unitDetailString."								<i class='fas fa-minus-square'></i>\n";
					$unitDetailString = $unitDetailString."							</span>\n";
					$unitDetailString = $unitDetailString."						</td>\n";
				}

				$unitDetailString = $unitDetailString."					</tr>\n";
				$unitDetailString = $unitDetailString."				</table>\n";
				$unitDetailString = $unitDetailString."			</td>\n";

				array_push($unitsInSingleFormation, $unitDetailString);
			}
			array_push($unitsInAllFormations, $unitsInSingleFormation);
			$formationind++;
		}
	}

	echo "		</tr>\n";
//	if (!$playMode) {
//		echo "		<tr>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignUnitToFormationLinkArray[0]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addUnitToFormationLinkArray[0]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignUnitToFormationLinkArray[1]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addUnitToFormationLinkArray[1]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignUnitToFormationLinkArray[2]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addUnitToFormationLinkArray[2]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "		</tr>\n";
//	}
	echo "		<tr>\n";

	foreach ($unitsInAllFormations as &$unitsInSingleFormation) {
		echo "			<td width='33%' style='background-color:#333333;' valign='top'>\n";
		echo "				<div class='scroll-pane'>\n";
		echo "					<table cellspacing=1 cellpadding=0 border=0px style='border-collapse: collapse;'>\n";
		foreach ($unitsInSingleFormation as &$unit) {
			echo "						<tr>\n";
			echo "							".$unit."\n";
			echo "						</tr>\n";
		}
		echo "					</table>\n";
		echo "				</div>\n";
		echo "			</td>\n";
	}
	echo "		</tr>\n";

	echo "		<tr>\n";
	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='center'><span style='font-size:18px;color:#aaaaaa;'><i class='fa-solid fa-weight-hanging fa-sm'></i>&nbsp;&nbsp;&nbsp;".$tonnageformationbid[0]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#aaaaaa;'>".$tonnageformation[0]."t</span></td>\n";
	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='center'><span style='font-size:18px;color:#aaaaaa;'><i class='fa-solid fa-weight-hanging fa-sm'></i>&nbsp;&nbsp;&nbsp;".$tonnageformationbid[1]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#aaaaaa;'>".$tonnageformation[1]."t</span></td>\n";
	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='center'><span style='font-size:18px;color:#aaaaaa;'><i class='fa-solid fa-weight-hanging fa-sm'></i>&nbsp;&nbsp;&nbsp;".$tonnageformationbid[2]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#aaaaaa;'>".$tonnageformation[2]."t</span></td>\n";
	echo "		</tr>\n";

//	echo "		<tr>\n";
//	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='left'><span style='font-size:18px;color:#eeeeee;'>BID:&nbsp;</span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[0]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#ffc677;'>".$tonnageformationbid[0]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>PV ".$pvformation[0]."&nbsp;/&nbsp;".$tonnageformation[0]."t</span></td>\n";
//	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='left'><span style='font-size:18px;color:#eeeeee;'>BID:&nbsp;</span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[1]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#ffc677;'>".$tonnageformationbid[1]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>PV ".$pvformation[1]."&nbsp;/&nbsp;".$tonnageformation[1]."t</span></td>\n";
//	echo "			<td colspan='1' style='background-color:#333333;padding:1px;vertical-align:middle;' align='left'><span style='font-size:18px;color:#eeeeee;'>BID:&nbsp;</span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[2]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#ffc677;'>".$tonnageformationbid[2]."t</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>PV ".$pvformation[2]."&nbsp;/&nbsp;".$tonnageformation[2]."t</span></td>\n";
//	echo "		</tr>\n";
//	echo "		<tr>\n";
//	echo "			<td colspan='4' style='background-color:#333333;padding:1px;vertical-align:middle;' align='center'>";
//	echo "				<span style='font-size:18px;color:#eeeeee;'>Bid:&nbsp;</span><span style='font-size:18px;color:#ffc677;'>PV ".$pointvaluetotalactivebid."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#ffc677;'>".$tonnagetotalactivebid."t</span>";
//	echo "				<span style='font-size:18px;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
//	echo "				<span style='font-size:18px;color:#eeeeee;'>TOTAL:&nbsp;PV ".$pointvaluetotal."&nbsp;/&nbsp;".$tonnagetotal."t</span>";
//	echo "			</td>\n";
//	echo "		</tr>\n";

	if ($playMode) {
		// if ($readyToFinalizeRound == 1) {
			echo "		<script>\n";
			echo "			document.getElementById('FinalizeRoundButton').style.backgroundColor = '#517d25';";
			echo "		</script>\n";
		// } else {
		//	echo "		<script>\n";
		//	echo "			document.getElementById('FinalizeRoundButton').style.backgroundColor = '#5c0700';";
		//  echo "		</script>\n";
		//}
	}

	echo "		</table>\n";

	//	bidOverviewCommand
	//	bidOverviewFormation0
	//	bidOverviewFormation1
	//	bidOverviewFormation2

	echo "		<script>\n";
	echo "			var bidinfoco = \"<span style='font-size:18px;color:#eeeeee;'></span><span style='font-size:18px;color:#ffc677;'>PV ".$pointvaluetotalactivebid."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>".$pointvaluetotal."</span>\";\n";
	echo "			var bidinfof0 = \"<span style='font-size:18px;color:#eeeeee;'></span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[0]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>".$pvformation[0]."</span>\";\n";
	echo "			var bidinfof1 = \"<span style='font-size:18px;color:#eeeeee;'></span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[1]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>".$pvformation[1]."</span>\";\n";
	echo "			var bidinfof2 = \"<span style='font-size:18px;color:#eeeeee;'></span><span style='font-size:18px;color:#ffc677;'>PV ".$pvformationbid[2]."</span><span style='font-size:18px;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:18px;color:#eeeeee;'>".$pvformation[2]."</span>\";\n";
	echo "			document.getElementById('bidOverviewCommand').innerHTML = bidinfoco;\n";
	echo "			document.getElementById('bidOverviewFormation0').innerHTML = bidinfof0;\n";
	echo "			document.getElementById('bidOverviewFormation1').innerHTML = bidinfof1;\n";
	echo "			document.getElementById('bidOverviewFormation2').innerHTML = bidinfof2;\n";
	echo "		</script>\n";
?>

<?php
	if (!$playMode) {
		echo "<p align='center' class='footerInfo'>Enable playmode to change your bid.</p>\n";
	} else {
		echo "<p align='center' class='footerInfo'>Check your bid. Disable playmode to unassign units.</p>\n";
	}
?>
</body>

</html>
