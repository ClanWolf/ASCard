<?php
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
	// Get data on units from db
	$pid = $_SESSION['playerid'];
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
			logMsg("Error: " . $sql_update_assignment . ": " . mysqli_error($conn));
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
	}

	if ($deletestoredmech == 1) {
		$MECHID = isset($_GET["MECHID"]) ? $_GET["MECHID"] : "";
		$PILOTID = 0;

		logMsg("Deleting stored Mech/BA: " . $MECHID . " (id)");

		$sql_pilotid = "select pilotid from asc_assign where mechid = ".$MECHID;
		if (!($stmt = $conn->prepare($sql_pilotid))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		if ($stmt->execute()) {
			$res = $stmt->get_result();
			while ($row = $res->fetch_assoc()) {
				$PILOTID = $row['pilotid'];
				logMsg("Found pilot id for given Mech/BA: " . $PILOTID);
			}
		}

		$sqldeletemech = "DELETE FROM asc_mech WHERE mechid = ".$MECHID;
		if (mysqli_query($conn, $sqldeletemech)) {
			// Success
			logMsg("Deleted Mech/BA: ".$MECHID);
		} else {
			// Error
			echo "Error: " . $sqldeletemech . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeletemech . ": " . mysqli_error($conn));
		}

		$sqldeletemechstatus = "DELETE FROM asc_mechstatus WHERE mechid = ".$MECHID;
		if (mysqli_query($conn, $sqldeletemechstatus)) {
			// Success
			logMsg("Deleted status for Mech/BA: ".$MECHID);
		} else {
			// Error
			echo "Error: " . $sqldeletemechstatus . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeletemechstatus . ": " . mysqli_error($conn));
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

		$sqldeleteassign = "DELETE FROM asc_assign WHERE pilotid = ".$PILOTID." and mechid = ".$MECHID;
		if (mysqli_query($conn, $sqldeleteassign)) {
			// Success
			logMsg("Deleted assignment for Mech/BA: ".$MECHID." and pilot: ".$PILOTID);
		} else {
			// Error
			echo "Error: " . $sqldeleteassign . "<br>" . mysqli_error($conn);
			logMsg("Error: " . $sqldeleteassign . ": " . mysqli_error($conn));
		}

		//echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

	<script type="text/javascript" src="./scripts/jquery-3.6.0.min.js"></script>
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
			var url="./gui_assign_unit.php?assignmech=1";

			// Assign existing mech
			var UNITID = document.getElementById('UNITID').value;
			var MECHID = document.getElementById('existingMechs').value;

			if (MECHID == 0) {
				alert("Select a stored Mech/BA!");
				return;
			}

			url=url+"&UNITID="+encodeURIComponent(UNITID);
			url=url+"&MECHID="+encodeURIComponent(MECHID);

			// alert(url);
			window.location.href = url;
		}

		function deleteStoredMech() {
			var url="./gui_assign_unit.php?deletestoredmech=1";

			// Delete existing mech from hangar
			var MECHID = document.getElementById('existingMechs').value;

			if (MECHID == 0) {
				alert("Select a stored Mech/BA!");
				return;
			}

			url=url+"&MECHID="+encodeURIComponent(MECHID);

			// alert(url);
			window.location.href = url;
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
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="width: 100px;background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background: rgba(56,87,26,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>All bidding units</span></div></td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_active'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td>\n";
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

	<form autocomplete="off">
		<table class="options" cellspacing=4 cellpadding=4 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;' colspan='4'>
					Existing Mechs/BAs: <select required name='existingMechs' id='existingMechs' size='1' onchange="" style='width:400px;'>
						<option value="0"><<< Select a Mech/BA >>></option>
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

			echo "						<option value=".$entryValue.">".$entryString."</option>\n";
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
					<a href='#' onClick='assignMech();'><i class='fas fa-plus-square'></i></a>
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
		echo "				<td colspan='3'>Delete selected Mech/BA from Hangar (!)</td>\n";
		echo "				<td align='right'>\n";
		echo "					<a href='#' onClick='deleteStoredMech();'><i class='fas fa-minus-square'></i></a>\n";
		echo "				</td>\n";
		echo "			</tr>\n";
	}
?>
		</table>
	</form>
</body>

</html>
