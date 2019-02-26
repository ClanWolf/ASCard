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
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

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
	echo "<div id='player_image'>";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>";
	echo "</div>";
?>

	<div id="cover"></div>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="20%"><div class='mechselect_button_active'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<table align="center" cellspacing=2 cellpadding=2 border=0px>
		<tr>

<?php
	echo "<td nowrap style='width:200px;height:70px;' class='mechselect_button_active'>".$pname."</td>";
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

			$sql_asc_checkunitassignments = "SELECT SQL_NO_CACHE * FROM asc_assign where unitid=".$unitidSelected.";";
			$result_asc_checkunitassignments = mysqli_query($conn, $sql_asc_checkunitassignments);
			if (mysqli_num_rows($result_asc_checkunitassignments) > 0) {
				echo "<td nowrap style='width:200px;height:70px;' onclick='location.href=\"gui_unit.php?unit=".$unitidSelected."\"' class='unitselect_button_normal'>";
				echo "<a href='gui_unit.php?unit=".$unitidSelected."'>".$forcenameSelected."</a><br>";
				echo "<span style='font-size:16px;'>Tap to inspect</span>";
				echo "</td>";
			} else {
				echo "<td nowrap style='background-color:#444444;width:200px;height:70px;' class='mechselect_button_active'>";
				echo $forcenameSelected."<br>";
				echo "<span style='font-size:16px;'>Empty</span>";
				echo "</td>";
			}
		}
	}
?>

		</tr>
		<tr>
			<td></td>
			<td nowrap style="text-align:center;width:200px;height:30px;background-color:#transparent;">
				<a href="gui_createunit.php?unitid=1&unitname=Alpha"><i class="fa fa-fw fa-plus-square"></i></a>
			</td>
			<td nowrap style="text-align:center;width:200px;height:30px;background-color:#transparent;">
				<a href="gui_createunit.php?unitid=1&unitname=Bravo"><i class="fa fa-fw fa-plus-square"></i></a>
			</td>
			<td nowrap style="text-align:center;width:200px;height:30px;background-color:#transparent;">
				<a href="gui_createunit.php?unitid=1&unitname=Charlie"><i class="fa fa-fw fa-plus-square"></i></a>
			</td>
		</tr>
		<tr>
			<td></td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%' cellspacing=0 cellpadding=0 border=0px>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%'>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%'>
					<tr>
						<td nowrap width="99%" valign='middle' align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td></td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%' cellspacing=0 cellpadding=0 border=0px>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%'>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%'>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td></td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%' cellspacing=0 cellpadding=0 border=0px>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
			<td nowrap style="width:200px;height:50px;background-color:#444444;" class='mechselect_button_active'>
				<table width='100%'>
					<tr>
						<td nowrap width="99%" align='left' style="background-color:#444444;text-align:left;" class='mechselect_button_active'>
							<span style='font-size:16px;'>Timberwolf</span>
						</td>
						<td nowrap width="1%" style="background-color:#444444;text-align:right;" class='mechselect_button_active'>
							<span style='font-size:16px;'>
								<a href=""><i class="fa fa-fw fa-minus-square"></i></a>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
		</tr>
		<tr>
			<td></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
			<td nowrap style="width:200px;height:50px;background-color:#353535;" class='mechselect_button_active'></td>
		</tr>
	</table>
</body>

</html>
