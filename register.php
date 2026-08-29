<?php
    declare(strict_types=1);

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
	$register = isset($_GET['register']) ? $_GET['register'] : "";
	$newplayername = isset($_POST['pn']) ? $_POST['pn'] : "";
	$password = isset($_POST['pw']) ? $_POST['pw'] : "";
	$password_repeat = isset($_POST['pwr']) ? $_POST['pwr'] : "";
	$mail = isset($_POST['mail']) ? $_POST['mail'] : "";

	$newplayerfactionid = 3; // ComStar

	if (!($stmt_all = $conn->prepare("SELECT * FROM asc_player"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	function validateTurnstile($token, $secret, $remoteip = null) {
		$url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
		$data = [ 'secret' => $secret, 'response' => $token ];
		if ($remoteip) {
			$data['remoteip'] = $remoteip;
		}
		$options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			]
		];
		$context = stream_context_create($options);
		$response = file_get_contents($url, false, $context);

		if ($response === FALSE) {
			return ['success' => false, 'error-codes' => ['internal-error']];
		}
		return json_decode($response, true);
	}

	if(!$register == "") {
		$secret_key = $TURNSTILE_SECRET_KEY;
		$token = $_POST['cf-turnstile-response'] ?? '';
		$remoteip = $_SERVER['HTTP_CF_CONNECTING_IP'] ??
		$_SERVER['HTTP_X_FORWARDED_FOR'] ??
		$_SERVER['REMOTE_ADDR'];
		$validation = validateTurnstile($token, $secret_key, $remoteip);
		if ($validation['success']) {
			// Valid token - process form

			// $errorMessage = "Form submission successful!";

			$userlist = "";
			if ($stmt_all->execute()) {
				$res = $stmt_all->get_result();

				$playernamefound = false;
				$playeremailfound = false;
				$passwordok = false;

				if ($password == $password_repeat) {
					$passwordok = true;
				}

				while ($row = $res->fetch_assoc()) {
					if ($row['name'] == $newplayername) {
						$playernamefound = true;
					}
					if ($row['email'] == $mail) {
						$playeremailfound = true;
					}
					$userlist = $userlist.$row['name']." [".$row['email']."];";
				}
				if ($playernamefound == false) {
					if ($playeremailfound == false) {
						if ($passwordok) {
							// Register the player
							$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
							$confirmcode = substr(str_shuffle($str_result), 0, 16);
							//$errorMessage = "WILL REGISTER NOW ".$confirmcode."<br>";

							$hashedpw = password_hash($password, PASSWORD_DEFAULT);

							// new user can be inserted
							$sql = "INSERT INTO asc_player (confirmed, confirmation_code, login_enabled, name, email, password, admin, factionid, image) VALUES (0, '".$confirmcode."',0, '".$newplayername."', '".$mail."', '".$hashedpw."', 0, ".$newplayerfactionid.", '".$newplayername.".png')";
							if (mysqli_query($conn, $sql)) {
								// Success
								$newplayerid = mysqli_insert_id($conn);

								$sqlinsertcommand = "INSERT INTO asc_command (playerid, factionid, type, commandname, commandbackground) VALUES ";
								$sqlinsertcommand = $sqlinsertcommand . "(".$newplayerid.", ".$newplayerfactionid.", 'custom', 'Commandname', 'Commandbackground')";
								if (mysqli_query($conn, $sqlinsertcommand)) {
									// Success inserting formations for new player
								} else {
									// Error
									echo "Error: " . $sqlinsertcommand . "<br>" . mysqli_error($conn);
								}
								$newcommandid = mysqli_insert_id($conn);

								$sqlinsertformation = "INSERT INTO asc_formation (factionid, commandid, formationname, formationshort, playerid) VALUES ";
								$sqlinsertformation = $sqlinsertformation . "(".$newplayerfactionid.", ".$newcommandid.", 'Command', 'Command', ".$newplayerid."), ";
								$sqlinsertformation = $sqlinsertformation . "(".$newplayerfactionid.", ".$newcommandid.", 'Battle', 'Battle', ".$newplayerid."), ";
								$sqlinsertformation = $sqlinsertformation . "(".$newplayerfactionid.", ".$newcommandid.", 'Striker', 'Striker', ".$newplayerid.")";
								if (mysqli_query($conn, $sqlinsertformation)) {
									// Success inserting formations for new player
								} else {
									// Error
									echo "Error: " . $sqlinsertformation . "<br>" . mysqli_error($conn);
								}

								// Create options entry for new user
								$sqlinsertoptions = "INSERT INTO asc_options (playerid, option1, option2, option3, UseMULImages) VALUES ";
								$sqlinsertoptions = $sqlinsertoptions . "(".$newplayerid.", 1, 1, 1, 0)";
								if (mysqli_query($conn, $sqlinsertoptions)) {
									// Success inserting options for new player
								} else {
									// Error
									echo "Error: " . $sqlinsertoptions . "<br>" . mysqli_error($conn);
								}

								// Update commandid in player table
								$sqlupdatecommandforplayer = "UPDATE asc_player SET commandid=".$newcommandid." WHERE playerid=".$newplayerid.";";
								if (mysqli_query($conn, $sqlupdatecommandforplayer)) {
									// Success updating player (adding commandid)
								} else {
									// Error
									echo "Error: " . $sqlupdatecommandforplayer . "<br>" . mysqli_error($conn);
								}

								$confirmationlink = "https://www.ascard.net/app/registerconfirm.php?c=1&pid=".$newplayerid."&cc=".$confirmcode;

								// send email.
								$from = "admin@ascard.net";
								$to = "warwolfen@gmail.com";
								$subject = "ASCard account confirmation";

								$message  = "Greetings MechWarrior!\r\n\r\n";
								$message .= "This email adress was used to create an account for ASCard.net.\r\n";
								$message .= "If you created the account, you need to confirm your email by clicking this link:\r\n";
								$message .= $confirmationlink . "\r\n\r\n";
								$message .= "Good hunting!";

								$headers = "From:" . $from . "\r\n";
								$headers .= "Reply-To:" . $from . "\r\n";
								$additional_params = "-f " . $from;
								if (mail($to, $subject, $message, $headers, $additional_params)) {
									echo "<p>Email sent successfully.</p>";
								} else {
									echo "<p>Email delivery failed.</p>";
								}

								echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
							} else {
								// Error
								echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							}
						} else {
							$errorMessage = "PASSWORD IS INCORRECT!<br>";
						}
					} else {
						$errorMessage = "EMAIL WAS ALREADY USED!<br>";
					}
				} else {
					$errorMessage = "PLAYER NAME IS ALREADY REGISTERED!<br>";
				}
			}
		} else {
			// Invalid token - show error
			$errorMessage = "Verification failed. Please try again.";
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

				$('#pn').focus();
				$("#pn").val("<?php echo $newplayername ?>");
				$('#pw').focus();
				$("#pw").val("<?php echo $password ?>");
				$('#pwr').focus();
				$("#pwr").val("<?php echo $password_repeat ?>");
				$('#mail').focus();
				$("#mail").val("<?php echo $mail ?>");
				$("#submitbutton").focus();
			},75);
		});

		function storeCredentials() {
			var pn_1 = $('#pn').val();
			var pw_1 = $('#pw').val();
			setCookie("ASCards_un", pn_1, 365);
			setCookie("ASCards_pw", pw_1, 365);
		}
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
				echo "<form id='f1' onsubmit='storeCredentials();' style='visibility:hidden;' action='?register=1' method='post' autocomplete='on'>\n";
			} else {
				echo "<form id='f1' onsubmit='storeCredentials();' style='visibility:hidden;' action='?register=1' method='post' autocomplete='on'>\n";
			}
		?>
			<table class="registerbox" cellspacing=10 cellpadding=10 border=0px>
				<tr>
					<td class='unitselect_button_active'>
						<img width="144px" src="./images/ASCard-Logo_03.png"><br><br>
					</td>
					<td>
						<?php
							echo "<input placeholder='Username' type='text' size='20' maxlength='80' style='width:250px;height=60px;' id='pn' name='pn' required autocomplete='userName'><br>\n";
