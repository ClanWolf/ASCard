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
		}
	} else {
		// this player does not have a game yet
		if (endsWith($pname, 's')) {
			$background = $pname . "&#039; game";
		} else {
			$background = $pname . "&#039;s game";
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
		} else {
			// Error
			echo "Error: " . $sqlinsertgame . "<br>" . mysqli_error($conn);
		}
	}

	$array_joinedUsers = array();
	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player;";
	$result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
	if (mysqli_num_rows($result_asc_playerround) > 0) {
		$i = 1;
		while($row = mysqli_fetch_assoc($result_asc_playerround)) {
			if ($GAMEID == $row["gameid"]) {
				// this player is joined in the game of the currently logged in player
				$array_joinedUsers[$i] = $row["name"];
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
			height: 100px;
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
        $(document).ready(function() {
            $("#cover").hide();
        });
        function resetRound(playerId) {
            var url="./save_reset_round.php?pid=" + playerId;
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
				<td style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' height='60px'></td>
			</tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_disclaimer.php">Disclaimer</a></div>

	<br>

	<div id="header">
		<table width="60%" align="center" class="options" cellspacing="4" cellpadding="4" border="0px">
			<tr>
				<td valign="top" width="75%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class='datalabel' nowrap colspan="3" align="left">&quot;<?php echo $BACKGROUND; ?>&quot; [ID: <?php echo $GAMEID; ?>]
							<?php if ($LOCKED == 0) {
								echo "&nbsp;&nbsp;&nbsp;<a href='#' onClick='unlockGame();'><i class='fa-solid fa-lock'></i></i></a>";
							} else {
								echo "&nbsp;&nbsp;&nbsp;<a href='#' onClick='lockGame();'><i class='fa-solid fa-lock-open'></i></a>";
							} ?>
							</td>
						</tr>
						<tr>
							<td class='datalabel' nowrap align="left" width="3%">Access code:</td><td nowrap align="left" width="3%">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-rotate-right"></i></td><td class='datalabel' nowrap align="left" width="94%">&nbsp;&nbsp;&nbsp;<?php echo $ACCESSCODE; ?>
						</tr>
					</table>
				</td>
				<td class='datalabel' nowrap valign="top" align="left" width="25%" rowspan="3">
					Joined players:<br><br>
					<div class="scroll-pane">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<?php
						foreach ($array_joinedUsers as &$value) {
							echo "<tr><td nowrap align='left' width='3%'><i class='fas fa-minus-square'></i></td><td class='datalabel'>&nbsp;&nbsp;&nbsp;" . $value . "</td><td nowrap align='right' width='3%'>&nbsp;&nbsp;&nbsp;<i class='fas fa-minus-square'></i></td></tr>";
						}
						?>
						</table>
					</div>
				</td>
			</tr>
			<tr><td colspan="1"><hr></td></tr>
			<tr>
				<td class='datalabel' colspan="1">
					<form autocomplete="autocomplete_off_hack_xfr4!k">
						<table cellspacing="0" cellpadding="0" border="0px" width="100%">
							<tr>
								<td colspan="1" class='datalabel' nowrap align="left">Join:</td>
								<td colspan="1" class='datalabel' nowrap align="left">
								<select required name='game' id='game' size='1' onchange="" style="width: 220px;">
								<?php
									for ($i661 = 1; $i661 < sizeof($array_availableGamesToJoin); $i661++) { // ignore the first one, dummy game
										echo "<option value='" . $array_availableGamesToJoin[$i661] . "'>" . $array_availableGamesToJoin[$i661] . "</option>";
									}
								?>
								</select>
								</td>
								<td colspan="1" class='datalabel' nowrap align="right">Code:</td>
								<td colspan="1" class='datalabel' nowrap align="center"><input autocomplete="autocomplete_off_hack_xfr4!k" required type="text" id="AccessCode" style="width: 100px;"></td>
								<td colspan="1" class='datalabel' nowrap align="right"><a href="#" onClick="joinGame();"><i class="fas fa-plus-square"></i></a></td>
							</tr>
							<tr>
								<td colspan="1" class='datalabel' nowrap align="left">Leave:</td>
								<?php
								if ($gid == 1) {
									echo "<td colspan='6' class='datalabel' nowrap align='left'>I am NOT in any game.</td>";
								} else {
									echo "<td colspan='6' class='datalabel' nowrap align='left'><a href='#' onClick='leaveGame();'><i class='fas fa-minus-square'></i>&nbsp;&nbsp;&nbsp;(Game " . $gid . ")</a></td>";
								}
								?>
							</tr>

						</table>
					</form>
				</td>
			</tr>

			<tr>
				<td align='left' class='datalabel'>RESET Round (to 1)</td>
				<td onclick='javascript:resetRound(<?php echo $pid ?>);'>
					<i class='fa-solid fa-cloud-arrow-down'></i>
				</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<td align='left' class='datalabel'>RESET all Units (Remove damage)</td>
				<td onclick=''>
					<i class='fa-solid fa-cloud-arrow-down'></i>
				</td>
			</tr>
		</table>
	</div>

	<p align="center" class="footerInfo">Inaccessible games do NOT show up! Access code is needed to join!</p>

</body>

</html>
