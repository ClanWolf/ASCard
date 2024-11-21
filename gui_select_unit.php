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

		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php?activebid=0&mechid=" . $mechid . "'>";
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

	function textTruncate($text, $chars=25) {
        if (strlen($text) <= $chars) {
            return $text;
        }
        $text = $text." ";
        $text = substr($text,0,$chars);
        //$text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit selector</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
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
            $('.scroll-pane').jScrollPane();
        });
		function finalizeRound(playerId) {
			var url="./save_finalize_round.php?pid=" + playerId;
			window.frames["saveframe"].location.replace(url);
		}
	</script>

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
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="100px" style="width: 100px;background: rgba(56,87,26,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color:#eee;" href="./gui_select_unit.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				-->
				<td nowrap onclick="location.href='./gui_select_unit.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_active'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=" . $buttonWidth . "><div class='mechselect_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_unit.php'>ADD</a><br><span style='font-size:16px;'>Create a unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_game.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_game.php'>GAME</a><br><span style='font-size:16px;'>Game settings</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
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

	<table align="center" width="85%" cellspacing=2 cellpadding=2 border=0px>
		<tr>
<?php

	$addMechToUnitLinkArray = array();
	$assignMechToUnitLinkArray = array();
	$mechsInAllUnits = array();
	$pointvaluetotal = 0;
	$pointvaluetotalactivebid = 0;
	$tonnagetotal = 0;
	$tonnagetotalactivebid = 0;

	$readyToFinalizeRound = 1;

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

			array_push($addMechToUnitLinkArray, "gui_create_unit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);
			array_push($assignMechToUnitLinkArray, "gui_assign_unit.php?unitid=".$unitidSelected."&unitname=".$forcenameSelected);

			$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
			$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
			if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
				echo "			<td nowrap style='width:270px;height:40px;' onclick='location.href=\"gui_play_unit.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>\n";
				echo "				<table style='width:100%;' cellspacing=0 cellpadding=0>\n";
				echo "					<tr>\n";
				if (!$playMode) {
					echo "						<td style='text-align:left;'>\n";
					echo "							<a href='gui_edit_formation.php?unit=".$unitidSelected."'><i class='fas fa-edit'></i></a>\n";
					echo "						</td>\n";
				}
				echo "						<td style='text-align:center;'>\n";
				echo "							<a href='gui_play_unit.php?unit=".$unitidSelected."'>".$forcenameSelected."</a>\n";
				echo "						</td>\n";
				echo "						<td style='text-align:right;'>\n";
				echo "							<img src='./images/factions/".$unitlogo."' width='20px' style='border:1px solid;'>\n";
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

				$mechHasMoved = $rowUnitAssignment['round_moved'];
				$mechHasFired = $rowUnitAssignment['round_fired'];

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
						$mechstatus = $rowMech['mech_status'];

						$pointvaluetotal = $pointvaluetotal + intval($mechpointvalue);
						$tonnagetotal = $tonnagetotal + intval($mechtonnage);

						if ($activebid == "1") {
							$pointvaluetotalactivebid = $pointvaluetotalactivebid + intval($mechpointvalue);
							$tonnagetotalactivebid = $tonnagetotalactivebid + intval($mechtonnage);
						}

						$mechRoundStatusImage = "";
                        if ($mechHasMoved == 0 && $mechHasFired == 0) {
                            $mechRoundStatusImage = "./images/top-right_phase01.png";
                            if ($mechstatus != "destroyed" && $activebid != 0) {
                                $readyToFinalizeRound = 0;
								// echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
                            }
                        }
                        if ($mechHasMoved == 0 && $mechHasFired > 0) {
                            $mechRoundStatusImage = "./images/top-right_phase01.png";
                            if ($mechstatus != "destroyed" && $activebid != 0) {
                                $readyToFinalizeRound = 0;
                                // echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
                            }
                        }
                        if ($mechHasMoved > 0 && $mechHasFired == 0) {
                            $mechRoundStatusImage = "./images/top-right_phase02.png";
							if ($mechstatus != "destroyed" && $activebid != 0) {
							    $readyToFinalizeRound = 0;
                                // echo "<script>console.log('negating!".$readyToFinalizeRound."');</script>";
							}
                        }
                        if ($mechHasMoved > 0 && $mechHasFired > 0) {
                            $mechRoundStatusImage = "./images/top-right_phase03.png";
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

				if ($mechstatus == "destroyed") {
					$mechRoundStatusImage = "./images/skull.png";
					$bidcolor = "#222;";
					// background-image:repeating-linear-gradient(45deg, #444444 0%, #444444 2%, #aaaa00 2%, #aaaa00 4%, #444444 4%);
				}

				$mechDetailString = "";

//				$mechDetailString = $mechDetailString."						<td nowrap width='1%' onclick='location.href=\"\"' style='background-color:#121212;text-align:right;'>\n";
//				$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
//				if (!$playMode) {
//					$mechDetailString = $mechDetailString."								\n";
//				} else {
//					if ($activebid == "1") {
//						$mechDetailString = $mechDetailString."								<span><a href='./gui_select_unit.php?activebid=0&mechid=".$assignedMechID."'>&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-left' aria-hidden='true' style='font-size:40;color:#741300;'></i></a>&nbsp;&nbsp;&nbsp;</span>\n";
//					} else {
//						$mechDetailString = $mechDetailString."								<span><a href='./gui_select_unit.php?activebid=1&mechid=".$assignedMechID."'>&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-right' aria-hidden='true' style='font-size:40;color:#2f7c2f;'></i></a>&nbsp;&nbsp;&nbsp;</span>\n";
//					}
//				}
//				$mechDetailString = $mechDetailString."							</span>\n";
//				$mechDetailString = $mechDetailString."						</td>\n";

				if ($activebid == "1") {
					$mechDetailString = $mechDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_select_unit.php?activebid=0&mechid=".$assignedMechID."'\" style='background-color:#121212;text-align:right;'>\n";
					$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
					if (!$playMode) {
						$mechDetailString = $mechDetailString."								\n";
					} else {
						$mechDetailString = $mechDetailString."								<span>&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-left' aria-hidden='true' style='font-size:40;color:#741300;'></i>&nbsp;&nbsp;&nbsp;</span>\n";
					}
					$mechDetailString = $mechDetailString."							</span>\n";
					$mechDetailString = $mechDetailString."						</td>\n";
				} else {
					$mechDetailString = $mechDetailString."						<td nowrap width='1%' onclick=\"location.href='gui_select_unit.php?activebid=1&mechid=".$assignedMechID."'\" style='background-color:#121212;text-align:right;'>\n";
					$mechDetailString = $mechDetailString."							<span style='font-size:16px;'>\n";
					if (!$playMode) {
						$mechDetailString = $mechDetailString."								\n";
					} else {
						$mechDetailString = $mechDetailString."								<span>&nbsp;&nbsp;&nbsp;<i class='fas fa-arrow-circle-right' aria-hidden='true' style='font-size:40;color:#2f7c2f;'></i>&nbsp;&nbsp;&nbsp;</span>\n";
					}
					$mechDetailString = $mechDetailString."							</span>\n";
					$mechDetailString = $mechDetailString."						</td>\n";
				}







				if ($activebid == "1") {
					$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_unit.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='background-color:".$bidcolor."' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$mechstatusimage."' height='24px'><br><span style='font-size:14px;'>".$numStr."</span></div></td>\n";
					$mechDetailString = $mechDetailString."			<td nowrap onclick='location.href=\"gui_play_unit.php?unit=".$unitidSelected."&chosenmech=".$c."\"' style='width:100%;background-color:".$bidcolor."' class='mechselect_button_active'>\n";
				} else {
					$mechDetailString = $mechDetailString."			<td nowrap style='background-color:".$bidcolor."' class='mechselect_button_active' align='right' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$mechstatusimage."' height='24px'><br><span style='font-size:14px;'>".$numStr."</span></div></td>\n";
					$mechDetailString = $mechDetailString."			<td nowrap style='width:100%;background-color:".$bidcolor."' class='mechselect_button_active'>\n";
				}
				$mechDetailString = $mechDetailString."				<table width='100%' cellspacing=0 cellpadding=0 border=0px>\n";
				$mechDetailString = $mechDetailString."					<tr>\n";

				if ($activebid == "1") {
					$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><a href=gui_play_unit.php?unit=".$unitidSelected."&chosenmech=".$c."> <span style='font-size:24px;'>";
				} else {
					$mechDetailString = $mechDetailString."						<td nowrap width='99%' align='left' style='color:#AAAAAA;background-color:".$bidcolor."text-align:left;'><a href='' target='_SELF'> <span style='font-size:24px;'>";
				}
				$mechDetailString = $mechDetailString."						<img src='./images/ranks/".$factionidSelected."/".$pilotrank.".png' width='16px' height='16px'>";
				$mechDetailString = $mechDetailString."						".$pilotname."</span> <span style='font-weight:normal;font-size:20px;color:#ffc677;'> ".$mechpointvalue."/".$mechtonnage."t</span></a></span>\n";
				$mechDetailString = $mechDetailString."							<br><span style='font-size:15px;'>".textTruncate($mechchassisname, 18)."</span>\n";
				$mechDetailString = $mechDetailString."						</td>\n";

				$mechDetailString = $mechDetailString."						<td nowrap width='1%' valign='top' style='background-color:".$bidcolor."text-align:right;'>\n";
				$mechDetailString = $mechDetailString."							<span style='font-size:12px;'>\n";

				if ($playMode) {
					$mechDetailString = $mechDetailString."								&nbsp;&nbsp;<img width='25px' src='".$mechRoundStatusImage."'>\n";
				} else {
					$mechDetailString = $mechDetailString."								<a href='./gui_select_unit.php?dm=1&mechid=".$assignedMechID."&pilotid=".$assignedPilotID."'><i class='fas fa-minus-square'></i></a>\n";
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

	if ($playMode) {
		// FINALIZE ROUND
		echo "  		<td nowrap onclick='javascript:finalizeRound(".$pid.");' id='FinalizeRoundButton' style='text-align:center;width:100px;background:rgba(81,125,37,1.0);' rowspan='2'><div style='vertical-align:middle;font-size:42px;color:#eee;'>&nbsp;&nbsp;&nbsp;<i class='fas fa-redo'></i>&nbsp;&nbsp;&nbsp;</div></td>\n";
	}

	echo "		</tr>\n";
//	if (!$playMode) {
//		echo "		<tr>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignMechToUnitLinkArray[0]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addMechToUnitLinkArray[0]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignMechToUnitLinkArray[1]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addMechToUnitLinkArray[1]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "			<td nowrap style='text-align:center;width:200px;height:30px;background-color:#transparent;'>\n";
//		echo "				<a href='".$assignMechToUnitLinkArray[2]."'><i class='fas fa-plus-square'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
//		echo "				<a href='".$addMechToUnitLinkArray[2]."'><i class='fas fa-asterisk'></i></a>\n";
//		echo "			</td>\n";
//		echo "		</tr>\n";
//	}
	echo "		<tr>\n";

	foreach ($mechsInAllUnits as &$mechsInSingleUnit) {
		echo "			<td width='33%' style='background-color:#333333;' valign='top'>\n";
		echo "				<div class='scroll-pane'>\n";
		echo "				<table cellspacing=1 cellpadding=0 border=0px style='border-collapse: collapse;'>\n";
		foreach ($mechsInSingleUnit as &$mech) {
			echo "					<tr>\n";
			echo "						".$mech."\n";
			echo "					</tr>\n";
		}
		echo "				</table>\n";
		echo "				</div>\n";
		echo "			</td>\n";
	}
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td colspan='4' style='background-color:#333333;' align='center' valign='top'>";
	echo "				<span style='font-size:20;color:#eeeeee;'>Bid:&nbsp;</span><span style='font-size:20;color:#ffc677;'>PV ".$pointvaluetotalactivebid."</span><span style='font-size:20;color:#eeeeee;'>&nbsp;/&nbsp;</span><span style='font-size:20;color:#ffc677;'>".$tonnagetotalactivebid."t</span>";
	echo "				<span style='font-size:20;color:#eeeeee;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
	echo "				<span style='font-size:20;color:#eeeeee;'>Total:&nbsp;PV ".$pointvaluetotal."&nbsp;/&nbsp;".$tonnagetotal."t</span>";
	echo "			</td>\n";
	echo "		</tr>\n";

	if ($readyToFinalizeRound == 1) {
		echo "<script>\n";
		echo "document.getElementById('FinalizeRoundButton').style.backgroundColor = '#517d25';";
		echo "</script>\n";
	} else {
		echo "<script>\n";
		echo "document.getElementById('FinalizeRoundButton').style.backgroundColor = '#5c0700';";
        echo "</script>\n";
	}
?>
	</table>

<?php
	if (!$playMode) {
		echo "<p align='center' class='footerInfo'>Enable playmode to change your bid.</p>\n";
	} else {
		echo "<p align='center' class='footerInfo'>Check your bid. Disable playmode to unassign units.</p>\n";
	}
?>
</body>

</html>
