<?php
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	ini_set("display_errors", 1); error_reporting(E_ALL);
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
			while ($row = $res->fetch_assoc()) {
				if ($row['name'] == $playername) {
					$password_db = $row['password'];
					// var_dump($password_db);
					if (password_verify($password, $password_db)) {
						$_SESSION['playerid'] = $row['playerid'];
						$_SESSION['name'] = $row['name'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['playerimage'] = $row['image'];
						// getting options from database
						$sql_asc_options = "SELECT SQL_NO_CACHE * FROM asc_options where playerid = ".$_SESSION['playerid'];
						$result_asc_options = mysqli_query($conn, $sql_asc_options);
						if (mysqli_num_rows($result_asc_options) > 0) {
							while($row11 = mysqli_fetch_assoc($result_asc_options)) {
								$opt1 = $row11["option1"];
								$opt2 = $row11["option2"];
								$opt3 = $row11["option3"];
								$_SESSION['option1'] = $opt1;
								$_SESSION['option2'] = $opt2;
								$_SESSION['option3'] = $opt3;
							}
						}
   						echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'>";
   						header("Location: ./gui_select_unit.php");
						//die('Login succeeded!<br>');
					} else {
						$errorMessage = "LOGIN FAILED!<br>";
					}
				}
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='viewport' content='user-scalable=0'>

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="./styles/cookieconsent.css" />
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

	<script type="text/javascript" src="./scripts/jquery-3.6.0.min.js"></script>
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
		.box {
			width: 500px;
			height: 200px;
			background-color: #694007;
			position: fixed;
			margin-left: -250px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
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
					"message": "This app uses cookies to store options and values. No personal data is stored. To use the app, you need to confirm (DSGVO, 2022).",
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
				//console.log(errorOccured);
				if (auto == '1' && errorOccured == 0) {
					//console.log("autologin");
					document.getElementById("f1").submit();
				}
  			},100);
		});

        function storeCredentials() {
            console.log("Storing!");
            var pn_1 = $('#pn').val();
            var pw_1 = $('#pw').val();
            setCookie("ASCards_un", pn_1, 365);
            setCookie("ASCards_pw", pw_1, 365);
            //alert("test");
        }
	</script>

	<?php
		if(isset($errorMessage)) {
			echo "<table cellspacing=10 cellpadding=10 border=0px><tr><td><br>";
			echo "<span style='color:red; font-size: 42px;'>";
			echo $errorMessage;
			echo "</span>";
			echo "</td></tr></table>";
		}
	?>

	<form id="f1" onsubmit="storeCredentials();" style="visibility:hidden;" action="?login=1" method="post" autocomplete="on">
		<table class="box" cellspacing=10 cellpadding=10 border=0px>
			<tr>
				<td class='mechselect_button_active'>
					<img src="./images/icon_144x144.png">
				</td>
				<td class='mechselect_button_active'>
	                <?php
				        echo "<select style='width:260px;height=60px;' name='pn' size='1' maxlength='80' id='pn'>";
                        echo $userlist;
                        echo "</select><br>";
                    ?>
					<!-- <input type="text" size="20" maxlength="80"  style='width:250px;height=60px;' id="pn" name="pn" required autocomplete="userName"><br> -->
					<input type="text" size="20" style='width:250px;height=60px;' maxlength="32" id="pw" name="pw" required autocomplete="current-password"><br><br>
					<input type="submit" id="submitbutton" size="50" style="width:250px;height=60px;" value="LOGIN"><br>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
