<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./db.php');

	ini_set("display_errors", 1); error_reporting(E_ALL);
	$login = isset($_GET['login']) ? $_GET['login'] : "";
	$playername = isset($_POST['pn']) ? $_POST['pn'] : "";
	$password = isset($_POST['pw']) ? $_POST['pw'] : "";

	if(!$login == "") {
		if (!($stmt = $conn->prepare("SELECT * FROM asc_player WHERE name = ?"))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		if (!$stmt->bind_param("s", $playername)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
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
   						header("Location: ./gui_selectunit.php");
						die('Login succeeded!<br>');
					} else {
						$errorMessage = "LOGIN FAILED!<br>";
					}
				}
			}
		}
	}
?>

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
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" href="./styles/styles.css" type="text/css">
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
	<?php
		if(isset($errorMessage)) {
			echo "<table cellspacing=10 cellpadding=10 border=0px><tr><td><br><br><br>";
			echo "<span style='color:red; font-size: 42px;'>";
			echo $errorMessage;
			echo "</span>";
			echo "</td></tr></table>";
		}
	?>

	<form action="?login=1" method="post">
		<table class="box" cellspacing=10 cellpadding=10 border=0px>
			<tr>
				<td class='mechselect_button_active'>
					<img src="./images/icon_144x144.png">
				</td>
				<td class='mechselect_button_active'>
					<input type="text" size="20" maxlength="80" id="pn" name="pn"><br>
					<input type="password" size="20"  maxlength="32" id="pw" name="pw"><br><br>
					<input type="submit" size="50" style="width:200px" value="LOGIN"><br>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
