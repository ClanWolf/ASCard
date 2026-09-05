<?php

	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	ini_set('session.gc_maxlifetime', 36000);
	session_set_cookie_params(36000);
	session_start();

	// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	$pid = isset($_GET['pid']) ? $_GET['pid'] : "";
	$c = isset($_GET['c']) ? $_GET['c'] : "";
	$cc = isset($_GET['cc']) ? $_GET['cc'] : "";

	if (!($stmt_all = $conn->prepare("SELECT * FROM asc_player"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if(!$c == "") {
		if ($stmt_all->execute()) {
			$res = $stmt_all->get_result();

			$playeridfound = false;
			$confirmationcodematch = false;

			while ($row = $res->fetch_assoc()) {
				if ($row['playerid'] == $pid) {
					$playeridfound = true;
					if ($cc === $row['confirmation_code']) {
						$confirmationcodematch = true;

						// Update player to be confirmed and activated
						$errorMessage  = "CONFIRMING USER<br>";
						$errorMessage .= "PID: ".$pid." | ";
						$errorMessage .= "CC: ".$cc;

						// Update confirmation in player
						$sqlupdateconfirmplayer = "UPDATE asc_player SET confirmed=1, login_enabled=1 WHERE playerid=".$pid.";";
						if (mysqli_query($conn, $sqlupdateconfirmplayer)) {
							// Success updating confirmation (registration)
							logMsg("Success: Confirmed player with id ".$pid);
							$errorMessage .= "<br>SUCCESS!";
						} else {
							// Error
							logMsg("Error: " . $sqlupdateconfirmplayer . "<br>" . mysqli_error($conn));
							echo "Error: " . $sqlupdateconfirmplayer . "<br>" . mysqli_error($conn);
						}

						logMsg("Referring to: <meta http-equiv='refresh' content='0;url=./login.php?auto=0'>");
						echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=0'>";
					}
				}
			}
			if ($playeridfound == false) {
				$errorMessage = "ACCOUNT NOT FOUND!<br>";
			}
			if ($confirmationcodematch == false) {
				$errorMessage .= "CONFIRMATION CODE MISMATCH!<br>";
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
	<script type="text/javascript" src="./scripts/bCrypt.js" ></script>
	<script type="text/javascript" src="./scripts/salt.js" ></script>
	<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		*::selection {
			background-color:lightgreen;
		}
		*::-moz-selection {
			background-color:lightgreen;
		}
		input, select {
			width: 80px;
			vertical-align: middle;
			color: #000;
			border-width: 0px;
			padding: 2px;
			font-family: 'Pathway Gothic One', sans-serif;
		}
		select:focus, textarea:focus, input:focus {
			outline: none;
		}
		select:invalid, input:invalid {
			background: #ffffff;
		}
		select:valid, input:valid {
			background: #ffffff;
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
		div#form-wrapper {
			position:absolute;
			top:5%;
			right:0;
			left:0;
		}
		input[type="text"]::selection {
			background-color:green;
		}
		input, select, textarea {
			-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
					box-sizing: border-box;
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
				var errorOccured = "<?php if(isset($errormessage)) { echo '1'; } else { echo '0'; } ?>";
			},75);
		});
	</script>

	<div id="form-wrapper" style="text-align:center; vertical-align:middle">
		<?php
			if(isset($errorMessage)) {
				echo "<table cellspacing=10 cellpadding=10 border=0px><tr><td>\n";
				echo "<span style='color:red;font-size:32px;'>\n";
				echo $errorMessage."\n";
				echo "</span>\n";
				echo "<br>\n";
				echo "</td></tr></table>\n";
			}
		?>
	</div>
</body>

</html>