//							echo "<select style='width:260px;height=60px;' name='pn' size='1' maxlength='80' id='pn'>\n";
//							echo $userlist."\n";
//							echo "</select><br>\n";
						?>
						<input placeholder="Password" size="20" style='width:250px;height=60px;border:0px;' maxlength="32" id="pw" name="pw" required autocomplete="new-password">
						<input placeholder="Password repeat" size="20" style='width:250px;height=60px;border:0px;' maxlength="32" id="pwr" name="pwr" required autocomplete="new-password-repeat">
						<input placeholder="Email" type="email" size="20" style='width:250px;height=60px;border:0px;' maxlength="32" id="mail" name="mail" required autocomplete="mail"><br><br>
						<input type="submit" id="submitbutton" size="50" value="REGISTER">
						<input type="button" id="loginbutton" size="50" value="CANCEL" onclick="location.href='login.php?auto=0';"><br>
					</td>
				</tr>
			</table>
			<br>
			<?php
				// <!-- VERIFY! https://webcheatsheet.com/php/create_captcha_protection -->
				// <!-- https://dash.cloudflare.com/1f085dd8b2db8f93a43efeec9ce0531e/turnstile -->
			?>
			<div class="cf-turnstile" data-sitekey="0x4AAAAAAEebVNLCMTtW5-N3"></div>
		</form>
	</div>
</body>

</html>
