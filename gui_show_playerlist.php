<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();
	// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 6");
	}

	$pid = $_SESSION['playerid'];
	$gid = $_SESSION['gameid'];
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Edit Player</title>
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

	<!-- <meta http-equiv="refresh" content="10" /> -->

	<link rel="manifest" href="/app/ascard.webmanifest">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
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
			//$('.scroll-pane').jScrollPane({autoReinitialise: true});
			$('.scroll-pane').jScrollPane();
		});
		$(document).ready(function() {
			$("#cover").hide();
		});
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
				<td nowrap onclick="location.href='./gui_edit_game.php'" style="width: 100px;background:rgba(56,87,26,1.0);">
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
				<td nowrap onclick="location.href='gui_show_playerlist.php'" style="width: 60px;" nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' style='height:auto;display:block;' width='60px' height='60px'></td>
			</tr>
			<tr><td colspan='999' style='background:rgba(50,50,50,1.0);height:5px;'></td></tr>
		</table>
	</div>

	<div id="liberapay"><a href="./gui_show_support.php"><i class="fa-solid fa-handshake-simple"></i></a></div>
	<div id="disclaimer"><a href="./gui_show_disclaimer.php">Disclaimer</a></div>

	<br>

	<table class="options" cellspacing="2" cellpadding="2" border="0px" width="50%">

<?php
	if (!($stmt = $conn->prepare("SELECT SQL_NO_CACHE * FROM asc_player ORDER BY last_login desc"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	function timeDiff($firstTime,$lastTime) {
		// echo "jetzt:".$lastTime." - lastlogin:".$firstTime." = ".$timeDiff."<br>";

		$firstTime=strtotime($firstTime);
		$lastTime=strtotime($lastTime);
		$timeDiff=($lastTime - $firstTime);

		// echo $lastTime." - ".$firstTime." = ".$timeDiff."<br>";

		return $timeDiff;
	}

	if ($stmt->execute()) {
		$res = $stmt->get_result();
		$myOwnLine = "";
		$userList = "";

		while ($row = $res->fetch_assoc()) {
			$filename = "./images/player/".$row['image'];
			$last_login = $row['last_login'];

			if ($row['playerid'] == $pid) {
				$myOwnLine .= "							<tr>\n";
				$myOwnLine .= "								<td>\n";
				if (file_exists($filename)) {
					$myOwnLine .= "										<img src='./images/player/".$row['image']."' width='30px' height='30px'>\n";
				} else {
					$myOwnLine .= "										<img src='./images/pilots/000_no_avatar.png' width='30px' height='30px'>\n";
					copy("./images/pilots/000_no_avatar.png", "./images/player/".$row['image']);
				}
				$myOwnLine .= "								</td>\n";
				$myOwnLine .= "								<td colspan='3'>".$row['name']."</td>\n";
				$myOwnLine .= "								<td onclick=\"location.href='./gui_edit_player.php?pid=".$pid."'\" width='10' align='right' valign='middle'><i class='fas fa-edit'></i></td>\n";
				$myOwnLine .= "							</tr>\n";
				$myOwnLine .= "							<tr>\n";
				$myOwnLine .= "								<td colspan='5'><hr></td>\n";
				$myOwnLine .= "							</tr>\n";
			} else {
				$diff = timeDiff($last_login, date('Y-m-d H:i:s'));
				$statusIcon = "<span style='color:black;'><i class='fa-solid fa-circle'></i></span>";

				if ($diff < 60 * 60 * 5) { // 5 hours
					$statusIcon = "<span style='color:red;'><i class='fa-solid fa-circle'></i></span>";
				}
				if ($diff < 60 * 60) { // 1 hour
					$statusIcon = "<span style='color:yellow;'><i class='fa-solid fa-circle'></i></span>";
				}
				if ($diff < 60 * 15) { // 15 minutes
					$statusIcon = "<span style='color:green;'><i class='fa-solid fa-circle'></i></span>";
				}

				$userList .= "							<tr>\n";
				$userList .= "								<td nowrap class='datalabel' width='10%' style='font-size:10px; text-align:left;';>".$statusIcon."</td>\n";
				$userList .= "								<td nowrap class='datalabel' width='10%' style='text-align:left;vertical-align:middle;' valign='middle'>\n";
				if (file_exists($filename)) {
					$userList .= "										<img src='./images/player/".$row['image']."' width='30px' height='30px'>\n";
				} else {
					$userList .= "										<img src='./images/pilots/000_no_avatar.png' width='30px' height='30px'>\n";
					copy("./images/pilots/000_no_avatar.png", "./images/player/".$row['image']);
				}
				$userList .= "								</td>\n";
				$userList .= "								<td nowrap class='datalabel' width='60%' style='text-align:left;' colspan='2'>" . $row['name'] . "</td>\n";
				$userList .= "								<td width='20%' nowrap align='right'>\n";
				$userList .= "									".$last_login."&nbsp;&nbsp;&nbsp;\n";
				$userList .= "								</td>\n";
				$userList .= "							</tr>\n";
			}
		}
		echo $myOwnLine;
		echo "							<tr>\n";
		echo "								<td colspan='5'>\n";
		echo "									<div class=\"scroll-pane\">\n";
		echo "										<table width='100%' cellspacing='2' cellpadding='2' border='0px'>\n";
		echo $userList;
		echo "										</table>\n";
		echo "									</div>\n";
		echo "								</td>\n";
		echo "							</tr>\n";
	}
?>

	</table>
</body>

</html>
