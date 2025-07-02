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
	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
	$hgid = $_SESSION['hostedgameid'];
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
		if (endsWith($pname, 's')) {
			$background = $pname . " game";
		} else {
			$background = $pname . "s game";
		}
		$title = $background;
		$accesscodeGenerated = substr(str_shuffle("0123456789"), 0, 4);
		$sqlinsertgame = "INSERT INTO asc_game (ownerPlayerId, accessCode, locked, title, background) VALUES ";
		$sqlinsertgame = $sqlinsertgame . "(".$pid.", '".$accesscodeGenerated."', false, '".$title."', '".$background."')";
		if (mysqli_query($conn, $sqlinsertgame)) {
			// Success inserting new game for this player
			$GAMEID = mysqli_insert_id($conn);
			$OWNERPLAYERID = $pid;
			$ACCESSCODE = $accesscodeGenerated;
			$LOCKED = 0;
			$TITLE = $title;
			$BACKGROUND = $background;
			$GAMEERA = 'SUCCESSION WARS';
			$GAMEYEAR = '3025';

			$sqlupdateplayer = "UPDATE asc_player set hostedgameid = ".$GAMEID." WHERE playerid=".$pid;
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

	$array_joinedUsers = array();
	$array_joinedUserIds = array();
	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player;";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		$i = 1;
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			if ($GAMEID == $row["gameid"]) {
				// this player is joined in the game of the currently logged in player
				$array_joinedUsers[$i] = $row["name"];
				$array_joinedUserIds[$i] = $row["playerid"];
				$i++;
			}
		}
	}

	$array_availableGamesToJoin = array();
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

			$array_availableGamesToJoin[$ii] = $ktitle . " (" . $kgameid . ")";
			$array_availableGamesToJoinAccessCode[$ii] = $kaccesscode;

			$ii++;
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

	<iframe name="saveframe" id="iframe_save"></iframe>

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
		function resetGame(playerId) {
			var url="./save_game_reset.php?pid=" + playerId;
			window.frames["saveframe"].location.replace(url);
		}
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
		function saveRemovedUserFromGame(gameId, userId) {
			// alert(gameId + " --- " + userId);
			var url="./save_game_reset.php?gid="+gameId+"&pId="+userId+"&leaveCurrentGame=1";
			window.frames["saveframe"].location.replace(url);
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
				<td nowrap onclick="location.href='./gui_select_unit.php'" style="width: 100px;background:rgba(81,125,37,1.0);">
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
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_unit.php'\" width=".$buttonWidth."><div class='unitselect_button_normal'><a href='./gui_create_unit.php'>ADD</a><br><span style='font-size:16px;'>Create a unit</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_game.php'\" width=".$buttonWidth."><div class='unitselect_button_active'><a href='./gui_create_game.php'>GAME</a><br><span style='font-size:16px;'>Game settings</span></div></td><td style='width:5px;'>&nbsp;</td>\n";
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

	<div id="header">
		<table align="center" class="options" cellspacing="4" cellpadding="4" border="0px" width="80%">
			<tr>
				<td valign="top" width="70%">
					<form>
						<table border="0" cellspacing="2" cellpadding="2">
							<tr>
								<td class='datalabel' nowrap colspan="1" align="left">
								<?php if ($LOCKED == 1) {
									echo "<a href='#' onClick='saveGameLock(".$GAMEID.", 0);'><span id='lockstatusicon'><i class='fa-solid fa-lock'></i></span></a>";
								} else {
									echo "<a href='#' onClick='saveGameLock(".$GAMEID.", 1);'><span id='lockstatusicon'><i class='fa-solid fa-lock-open'></i></span></a>";
								} ?>
								</td>
								<td colspan="3" class='datalabel' nowrap align="left">
									<input onchange="javascript:saveGameInfo(<?php echo $gid ?>);" type="text" id="GameTitle" style="width:250px;">  [ID: <?php echo $GAMEID; ?>]
									<script type="text/javascript">document.getElementById("GameTitle").setAttribute('value','<?php echo $TITLE; ?>');</script>
								</td>
							</tr>

							<tr>
								<td></td>
								<td colspan="3" class='datalabel' nowrap align="left">
										<input onchange="javascript:saveGameInfo(<?php echo $gid ?>);" type="text" id="GameBackground" style="width:300px;">
										<script type="text/javascript">document.getElementById("GameBackground").setAttribute('value','<?php echo $BACKGROUND; ?>');</script>
									<br><br>
								</td>
							</tr>

							<tr>
								<td></td>
								<td colspan="2" class='datalabel' nowrap align="left">
									Era: <select required style='width:180px;' name='GameEra' id='GameEra' size='1' onchange="javascript:saveGameInfo(<?php echo $gid ?>);">
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
									<br><br>
								</td>
								<td colspan="1" class='datalabel' nowrap align="left">
									Year: <input onchange="javascript:saveGameInfo(<?php echo $gid ?>);" type="text" id="GameYear" style="width:60px;">
									<script type="text/javascript">document.getElementById("GameYear").setAttribute('value','<?php echo $GAMEYEAR; ?>');</script>
									<br><br>
								</td>
							</tr>

							<tr>
								<td nowrap align="left" width="3%"><a href='#' onClick='javascript:saveGameAccessCode(<?php echo $gid ?>);'><i class="fa-solid fa-rotate-right"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td class='datalabel' nowrap align="left" width="3%">Access code:</td>
								<td class='datalabel' nowrap align="left" width="94%" id="accesscode">
									<?php echo $ACCESSCODE; ?>
								</td>
								<td class='datalabel' nowrap align="right" width="94%">
									<a href='#' onClick='saveGameInfo(<?php echo $gid ?>);'><i class='fa-solid fa-save'></i></a>&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
						</table>
					</form>
				</td>
				<td class='datalabel' nowrap valign="top" align="left" width="30%" rowspan="1">
					<div class="scroll-pane">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
	for($i=1; $i <= count($array_joinedUsers); $i++) {
		$joinedUserName = $array_joinedUsers[$i];
		$joinedUserId = $array_joinedUserIds[$i];
		echo "							<tr><td class='datalabel'>".$joinedUserName."</td><td nowrap align='right' width='3%'>&nbsp;&nbsp;&nbsp;<span style='font-size:16px;color:#ddd;' onclick='javascript:saveRemovedUserFromGame(".$gid.",\"".$joinedUserId."\");'><i class='fas fa-minus-square'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>\n";
	}
?>
						</table>
					</div>
				</td>
			</tr>

			<tr><td colspan="2"><hr></td></tr>

			<tr>
				<td class='datalabel' colspan="2">
					<form autocomplete="autocomplete_off_hack_xfr4!k">
						<table cellspacing="0" cellpadding="0" border="0px" width="100%">
							<?php
								if ($gid == $hgid) { // I am a member of my own hosted game, so I am joined nowhere else
									if (sizeOf($array_joinedUsers) == 0) {
										echo "							<tr>\n";
										echo "								<td colspan='1' class='datalabel' nowrap align='left'>Join:</td>\n";
										echo "								<td colspan='1' class='datalabel' nowrap align='left'>\n";
										echo "									<select required name='game' id='game' size='1' onchange='' style='width: 220px;'>\n";

										for ($i661 = 1; $i661 < sizeof($array_availableGamesToJoin); $i661++) { // ignore the first one, dummy game
											echo "										<option value='".$array_availableGamesToJoin[$i661]."'>".$array_availableGamesToJoin[$i661]."</option>\n";
										}

										echo "									</select>\n";
										echo "								</td>\n";
										echo "								<td colspan='1' class='datalabel' nowrap align='right'>Code:</td>\n";
										echo "								<td colspan='1' class='datalabel' nowrap align='center'><input autocomplete='autocomplete_off_hack_xfr4!k' required type='text' id='AccessCode' style='width: 100px;'></td>\n";
										echo "								<td colspan='1' class='datalabel' nowrap align='right'><a href='#' onClick='joinGame();'><i class='fas fa-plus-square'></i></a></td>\n";
										echo "							</tr>\n";
									} else {
										echo "							<tr>\n";
										echo "								<td colspan='5' class='datalabel' nowrap align='center'>You can not join! There are still players in your game.</td>\n";
										echo "							</tr>\n";
									}
								} else {
									echo "							<tr>\n";
									echo "								<td colspan='1' class='datalabel' nowrap align='left'>Leave:</td>\n";
									echo "								<td colspan='3' class='datalabel' nowrap align='left'>Game ".$gid."</td>\n";
									echo "								<td colspan='1' class='datalabel' nowrap align='right'><a href='#' onClick='leaveGame();'><i class='fas fa-minus-square'></i></a></td>\n";
									echo "							</tr>\n";
								}
							?>
						</table>
					</form>
				</td>
			</tr>

			<tr><td colspan="2"><hr></td></tr>

			<td colspan="2">
				<table align="left" cellspacing="0" cellpadding="0" border="0px">
					<tr>
						<td class='datalabel' onclick='javascript:resetGame(<?php echo $pid ?>);'>
							&nbsp;&nbsp;<a href='#' onClick='javascript:resetGame(<?php echo $pid ?>);'><i class="fas fa-fast-backward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td align='left' class='datalabel'>RESET Game (Set round to 1 / Repair all units)</td>
					</tr>
				</table>
			</td>
		</table>
	</div>

	<p align="center" class="footerInfo">Inaccessible games do NOT show up! Access code is needed to join!</p>

</body>

</html>
