<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 12");
	}
	// Get data on units from db
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$s = isset($_GET["s"]) ? $_GET["s"] : "";
	$d = isset($_GET["d"]) ? $_GET["d"] : "";

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	if ($s=="1") {
		// save new user
		$newplayername = isset($_GET["npn"]) ? $_GET["npn"] : "";
		$newplayerpassword = isset($_GET["npp"]) ? $_GET["npp"] : "";

		$hashedpw = password_hash($newplayerpassword, PASSWORD_DEFAULT);

		$sql_asc_checkusername = "SELECT SQL_NO_CACHE * FROM asc_player where username=".$newplayername.";";
		$result_asc_checkusername = mysqli_query($conn, $sql_asc_checkusername);
		if (mysqli_num_rows($result_asc_checkusername) > 0) {
			// a user with that name already exists
		} else {
			// new user can be inserted
			$sql = "INSERT INTO asc_player (name, password, image) VALUES ('".$newplayername."', '".$hashedpw."', '".$newplayername.".png')";
			if (mysqli_query($conn, $sql)) {
				// Success
				$newplayerid = mysqli_insert_id($conn);

				$sqlinsertunit = "INSERT INTO asc_unit (factionid, forcename, playerid) VALUES ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Command', ".$newplayerid."), ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Battle', ".$newplayerid."), ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Striker', ".$newplayerid.")";
				if (mysqli_query($conn, $sqlinsertunit)) {
					// Success inserting units for new player
				} else {
					// Error
					echo "Error: " . $sqlinsertunit . "<br>" . mysqli_error($conn);
				}

				// Create options entry for new user
				$sqlinsertoptions = "INSERT INTO asc_options (playerid, option1, option2, option3, UseMULImages) VALUES ";
				$sqlinsertoptions = $sqlinsertoptions . "(".$newplayerid.", 1, 1, 1, 0)";
				if (mysqli_query($conn, $sqlinsertoptions)) {
					// Success inserting units for new player
				} else {
					// Error
					echo "Error: " . $sqlinsertoptions . "<br>" . mysqli_error($conn);
				}

				echo "<meta http-equiv='refresh' content='0;url=./gui_create_player.php'>";
			} else {
				// Error
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
	} else if ($d=="1") {
		// delete existing user
		$deleteplayerid = isset($_GET["deleteplayerid"]) ? $_GET["deleteplayerid"] : "";
		$playerimagetodelete = isset($_GET["playerimagetodelete"]) ? $_GET["playerimagetodelete"] : "";

		$sqldelete = "DELETE FROM asc_player WHERE playerid = ".$deleteplayerid;
		if (mysqli_query($conn, $sqldelete)) {
			// Success
			// delete avatar file
			unlink("./images/player/".$playerimagetodelete);
		} else {
			// Error
			echo "Error: " . $sqldelete . "<br>" . mysqli_error($conn);
		}

		$playersUnits = array();
		$sql_asc_findunits = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid=".$deleteplayerid.";";
		$result_asc_findunits = mysqli_query($conn, $sql_asc_findunits);
		if (mysqli_num_rows($result_asc_findunits) > 0) {
			// this user has units. Get unit ids to clean up mechs and pilots
			while ($rowUnit = $result_asc_findunits->fetch_assoc()) {
				array_push($playersUnits, $rowUnit['unitid']);
			}
		}

		foreach ($playersUnits as &$unitid) {
			$sqlupdateunit = "update asc_assign set unitid=null where unitid = ".$unitid;
			if (mysqli_query($conn, $sqlupdateunit)) {
				// Success
			} else {
				// Error
				echo "Error: " . $sqldeleteunits . "<br>" . mysqli_error($conn);
			}
		}

		$sqldeleteunits = "DELETE FROM asc_unit WHERE playerid = ".$deleteplayerid;
		if (mysqli_query($conn, $sqldeleteunits)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteunits . "<br>" . mysqli_error($conn);
		}

		$sqldeleteoptions = "DELETE FROM asc_options WHERE playerid = ".$deleteplayerid;
		if (mysqli_query($conn, $sqldeleteoptions)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteoptions . "<br>" . mysqli_error($conn);
		}

		echo "<meta http-equiv='refresh' content='0;url=./gui_create_player.php'>";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Player creator</title>
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

	<script type="text/javascript" src="./scripts/jquery-3.6.1.min.js"></script>
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
		.box {
			width: 80%;
			background-color: #transparent;
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
		.scroll-pane {
			width: 100%;
			height: 200px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 200px;
		}
	</style>
</head>

<body>
	<script>
		$(function() {
			$('.scroll-pane').jScrollPane();
		});
		$(document).ready(function() {
			$("#cover").hide();
		});

		function saveNewPlayer(id, playerimagetodelete) {
			if (id==0) {
				// Create new player
				var npn = document.getElementById('NewPlayerName').value;
				var npp = document.getElementById('NewPlayerPassword').value;
				var nppc = document.getElementById('NewPlayerPasswordConfirm').value;

				if ("" == npn) {
					alert("Name may not be empty!");
					return;
				}
				if (npp == nppc) {
					// alert("Saving new player: " + id + " (" + NewPlayerName + ")");
					var url = "./gui_create_player.php?s=1&npn=" + npn;
					url = url + "&npp=" + npp;
					window.location = url;
				} else {
					alert("Passwords do not match!");
				}
			} else {
				// Delete existing player
				// alert(playerimagetodelete);
				var url = "./gui_create_player.php?d=1&deleteplayerid=" + id + "&playerimagetodelete=" + playerimagetodelete;
				window.location = url;
			}
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
				<!--
				<td nowrap onclick="location.href='./gui_finalize_round.php'" width="100px" style="width: 100px;background: rgba(56,87,26,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./gui_finalize_round.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				-->
				<td nowrap onclick="location.href='./gui_finalize_round.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>All bidding units</span></div></td>
				<td style="width:5px;">&nbsp;</td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_mech.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_mech.php'>ADD</a><br><span style='font-size:16px;'>Create a Mech/BA</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_active'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width:5px;">&nbsp;</td>
				<td style="width: 100px;"nowrap width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<form autocomplete="autocomplete_off_hack_xfr4!k">
		<table class="options" cellspacing="2" cellpadding="2" border=0px>
			<tr>
				<td colspan="2" class='datalabel' nowrap align="left">New player</td>
				<td colspan="1" class='datalabel' nowrap align="right">Name:</td>
				<td colspan="1" class='datalabel'>
					
					<!-- autocomplete deactivate hints -->
					<!-- https://gist.github.com/runspired/b9fdf1fa74fc9fb4554418dea35718fe -->
					<!-- <input autocomplete="off" required type="text" id="NewPlayerName" name="NewPlayerName" style="width: 220px;"><br> -->
					<!-- <input autocomplete="nope" required type="text" id="NewPlayerName" style="width: 220px;"><br> -->

					<input autocomplete="autocomplete_off_hack_xfr4!k" required type="text" id="NewPlayerName" style="width: 220px;"><br>
				</td>
				<td class='datalabel' width='10px'>
					<span style='font-size:16px;'>
						<a href="#" onClick="saveNewPlayer(0, 'none');"><i class="fas fa-plus-square"></i></a>
					</span>
				</td>
			</tr>
			<tr>
				<td class='datalabel' width='10px' colspan="2" rowspan="2" valign="top" align="left">
					<img src='./images/pilots/000_no_avatar.png' width='60px' height='60px'>
				</td>
				<td class='datalabel' colspan="1" align="right">PW:</td>
				<td class='datalabel' colspan="1">
					<input autocomplete="new-password" required type="password" id="NewPlayerPassword" style="width: 220px;"><br>
				</td>
				<td class='datalabel' width='10px'></td>
			</tr>
			<tr>
				<td class='datalabel' colspan="1" align="right">Confirm PW:</td>
				<td class='datalabel' colspan="1">
					<input autocomplete="new-password" required type="password" id="NewPlayerPasswordConfirm" style="width: 220px;"><br>
				</td>
				<td width='10px'></td>
			</tr>
			<tr><td class='datalabel' colspan="6"><hr></td></tr>
			<tr>
				<td colspan="5">
					<div class="scroll-pane">
						<table cellspacing="2" cellpadding="2" border="0px" width="100%">
<?php
	if (!($stmt = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player ORDER BY playerid"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if ($stmt->execute()) {
		$res = $stmt->get_result();
		while ($row = $res->fetch_assoc()) {
			$filename = "./images/player/".$row['image'];

			echo "							<tr>\n";
			echo "								<td nowrap class='datalabel' style='text-align:left;';><a href='gui_edit_player.php?playerid=".$row['playerid']."'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;&nbsp;".$row['playerid']."</td>\n";
			echo "								<td nowrap class='datalabel' style='text-align:left;vertical-align:middle;' valign='middle'>\n";
			if (file_exists($filename)) {
				echo "										<img src='./images/player/".$row['image']."' width='30px' height='30px'>\n";
			} else {
				echo "										<img src='./images/pilots/000_no_avatar.png' width='30px' height='30px'>\n";
				copy("./images/pilots/000_no_avatar.png", "./images/player/".$row['image']);
			}
			echo "								</td>\n";
			echo "								<td nowrap class='datalabel' style='text-align:left;' colspan='2'>" . $row['name'] . "</td>\n";
			if ($row['playerid'] != "1" && $row['playerid'] != "2" && $row['playerid'] != "3") {
				echo "								<td width='10px' nowrap>\n";
				echo "									<span style='font-size:16px;'>\n";
				if ($playMode) {
					echo "										\n";
				} else {
					if ($pid == 2) { // Meldric (only admin may delete player)
						echo "										<a href='#' onClick='saveNewPlayer(".$row['playerid'].",\"".$row['image']."\");'><i class='fas fa-minus-square'></i></a>\n";
					} else {
						echo "										<i class=\"fas fa-ban\"></i>\n";
					}
				}
				echo "									</span>\n";
				echo "								</td>\n";
			} else {
				echo "								<td width='10%'></td>\n";
			}
			echo "							</tr>\n";
		}
	}
?>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
