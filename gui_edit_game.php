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
		//die("Check position 10");
	}
	// Get data from db
	$pid    = filter_var($_SESSION['playerid'], FILTER_VALIDATE_INT);
	$gid    = filter_var($_SESSION['gameid'], FILTER_VALIDATE_INT);
	$hgid   = filter_var($_SESSION['hostedgameid'], FILTER_VALIDATE_INT);
	$pimage = htmlspecialchars($_SESSION['playerimage'], ENT_NOQUOTES);
	$pname  = htmlspecialchars($_SESSION['name'], ENT_NOQUOTES);

	$isAdmin    = filter_var($_SESSION['isAdmin'], FILTER_VALIDATE_BOOLEAN);
	$isGodAdmin = filter_var($_SESSION['isGodAdmin'], FILTER_VALIDATE_BOOLEAN);

	$opt1                   = filter_var($_SESSION['option1'], FILTER_VALIDATE_BOOLEAN);
	$opt2                   = filter_var($_SESSION['option2'], FILTER_VALIDATE_BOOLEAN);
	$opt3                   = filter_var($_SESSION['option3'], FILTER_VALIDATE_BOOLEAN);
	$opt4                   = filter_var($_SESSION['option4'], FILTER_VALIDATE_BOOLEAN);
	$hideNotOwnedUnit       = $opt1;
	$showplayerdata_topleft = $opt2;
	$playMode               = $opt3;
	$showDistancesHexes     = $opt4;

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			$CURRENTROUND = $row["round"];
		}
	}

	$sql_asc_game = "SELECT SQL_NO_CACHE * FROM asc_game where ownerPlayerId = " . $pid . ";";
	$result_asc_game = mysqli_query($conn, $sql_asc_game);
	if (mysqli_num_rows($result_asc_game) > 0) {
		while($row = mysqli_fetch_assoc($result_asc_game)) {
			$GAMEID = $row["gameid"];
			$OWNERPLAYERID = $row["ownerPlayerId"];
			$ACCESSCODE = $row["accessCode"];
			$LOCKED = $row["locked"];
			$TITLE = $row["title"];
			$BACKGROUND = $row["background"];
			$GAMEERA = $row["era"];
			$GAMEYEAR = $row["yearInGame"];
		}
	} else {
		// this player does not have a game yet
		if (endsWith($pname, 's') || endsWith($pname, 'S')) {
			$background = $pname . " game";
		} else {
			$background = $pname . "s game";
		}
		$title = $background;
		$accesscodeGenerated = substr(str_shuffle("0123456789"), 0, 4);
		$sqlinsertgame = "INSERT INTO asc_game (ownerPlayerId, accessCode, locked, title, background) VALUES ";
		$sqlinsertgame = $sqlinsertgame . "(".$pid.", '".$accesscodeGenerated."', true, '".$title."', '".$background."')";
		if (mysqli_query($conn, $sqlinsertgame)) {
			// Success inserting new game for this player
			$GAMEID = mysqli_insert_id($conn);
			$OWNERPLAYERID = $pid;
			$ACCESSCODE = $accesscodeGenerated;
			$LOCKED = 1;
			$TITLE = $title;
			$BACKGROUND = $background;
			$GAMEERA = 'ALL';    // Default value in asc_game
			$GAMEYEAR = '3025';  // Default value in asc_game

			$hgid = $GAMEID;
			$_SESSION['hostedgameid'] = $hgid;

			$sqlupdateplayer = "UPDATE asc_player set hostedgameid = ".$hgid.", gameid = ".$hgid.", teamid=1, opfor=0, active_ingame=1, bid_pv=-1, bid_tonnage=-1, bid_winner=0, round=1 WHERE playerid=".$pid;
			if (mysqli_query($conn, $sqlupdateplayer)) {
				// Success updating player with new gameid for his own game
			} else {
				// Error
				echo "Error: " . $sqlupdateplayer . "<br>" . mysqli_error($conn);
			}
		} else {
			// Error
			echo "Error: " . $sqlinsertgame . "<br>" . mysqli_error($conn);
		}
	}

	$array_joinedPlayers = array();
	$array_joinedPlayersIds = array();
	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player;";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		$i = 1;
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			if ($hgid == $row["gameid"]) {
				// this player is joined in the game of the currently logged in player
				$array_joinedPlayers[$i] = $row["name"];
				$array_joinedPlayersIds[$i] = $row["playerid"];
				$i++;
				//echo $row["name"];
			}
		}
	}

	$array_availableGamesToJoin = array();
	$array_availableGamesToJoinId = array();
	$array_availableGamesToJoinAccessCode = array();
	$sql_asc_gameslist = "SELECT SQL_NO_CACHE * FROM asc_game order by 1 asc;";
	$result_asc_gameslist = mysqli_query($conn, $sql_asc_gameslist);
	if (mysqli_num_rows($result_asc_gameslist) > 0) {
		$ii = 0;
		while($rowGamesList = mysqli_fetch_assoc($result_asc_gameslist)) {
			$kgameid = $rowGamesList["gameid"];
			$kownerplayerid = $rowGamesList["ownerPlayerId"];
			$kaccesscode = $rowGamesList["accessCode"];
			$klocked = $rowGamesList["locked"];
			$ktitle = $rowGamesList["title"];
			$kbackground = $rowGamesList["background"];

			if (!$klocked) {
				$array_availableGamesToJoin[$ii] = $ktitle . " (" . $kgameid . ")";
				$array_availableGamesToJoinId[$ii] = $kgameid;
				$array_availableGamesToJoinAccessCode[$ii] = $kaccesscode;
				$ii++;
			}
		}
	}

	function endsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		if( !$length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Game creator</title>
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

	<link rel="manifest" href="/app/ascard.webmanifest">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/editorstyles.css">
	<link rel="stylesheet" type="text/css" href="./styles/jquery.jscrollpane.css">
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
		.scroll-pane {
			width: 100%;
			height: 180px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 100px;
		}
	</style>
</head>

<body>
	<script>
		$(function() {
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			$('.scroll-pane').jScrollPane();
		});
		$(document).ready(function() {
			$("#cover").hide();
		});
	</script>

	<div id="cover"></div>

	<iframe name="pollframe" id="iframe_serverpoll" src="server_poll.php"></iframe>
	<iframe name="saveframe" id="iframe_save"></iframe>
	<script type="text/javascript" src="./scripts/log_enable.js"></script>

	<script>
<?php
	echo "		var lockedStatus = $LOCKED;\n";
?>
		function randomIntFromInterval(min, max) { // min and max included
			return Math.floor(Math.random() * (max - min + 1) + min);
		}
		$(document).ready(function() {
			$("#cover").hide();
		});
		function saveGameInfo(gameId) {
			var gt = document.getElementById("GameTitle").value;
			var gbg = document.getElementById("GameBackground").value;
			var gy = document.getElementById("GameYear").value;
			var ge = document.getElementById("GameEra").value;
			var url="./save_game_info.php?gid="+gameId+"&gt="+encodeURIComponent(gt)+"&gbg="+encodeURIComponent(gbg)+"&gy="+encodeURIComponent(gy)+"&ge="+encodeURIComponent(ge);
			window.frames["saveframe"].location.replace(url);
		}
		function saveGameLock(gameId, locked) {
			var newLockedStatus = 1;
			if (lockedStatus == 1) {
				newLockedStatus = 0;
			}
			if (newLockedStatus == 1) {
				lockedStatus = 1;
				document.getElementById("lockstatusicon").innerHTML = "<i class='fa-solid fa-lock'>";
			} else {
				lockedStatus = 0;
				document.getElementById("lockstatusicon").innerHTML = "<i class='fa-solid fa-lock-open'>";
			}
			var url="./save_game_lock.php?gid=" + gameId + "&locked=" + newLockedStatus;
			window.frames["saveframe"].location.replace(url);
		}
		function saveGameAccessCode(gameId) {
			const rndInt = randomIntFromInterval(1000, 9999);
			document.getElementById("accesscode").innerHTML = rndInt;
			var url="./save_game_accesscode.php?gid="+gameId+"&rndint="+rndInt;
			window.frames["saveframe"].location.replace(url);
		}
		function resetGameForPlayer(gameId, playerId, leaveGame) {
			var url="./save_game_reset.php?gid="+gameId+"&pid="+playerId+"&leaveCurrentGame="+leaveGame;
			window.frames["saveframe"].location.replace(url);
		}
		function joinGame(playerId) {
			gameToJoinId = document.getElementById("gameToJoin").value;
			accessCode = document.getElementById("AccessCode").value;
			var url="./save_game_reset.php?gid="+gameToJoinId+"&pid="+playerId+"&leaveCurrentGame=0&joinGame=1&accessCode="+accessCode;

			let inputCheckedOk = true;
			if (gameToJoinId == "") {
				console.log("Error game");
				document.getElementById("gameToJoin").style.background = "#AA0000";
				inputCheckedOk = false;
			}
			if (accessCode == "" || accessCode.length != 4) {
				console.log("Error access code");
				document.getElementById("AccessCode").style.background = "#AA0000";
				inputCheckedOk = false;
			}
			if (inputCheckedOk) {
				window.frames["saveframe"].location.replace(url);
			}
		}

		// Reload the polling iFrame every 2 seconds
		(function(){
		    document.getElementById("iframe_serverpoll").src="server_poll.php";
		    setTimeout(arguments.callee, 3000);
		})();
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
				<td nowrap onclick="location.href='./gui_edit_game.php'" style="width: 100px;background:rgba(81,125,37,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#eee;'>&nbsp;&nbsp;&nbsp;G<?php echo $gid ?>&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td style="width:5px;">&nbsp;</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>" class='menu_button_normal'><a href='./gui_select_unit.php'>ROSTER</a></td>
				<td style="width:5px;">&nbsp;</td>
<?php
	if ($playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_select_formation.php'\" width=".$buttonWidth." class='menu_button_normal'><a href='./gui_select_formation.php'>CHALLENGE</a></td><td style='width:5px;'>&nbsp;</td>\n";
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

	<div id="header">
		<table align="center" class="options" cellspacing="4" cellpadding="4" border="0px" width="65%">
<?php
		if ($gid != $hgid) {
			echo "			<tr style='display:none;'>\n";
		} else {
			echo "			<tr>\n";
		}
?>
				<td valign="top" width="70%">
					<form>
						<table border="0" cellspacing="2" cellpadding="2">
							<tr>
								<td class='datalabel' nowrap colspan="1" align="left">
								<?php if ($LOCKED == 1) {
									echo "<a href='#' onClick='saveGameLock(".$hgid.", 0);'><span id='lockstatusicon'><i class='fa-solid fa-lock'></i></span></a>";
								} else {
									echo "<a href='#' onClick='saveGameLock(".$hgid.", 1);'><span id='lockstatusicon'><i class='fa-solid fa-lock-open'></i></span></a>";
								} ?>
								</td>
								<td colspan="4" class='datalabel' nowrap align="left">
									<input onchange="javascript:saveGameInfo(<?php echo $hgid ?>);" type="text" id="GameTitle" style="width:100%;">
									<script type="text/javascript">document.getElementById("GameTitle").setAttribute('value','<?php echo $TITLE; ?>');</script>
								</td>
								<td colspan="1" class='datalabel' nowrap align="right">
									[ID: <?php echo $hgid; ?>]
								</td>
							</tr>

							<tr>
								<td rowspan="4"></td>
								<td colspan="5" class='datalabel' nowrap align="left">
										<input onchange="javascript:saveGameInfo(<?php echo $hgid ?>);" type="text" id="GameBackground" style="width:100%;">
										<script type="text/javascript">document.getElementById("GameBackground").setAttribute('value','<?php echo $BACKGROUND; ?>');</script>
								</td>
							</tr>

							<tr>
								<td colspan="6">&nbsp;</td>
							</tr>

							<tr>
								<td colspan="1" class='datalabel' nowrap align="left">
									Era:
								</td>
								<td colspan="2" class='datalabel' nowrap align="left">
									<select required style='width:100%;' name='GameEra' id='GameEra' size='1' onchange="javascript:saveGameInfo(<?php echo $hgid ?>);">
										<option value="0" selected="selected">ALL</option>
										<option value="9">2005-2570: AGE OF WAR</option>
										<option value="10">2571-2780: STAR LEAGUE</option>
										<option value="11">2781-2900: EARLY SUCCESSION WARS</option>
										<option value="255">2901-3019: LATE SUCCESSION WARS - LOSTECH</option>
										<option value="256">3020-3049: LATE SUCCESSION WARS - RENAISSANCE</option>
										<option value="13">3050-3061: CLAN INVASION</option>
										<option value="247">3052-3067: CIVIL WAR</option>
										<option value="14">3068-3080: JIHAD</option>
										<option value="15">3081-3100: EARLY REPUBLIC</option>
										<option value="254">3101-3130: LATE REPUBLIC</option>
										<option value="16">3131-3150: DARK AGE</option>
										<option value="257">3151-9999: ILCLAN</option>
									</select>
									<script type="text/javascript">
										     if ('<?php echo $GAMEERA; ?>' == '0')   { document.getElementById('GameEra').selectedIndex = 0;  } // ALL
										else if ('<?php echo $GAMEERA; ?>' == '9')   { document.getElementById('GameEra').selectedIndex = 1;  } // 2005-2570: AGE OF WAR
										else if ('<?php echo $GAMEERA; ?>' == '10')  { document.getElementById('GameEra').selectedIndex = 2;  } // 2571-2780: STAR LEAGUE
										else if ('<?php echo $GAMEERA; ?>' == '11')  { document.getElementById('GameEra').selectedIndex = 3;  } // 2781-2900: EARLY SUCCESSION WARS
										else if ('<?php echo $GAMEERA; ?>' == '255') { document.getElementById('GameEra').selectedIndex = 4;  } // 2901-3019: LATE SUCCESSION WARS - LOSTECH
										else if ('<?php echo $GAMEERA; ?>' == '256') { document.getElementById('GameEra').selectedIndex = 5;  } // 3020-3049: LATE SUCCESSION WARS - RENAISSANCE
										else if ('<?php echo $GAMEERA; ?>' == '13')  { document.getElementById('GameEra').selectedIndex = 6;  } // 3050-3061: CLAN INVASION
										else if ('<?php echo $GAMEERA; ?>' == '247') { document.getElementById('GameEra').selectedIndex = 7;  } // 3050-3061: CIVIL WAR
										else if ('<?php echo $GAMEERA; ?>' == '14')  { document.getElementById('GameEra').selectedIndex = 8;  } // 3068-3080: JIHAD
										else if ('<?php echo $GAMEERA; ?>' == '15')  { document.getElementById('GameEra').selectedIndex = 9;  } // 3081-3100: EARLY REPUBLIC
										else if ('<?php echo $GAMEERA; ?>' == '254') { document.getElementById('GameEra').selectedIndex = 10; } // 3101-3130: LATE REPUBLIC
										else if ('<?php echo $GAMEERA; ?>' == '16')  { document.getElementById('GameEra').selectedIndex = 11; } // 3131-3150: DARK AGE
										else if ('<?php echo $GAMEERA; ?>' == '257') { document.getElementById('GameEra').selectedIndex = 12; } // 3151-9999: ILCLAN

										// document.getElementById('GameEra').value = '<?php echo $GAMEERA; ?>';
									</script>
								</td>
								<td colspan="1" class='datalabel' nowrap align="left">
									Year:
								</td>
								<td colspan="1" class='datalabel' nowrap align="center">
									<input onchange="javascript:saveGameInfo(<?php echo $hgid ?>);" type="text" id="GameYear" style="width:100%;text-align:center;" align="center">
									<script type="text/javascript">document.getElementById("GameYear").setAttribute('value','<?php echo $GAMEYEAR; ?>');</script>
								</td>
							</tr>

							<tr>
								<td colspan="6">&nbsp;</td>
							</tr>

							<tr>
								<td nowrap align="left" width="3%"><a href='#' onClick='javascript:saveGameAccessCode(<?php echo $gid ?>);'><i class="fa-solid fa-rotate-right"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td class='datalabel' nowrap align="left" width="3%">Code:</td>
								<td class='datalabel' nowrap align="left" width="94%" colspan="3" id="accesscode">
									<?php echo $ACCESSCODE; ?>
								</td>
								<td class='datalabel' nowrap align="right" width="94%">
									<a href='#' onClick='saveGameInfo(<?php echo $hgid ?>);'><i class='fa-solid fa-save'></i></a>&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
						</table>
					</form>
				</td>
				<td width="15px;">&nbsp;&nbsp;&nbsp;</td>
				<td class='datalabel' nowrap valign="top" align="left" width="30%" rowspan="1">
					<div class="scroll-pane">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php
	if (count($array_joinedPlayers) > 1) {
		echo "							<tr><td class='datalabel'>".$pname."</td><td nowrap align='right' width='3%'></td></tr>\n";
	} else {
		echo "							<tr><td class='datalabel'>(empty)</td><td nowrap align='right' width='3%'></td></tr>\n";
	}
	for($i=1; $i <= count($array_joinedPlayers); $i++) {
		$joinedPlayerName = $array_joinedPlayers[$i];
		$joinedPlayerId = $array_joinedPlayersIds[$i];

		if ($pname != $joinedPlayerName) {
			echo "							<tr><td class='datalabel'>".$joinedPlayerName."</td><td nowrap align='right' width='3%'>&nbsp;&nbsp;&nbsp;<span style='font-size:16px;color:#ddd;' onclick='javascript:resetGameForPlayer(".$hgid.",\"".$joinedPlayerId."\",1);'><i class='fas fa-minus-square'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>\n";
		}
	}
?>
						</table>
					</div>
				</td>
			</tr>
<?php
		if ($gid != $hgid) {
			echo "			<tr style='display:none;'><td colspan='3'><hr></td></tr>\n";
		} else {
			echo "			<tr><td colspan='3'><hr></td></tr>\n";
		}
?>
			<tr>
				<td class='datalabel' colspan="3">
					<form autocomplete="autocomplete_off_hack_xfr4!k">
						<table cellspacing="0" cellpadding="0" border="0px" width="100%">
							<?php

//								echo "Player count : ".sizeOf($array_joinedPlayers)."<br>";
//								echo "gameid       : ".$gid."<br>";
//								echo "hostedid     : ".$hgid."<br>";
//								echo "[0]          : ".$array_joinedPlayers[0]."<br>";
//								echo "[1]          : ".$array_joinedPlayers[1]."<br>";
//								echo "[2]          : ".$array_joinedPlayers[2]."<br>";
//								echo "locked       : ".$LOCKED."<br>";

								if ($gid == $hgid) { // I am a member of my own hosted game, so I am joined nowhere else
									if (sizeOf($array_joinedPlayers) == 1) { // size must be one, because I am in my own game
										if ($LOCKED) {
											echo "							<tr>\n";
											echo "								<td width='5%' colspan='1' class='datalabel' nowrap align='left'>Join:</td>\n";
											echo "								<td width='60%' colspan='1' class='datalabel' nowrap align='left'>\n";
											echo "									<select required name='gameToJoin' id='gameToJoin' size='1' onchange='' style='width:100%;'>\n";

											for ($i661 = 0; $i661 < sizeof($array_availableGamesToJoin); $i661++) {
												echo "										<option value='".$array_availableGamesToJoinId[$i661]."'>".$array_availableGamesToJoin[$i661]."</option>\n";
											}

											echo "									</select>\n";
											echo "								</td>\n";
											echo "								<td width='5%' colspan='1' class='datalabel' nowrap align='right'>&nbsp;&nbsp;&nbsp;&nbsp;Code:</td>\n";
											echo "								<td width='25%' colspan='1' class='datalabel' nowrap align='center'><input autocomplete='autocomplete_off_hack_xfr4!k' required type='text' id='AccessCode' style='width: 100%;'></td>\n";
											echo "								<td width='5%' colspan='1' class='datalabel' nowrap align='right'><a href='#' onClick='joinGame(".$pid.");'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-plus-square'></i></a></td>\n";
											echo "							</tr>\n";
										} else {
											echo "							<tr>\n";
											echo "								<td colspan='5' class='datalabel' nowrap align='center'>You cannot join elsewhere!<br>Your game needs to be LOCKED and EMPTY.</td>\n";
											echo "							</tr>\n";
										}
									} else {
										echo "							<tr>\n";
										echo "								<td colspan='5' class='datalabel' nowrap align='center'>You cannot join elsewhere!<br>Your game needs to be LOCKED and EMPTY.</td>\n";
										echo "							</tr>\n";
									}
								} else {
									$sql_asc_game2 = "SELECT SQL_NO_CACHE * FROM asc_game where gameId = " . $gid . ";";
									$result_asc_game2 = mysqli_query($conn, $sql_asc_game2);
									if (mysqli_num_rows($result_asc_game2) > 0) {
										while($rowg2 = mysqli_fetch_assoc($result_asc_game2)) {
											$joinedGame_ACCESSCODE = $rowg2["accessCode"];
											$joinedGame_LOCKED = $rowg2["locked"];
											$joinedGame_TITLE = $rowg2["title"];
											$joinedGame_BACKGROUND = $rowg2["background"];
											$joinedGame_GAMEERA = $rowg2["era"];
											$joinedGame_GAMEYEAR = $rowg2["yearInGame"];
										}
									}
									echo "							<tr>\n";
									echo "								<td colspan='1' class='datalabel' nowrap align='left'>You are in:</td>\n";
									echo "								<td colspan='3' class='datalabel' nowrap align='left'>G".$gid.": ".$joinedGame_TITLE."</td>\n";
									if ($playMode) {
										echo "								<td colspan='1' class='datalabel' nowrap align='right'>&nbsp;</td>\n";
									} else {
										echo "								<td colspan='1' class='datalabel' nowrap align='right'><a href='#' onClick='javascript:resetGameForPlayer(".$gid.",".$pid.",1);'>Leave game&nbsp;&nbsp;&nbsp;<i class='fas fa-minus-square'></i></a></td>\n";
									}
									echo "							</tr>\n";
									echo "							<tr>\n";
									echo "								<td colspan='1' class='datalabel' nowrap align='left'></td>\n";
									echo "								<td colspan='4' class='datalabel' nowrap align='left'><br>".$joinedGame_BACKGROUND."</td>\n";
									echo "							</tr>\n";
									echo "              			<tr><td colspan='5'><hr></td></tr>\n";
									echo "							<tr>\n";
									echo "								<td colspan='5' class='datalabel' nowrap align='left'><ul style='margin:0px;'>";

									$op = "{{{host}}}{{{list}}}";
									$list = "";
									$sql_asc_players = "SELECT SQL_NO_CACHE * FROM asc_player WHERE gameid=".$gid." ORDER BY opfor ASC, name ASC;";
									$result_asc_players = mysqli_query($conn, $sql_asc_players);
									if (mysqli_num_rows($result_asc_players) > 0) {
										while($row = mysqli_fetch_assoc($result_asc_players)) {
											if ($row["hostedgameid"] == $gid) {
												$host = "								<li><i>".$row["name"]." (R".$row["round"].") - Host</i></li>";
												$op = str_replace("{{{host}}}",$host,$op);
											} else if ($row["opfor"] == 1) {
												$player = "								<li>".$row["name"]." (R".$row["round"].") - OpFor</li>";
												$list = $list.$player;
											} else {
												$player = "								<li>".$row["name"]." (R".$row["round"].")</li>";
												$list = $list.$player;
											}
										}
										$op = str_replace("{{{list}}}",$list,$op);
										echo $op;
									}

									echo "								</ul></td>\n";
									echo "							</tr>\n";
								}
							?>
						</table>
					</form>
				</td>
			</tr>

<?php
	if ($playMode) {
//		echo "			<tr><td colspan='3'><hr></td></tr>\n";
//		echo "			<tr>\n";
//		echo "				<td colspan='3'>\n";
//		echo "					&nbsp;\n";
//		echo "				</td>\n";
//		echo "			</tr>\n";
	} else {
		echo "			<tr><td colspan='3'><hr></td></tr>\n";
		echo "			<tr>\n";
		echo "				<td colspan='3'>\n";
		echo "					<table align='left' cellspacing='0' cellpadding='0' border='0px'>\n";
		echo "						<tr>\n";
		echo "							<td class='datalabel'>\n";
		echo "								<a href='#' onClick='javascript:resetGameForPlayer(".$gid.",".$pid.", 0);'>&nbsp;&nbsp;<i class='fas fa-fast-backward'></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>\n";
		echo "							</td>\n";
		echo "							<td align='left' class='datalabel'>RESET Game (Set round to 1 / Repair all units)</td>\n";
		echo "						</tr>\n";
		echo "					</table>\n";
		echo "				</td>\n";
		echo "			</tr>\n";
	}
?>
		</table>
	</div>

	<p align="center" class="footerInfo">Locked games will NOT show up to join! Access code is needed to join!</p>

</body>

</html>
