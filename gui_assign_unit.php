<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 11");
	}
	// Get data from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pname = $_SESSION['name'];
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

	$paramformationid = isset($_GET["formationid"]) ? $_GET["formationid"] : "";
	$paramformationname = isset($_GET["formationname"]) ? $_GET["formationname"] : "";
	$assignunit = isset($_GET["assignunit"]) ? $_GET["assignunit"] : "";
	$deletestoredunit = isset($_GET["deletestoredunit"]) ? $_GET["deletestoredunit"] : "";

	if ($assignunit == 1) {
		$FORMATIONID = isset($_GET["FORMATIONID"]) ? $_GET["FORMATIONID"] : "";
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";

		$sql_update_assignment = "UPDATE asc_assign set formationid = ".$FORMATIONID." where unitid = ".$UNITID;
		if (mysqli_query($conn, $sql_update_assignment)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_update_assignment . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sql_update_assignment . ": " . mysqli_error($conn));
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php?activebid=1&unitid=" . $UNITID . "'>";
	}

	if ($deletestoredunit == 1) {
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";
		$PILOTID = 0;

		logMsg("Deleting stored unit: " . $UNITID . " (id)");

		$sql_pilotid = "select pilotid from asc_assign where unitid = ".$UNITID;
		if (!($stmt = $conn->prepare($sql_pilotid))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		if ($stmt->execute()) {
			$res = $stmt->get_result();
			while ($row = $res->fetch_assoc()) {
				$PILOTID = $row['pilotid'];
				logMsg("Found pilot id for given unit: " . $PILOTID);
			}
		}

		$sqldeleteunit = "DELETE FROM asc_unit WHERE unitid = ".$UNITID;
		if (mysqli_query($conn, $sqldeleteunit)) {
			// Success
			logMsg("Deleted unit: ".$UNITID);
		} else {
			// Error
			echo "Error: " . $sqldeleteunit . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeleteunit . ": " . mysqli_error($conn));
		}

		$sqldeleteunitstatus = "DELETE FROM asc_unitstatus WHERE unitid = ".$UNITID;
		if (mysqli_query($conn, $sqldeleteunitstatus)) {
			// Success
			logMsg("Deleted status for unit: ".$UNITID);
		} else {
			// Error
			echo "Error: " . $sqldeleteunitstatus . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeleteunitstatus . ": " . mysqli_error($conn));
		}

		$sqldeletepilot = "DELETE FROM asc_pilot WHERE pilotid = ".$PILOTID;
		if (mysqli_query($conn, $sqldeletepilot)) {
			// Success
			logMsg("Deleted Pilot: ".$PILOTID);
		} else {
			// Error
			echo "Error: " . $sqldeletepilot . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeletepilot . ": " . mysqli_error($conn));
		}

		$sqldeleteassign = "DELETE FROM asc_assign WHERE pilotid = ".$PILOTID." and unitid = ".$UNITID;
		if (mysqli_query($conn, $sqldeleteassign)) {
			// Success
			logMsg("Deleted assignment for unit: ".$UNITID." and pilot: ".$PILOTID);
		} else {
			// Error
			echo "Error: " . $sqldeleteassign . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeleteassign . ": " . mysqli_error($conn));
		}
	}
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Assignment</title>
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
	<script type="text/javascript" src="./scripts/basic.js"></script>

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
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});

		function assignUnit() {
			var url="./gui_assign_unit.php?assignunit=1";

			// Assign existing unit
			var FORMATIONID = document.getElementById('FORMATIONID').value;
			var UNITID = document.getElementById('existingUnits').value;

			if (UNITID == 0) {
				alert("Select a stored unit first!");
				return;
			}

			url=url+"&FORMATIONID="+encodeURIComponent(FORMATIONID);
			url=url+"&UNITID="+encodeURIComponent(UNITID);

			// alert(url);
			window.location.href = url;
		}

		function deleteStoredUnit() {
			var url="./gui_assign_unit.php?deletestoredunit=1";

			// Delete existing unit from hangar
			var UNITID = document.getElementById('existingUnits').value;

			if (UNITID == 0) {
				alert("Select a stored unit first!");
				return;
			}

			url=url+"&UNITID="+encodeURIComponent(UNITID);

			// alert(url);
			window.location.href = url;
		}
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
				<td nowrap onclick="location.href='./gui_select_unit.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='unitselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit</span></div></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a><br><span style='font-size:16px;'>Batchall & bidding</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_active'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
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
				<td style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="off">
		<table class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='4'>
					Existing units: <select required name='existingUnits' id='existingUnits' size='1' onchange="" style='width:400px;'>
						<option value="0"><<< Select a unit >>></option>
<?php
	$sql_asc_units = "select u.unitid, u.unit_number, u.as_model, p.name from asc_assign a, asc_unit u, asc_pilot p where a.formationid is null and a.unitid = u.unitid and a.pilotid = p.pilotid and u.playerid=".$pid;
	$result_asc_units = mysqli_query($conn, $sql_asc_units);
	if (mysqli_num_rows($result_asc_units) > 0) {
		while($rowUnits = mysqli_fetch_assoc($result_asc_units)) {
			// #81 | Timber Wolf (Mad Cat) E (Mike)
			$unitid = $rowUnits['unitid'];
			$unitnumber = $rowUnits['unit_number'];
			$model = $rowUnits['as_model'];
			$pilotname = $rowUnits['name'];

			$entryValue = $unitid;
			$entryString = $unitnumber." | ".$model." [".$pilotname."]";

			echo "						<option value=".$entryValue.">".$entryString."</option>\n";
		}
	}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='3'>Assign to formation: <select required name='FORMATIONID' id='FORMATIONID' size='1' style='width:250px;'>
<?php
	$sql_asc_playersformations = "SELECT SQL_NO_CACHE * FROM asc_formation where playerid=".$pid;
	$result_asc_playersformations = mysqli_query($conn, $sql_asc_playersformations);
	if (mysqli_num_rows($result_asc_playersformations) > 0) {
		while($rowFormation = mysqli_fetch_assoc($result_asc_playersformations)) {
			$formationid = $rowFormation['formationid'];
			$formationname = $rowFormation['formationname'];
			if ($paramformationid == $formationid) {
				echo "										<option value='".$formationid."' selected>".$formationname."</option>\n";
			} else {
				echo "										<option value='".$formationid."'>".$formationname."</option>\n";
			}
		}
	}
?>
					</select>
				</td>
				<td align="right">
					<a href='#' onClick='assignUnit();'><i class='fas fa-plus-square'></i></a>
				</td>
			</tr>
<?php
	if ($playMode) {
		echo "			<tr>\n";
		echo "			    <td colspan='4'>\n";
		echo "			</tr>\n";
	} else {
		echo "			<tr>\n";
		echo "				<td colspan='4'><hr></td>\n";
		echo "			</tr>\n";
		echo "			<tr>\n";
		echo "				<td colspan='3'>Delete selected unit from Hangar (!)</td>\n";
		echo "				<td align='right'>\n";

		//if ($isAdmin) { // only admins may delete units
			echo "					<a href='#' onClick='deleteStoredUnit();'><i class='fas fa-minus-square'></i></a>\n";
		//} else {
		//	echo "					<i class=\"fas fa-ban\"></i>\n";
		//}

		echo "				</td>\n";
		echo "			</tr>\n";
	}
?>
		</table>
	</form>
</body>

</html>
