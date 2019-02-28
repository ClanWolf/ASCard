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
	$pimage = $_SESSION['playerimage'];

	$s = isset($_GET["s"]) ? $_GET["s"] : "";
	$d = isset($_GET["d"]) ? $_GET["d"] : "";

	if ($s=="1") {
		// save new user
		$newplayername = isset($_GET["npn"]) ? $_GET["npn"] : "";
		$newplayeremail = isset($_GET["npe"]) ? $_GET["npe"] : "";
		$newplayerpassword = isset($_GET["npp"]) ? $_GET["npp"] : "";

		$hashedpw = password_hash($newplayerpassword, PASSWORD_DEFAULT);

		$sql_asc_checkusername = "SELECT SQL_NO_CACHE * FROM asc_player where username=".$newplayername.";";
		$result_asc_checkusername = mysqli_query($conn, $sql_asc_checkusername);
		if (mysqli_num_rows($result_asc_checkusername) > 0) {
			// a user with that name already exists
		} else {
			// new user can be inserted
			$sql = "INSERT INTO asc_player (name, email, password, image) VALUES ('".$newplayername."', '".$newplayeremail."', '".$hashedpw."', '".$newplayername.".png')";
			if (mysqli_query($conn, $sql)) {
				// Success
				$newplayerid = mysqli_insert_id($conn);

				$sqlinsertunit = "INSERT INTO asc_unit (factionid, forcename, playerid) VALUES ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Alpha', ".$newplayerid."), ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Bravo', ".$newplayerid."), ";
				$sqlinsertunit = $sqlinsertunit . "(1, 'Charlie', ".$newplayerid.")";
				if (mysqli_query($conn, $sqlinsertunit)) {
					// Success inserting units for new player
				} else {
					// Error
					echo "Error: " . $sqlinsertunit . "<br>" . mysqli_error($conn);
				}
				echo "<meta http-equiv='refresh' content='0;url=./gui_createplayer.php'>";
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
			echo "<meta http-equiv='refresh' content='0;url=./gui_createplayer.php'>";
		} else {
			// Error
			echo "Error: " . $sqldelete . "<br>" . mysqli_error($conn);
		}

		$sqldeleteunits = "DELETE FROM asc_unit WHERE playerid = ".$deleteplayerid;
		if (mysqli_query($conn, $sqldeleteunits)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sqldeleteunits . "<br>" . mysqli_error($conn);
		}

		// TODO: Delete units of this player
		// TODO: Delete mechs belonging to those units
		// TODO: Delete pilots belonging to those mechs
	}
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Player creator</title>
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

		function saveNewPlayer(id, playerimagetodelete) {
			if (id==0) {
				// Create new player
				var npn = document.getElementById('NewPlayerName').value;
				var npe = document.getElementById('NewPlayerEMail').value;
				var npp = document.getElementById('NewPlayerPassword').value;
				var nppc = document.getElementById('NewPlayerPasswordConfirm').value;

				if ("" == npn) {
					alert("Name may not be empty!");
				}
				if (npp == nppc) {
					// alert("Saving new player: " + id + " (" + NewPlayerName + ")");
					var url = "./gui_createplayer.php?s=1&npn=" + npn;
					url = url + "&npe=" + npe;
					url = url + "&npp=" + npp;
					window.location = url;
				} else {
					alert("Passwords do not match!");
				}
			} else {
				// Delete existing player
				// alert(playerimagetodelete);
				var url = "./gui_createplayer.php?d=1&deleteplayerid=" + id + "&playerimagetodelete=" + playerimagetodelete;
				window.location = url;
			}
		}
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
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="20%"><div class='mechselect_button_active'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<form>
		<table class="options" cellspacing="2" cellpadding="2" border=0px>
			<tr>
				<td colspan="2" nowrap align="left">New player</td>
				<td colspan="1" align="right">Name:</td>
				<td colspan="1">
					
					<!-- autocomplete deactivate hints -->
					<!-- https://gist.github.com/runspired/b9fdf1fa74fc9fb4554418dea35718fe -->
					<!-- <input autocomplete="off" required type="text" id="NewPlayerName" name="NewPlayerName" style="width: 220px;"><br> -->
					<!-- <input autocomplete="nope" required type="text" id="NewPlayerName" style="width: 220px;"><br> -->

					<input autocomplete="off" required type="text" id="NewPlayerName" style="width: 220px;"><br>
				</td>
				<td width='10px'>
					<span style='font-size:16px;'>
						<a href="#" onClick="saveNewPlayer(0, 'none');"><i class="fa fa-fw fa-plus-square"></i></a>
					</span>
				</td>
			</tr>
			<tr>
				<td width='10px' colspan="2" rowspan="3" valign="top" align="left">
					<img src='./images/pilots/000_no_avatar.png' width='60px' height='60px'>
				</td>
				<td colspan="1" align="right">Email:</td>
				<td colspan="1">
					<input autocomplete="off" required type="text" id="NewPlayerEMail" style="width: 220px;"><br>
				</td>
				<td width='10px'></td>
			</tr>
			<tr>
				<td colspan="1" align="right">Password:</td>
				<td colspan="1">
					<input autocomplete="new-password" required type="password" id="NewPlayerPassword" style="width: 220px;"><br>
				</td>
				<td width='10px'></td>
			</tr>
			<tr>
				<td colspan="1" align="right">Confirm:</td>
				<td colspan="1">
					<input autocomplete="new-password" required type="password" id="NewPlayerPasswordConfirm" style="width: 220px;"><br>
				</td>
				<td width='10px'></td>
			</tr>
			<tr><td colspan="6"><hr></td></tr>

<?php
	if (!($stmt = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player ORDER BY playerid"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if ($stmt->execute()) {
		$res = $stmt->get_result();
		while ($row = $res->fetch_assoc()) {
			$filename = "./images/player/".$row['image'];

			echo "			<tr>\n";
			echo "				<td nowrap class='datalabel' style='text-align:left;';>" . $row['playerid'] . "</td>\n";
			echo "				<td nowrap class='datalabel' style='text-align:left;vertical-align:middle;' valign='middle'>\n";
			if (file_exists($filename)) {
				echo "						<img src='./images/player/".$row['image']."' width='30px' height='30px'>\n";
			} else {
				echo "						<img src='./images/pilots/000_no_avatar.png' width='30px' height='30px'>\n";
				copy("./images/pilots/000_no_avatar.png", "./images/player/".$row['image']);
			}
			echo "				</td>\n";
			echo "				<td nowrap class='datalabel' style='text-align:left;';>" . $row['name'] . "</td>\n";
			echo "				<td nowrap class='datalabel' style='text-align:left;';>" . $row['email'] . "</td>\n";
			if ($row['playerid'] != "1" && $row['playerid'] != "2") {
				echo "				<td width='10px'>\n";
				echo "					<span style='font-size:16px;'>\n";
				echo "						<a href='#' onClick='saveNewPlayer(".$row['playerid'].",\"".$row['image']."\");'><i class='fa fa-fw fa-minus-square'></i></a>\n";
				echo "					</span>\n";
				echo "				</td>\n";
			} else {
				echo "				<td width='10%'></td>\n";
			}
			echo "			</tr>\n";
		}
	}
?>

		</table>
	</form>

</body>

</html>
