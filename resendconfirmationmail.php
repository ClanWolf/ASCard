<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	ini_set('session.gc_maxlifetime', 36000);
	session_set_cookie_params(36000);
	session_start();

	// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');

	$pn   = isset($_POST['pn']) ? $_POST['pn'] : "";
	$mail = isset($_POST['mail']) ? $_POST['mail'] : "";

	if (!empty($pn) && !empty($mail)) {
		$sql_pending = "SELECT SQL_NO_CACHE * FROM asc_player WHERE name = '".$pn."' AND email = '".$mail."'";
		$result_pending = mysqli_query($conn, $sql_pending);
		if (mysqli_num_rows($result_pending) > 0) {
			while($row47 = mysqli_fetch_assoc($result_pending)) {
				$newplayerid = $row47["playerid"];
				$confirmcode = $row47["confirmation_code"];
				$playeremail = $row47["email"];

				$confirmationlink = "https://www.ascard.net/app/registerconfirm.php?c=1&pid=".$newplayerid."&cc=".$confirmcode;
				// send email.
				$from = "admin@ascard.net";
				$to = $playeremail;
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
					$errorMessage = "EMAIL SENT TO " . $pn . " (" . $mail . ")";
				} else {
					$errorMessage = "ERROR WHILE SENDING EMAIL!";
				}
			}
		} else {
			$errorMessage = "NO PLAYER FOUND!";
		}
	} else {
		if (isset($_POST['pn']) && isset($_POST['mail'])) {
			$errorMessage = "MISSING EMAIL OR NAME!";
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
		$(document).ready(function() {
    		document.getElementById("f1").style.visibility = "visible";
    		document.getElementById("pn").value = '<?php echo $pn; ?>';
    		document.getElementById("mail").value = '<?php echo $mail; ?>';
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
				echo "<form id='f1' style='visibility:hidden;' method='post' autocomplete='on'>\n";
			} else {
				echo "<form id='f1' style='visibility:hidden;' method='post' autocomplete='on'>\n";
			}
		?>
			<table class="loginbox" cellspacing=10 cellpadding=10 border=0px>
				<tr>
					<td class='unitselect_button_active'>
						<input placeholder='Username' type='text' size='20' maxlength='80' style='width:250px;height=60px;' id='pn' name='pn' required autocomplete='userName'><br>
						<input placeholder="EMAIL" type="email" size="20" style='width:250px;height=60px;border:0px;' maxlength="32" id="mail" name="mail" autocomplete="mail" required><br><br>
						<input type="submit" id="submitbutton" size="50" value="RESEND">&nbsp;
						<input type="button" id="loginbutton" size="50" value="CANCEL" onclick="location.href='login.php?auto=0';"><br>
					</td>
				</tr>
			</table>
		</form>
	</div>

</body>

</html>
