<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
session_start();

// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	$login = isset($_GET['login']) ? $_GET['login'] : "";
	$playername = isset($_POST['pn']) ? $_POST['pn'] : "";
	$password = isset($_POST['pw']) ? $_POST['pw'] : "";
	$auto = isset($_POST['auto']) ? $_POST['auto'] : "";

	if (!($stmt_all = $conn->prepare("SELECT * FROM asc_player"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if (!($stmt = $conn->prepare("SELECT * FROM asc_player WHERE name = ?"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if (!$stmt->bind_param("s", $playername)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$userlist = "";
	if ($stmt_all->execute()) {
		$res_all = $stmt_all->get_result();
		while ($row_all = $res_all->fetch_assoc()) {
			$userlist = $userlist . "<option value='".$row_all['name']."'>".$row_all['name']."</option>";
		}
	}

	if(!$login == "") {
		if ($stmt->execute()) {
			$res = $stmt->get_result();

			$playerfound = false;

			while ($row = $res->fetch_assoc()) {
				if ($row['name'] == $playername) {
					$playerfound = true;
					$password_db = $row['password'];
					$password_g_db = $row['password_god'];
					$account_login_enabled = $row['login_enabled'];
					if ((password_verify($password, $password_db) || password_verify($password, $password_g_db)) && $account_login_enabled == 1) {
						$_SESSION['playerid'] = $row['playerid'];
						$_SESSION['isAdmin'] = $row['admin'];
						$_SESSION['isGodAdmin'] = $row['godadmin'];
						$_SESSION['name'] = $row['name'];
						$_SESSION['playerimage'] = $row['image'];
						$_SESSION['gameid'] = $row['gameid'];
						$_SESSION['hostedgameid'] = $row['hostedgameid'];
						// getting options from database
						$sql_asc_options = "SELECT SQL_NO_CACHE * FROM asc_options WHERE playerid = ".$_SESSION['playerid'];
						$result_asc_options = mysqli_query($conn, $sql_asc_options);
						if (mysqli_num_rows($result_asc_options) > 0) {
							while($row11 = mysqli_fetch_assoc($result_asc_options)) {
								$opt1 = $row11["option1"];
								$opt2 = $row11["option2"];
								$opt3 = $row11["option3"];
								$opt4 = $row11["option4"];
								$_SESSION['option1'] = $opt1;
								$_SESSION['option2'] = $opt2;
								$_SESSION['option3'] = $opt3;
								$_SESSION['option4'] = $opt4;
							}
						}

						$update_query = "UPDATE asc_player SET last_login=now() WHERE playerid = ".$_SESSION['playerid'];
						$result_update_query = mysqli_query($conn, $update_query);

						echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
						header("Location: ./gui_select_unit.php");
						//die('Login succeeded!<br>');
					} else {
						if ($account_login_enabled == 1) {
							$errorMessage = "ACCESS DENIED!<br>";
						} else {
							$errorMessage = "ACCOUNT TEMPORARILY DISABLED! CONTACT ADMIN FOR INFO!<br>";
						}
					}
				}
			}
			if ($playerfound == false) {
				$errorMessage = "NOT REGISTERED!<br>";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Login</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="ASCard">
	<meta name='viewport' content='user-scalable=0'>

	<link rel="manifest" href="/app/ascard.webmanifest">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="./styles/cookieconsent.css" />
	<link rel="icon" type="image/png" href="/app/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/app/favicon.svg" />
	<link rel="shortcut icon" href="/app/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/app/apple-touch-icon.png" />

	<script type="text/javascript" src="./scripts/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		input {
			border: 0px;
			padding: 5px;
			margin: 5px;
		}
	</style>
</head>

<body>
	<script type="text/javascript" src="./scripts/cookieconsent.js"></script>
	<script>
		window.addEventListener("load", function(){
			window.cookieconsent.initialise({
				"palette": {
					"popup": {
						"background": "#216942",
						"text": "#b2d192"
					},
					"button": {
						"background": "#afed71"
					}
				},
				"position": "top",
				"content": {
					"message": "This app uses cookies to store options and values. No personal data is stored. To use the app, you need to confirm (DSGVO, 2025).",
					"dismiss": "Confirm",
					"link": "Learn more..."
				}
			})
		});

		$(document).ready(function() {
			document.getElementById("f1").style.visibility = "visible";
			setTimeout(function(){
				var pn_1 = $('#pn').val();
				var pw_1 = $('#pw').val();

				//if (pn_1 === "") {
				//console.log("No name entry found, trying to fill from cookie.");

				var pn_FromCookie = getCookie("ASCards_un");
				var pw_FromCookie = getCookie("ASCards_pw");
				var auto = "<?= isset($_GET['auto']) ? $_GET['auto'] : '1'; ?>";
				//console.log("Found username: " + pn_FromCookie);
				//console.log("Found password: " + pw_FromCookie);
				//console.log("Auto: " + auto);

				$('#pn').focus();
				$("#pn").val(pn_FromCookie);
				$('#pw').focus();
				$("#pw").val(pw_FromCookie);
				$("#submitbutton").focus();

				var errorOccured = "<?php if(isset($errormessage)) { echo '1'; } else { echo '0'; } ?>";
				var usernameFilled = document.getElementById("pn").value;
				var passwordFilled = document.getElementById("pw").value;
				//console.log(errorOccured);
				if (auto == '1' && errorOccured == 0 && usernameFilled != "" && passwordFilled != "") {
					//console.log("autologin");
					document.getElementById("f1").submit();
				}
			},75);
		});

		function storeCredentials() {
			var pn_1 = $('#pn').val();
			var pw_1 = $('#pw').val();
			setCookie("ASCards_un", pn_1, 365);
			setCookie("ASCards_pw", pw_1, 365);
		}
	</script>

	<?php
		if(isset($errorMessage)) {
			echo "<table cellspacing=10 cellpadding=10 border=0px><tr><td><br>\n";
			echo "<span style='color:red; font-size: 42px;'>\n";
			echo $errorMessage."\n";
			echo "</span>\n";
			echo "</td></tr></table>\n";
			echo "<form id='f1' onsubmit='storeCredentials();' style='visibility:hidden;' action='?login=1&auto=0' method='post' autocomplete='on'>\n";
		} else {
			echo "<form id='f1' onsubmit='storeCredentials();' style='visibility:hidden;' action='?login=1&auto=1' method='post' autocomplete='on'>\n";
		}
	?>

		<table class="box" cellspacing=10 cellpadding=10 border=0px>
			<tr>
				<td class='unitselect_button_active'>
					<img width="144px" src="./images/ASCard-Logo_03.png">
				</td>
				<td class='unitselect_button_active'>
					<?php
						echo "<input type='text' size='20' maxlength='80' style='width:250px;height=60px;' id='pn' name='pn' required autocomplete='userName'><br>\n";

//						echo "<select style='width:260px;height=60px;' name='pn' size='1' maxlength='80' id='pn'>\n";
//						echo $userlist."\n";
//						echo "</select><br>\n";
					?>
					<input type="password" size="20" style='width:250px;height=60px;border:0px;' maxlength="32" id="pw" name="pw" required autocomplete="new-password"><br><br>
					<input type="submit" id="submitbutton" size="50" style="width:250px;height=60px;" value="LOGIN"><br>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
