<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

	if(isset($_GET['login'])) {
		$userid = -1;
		$email = $_POST['email'];
		$passwort = $_POST['password'];

		if (!($stmt = $mysqli->prepare("SELECT * FROM asc_player WHERE email = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if ($stmt->execute($email)) {
			while ($row = $stmt->fetch()) {
				if ($row["email"] == $email) {
					$password_db = $row["password"];
					if (password_verify($passwort, $password_db)) {
						$_SESSION['playerid'] = $row['playerid'];
   						header("Location: ./unitselector.php");
						die('Login succeeded!<br>');
					} else {
						$errorMessage = "Login failed!<br>";
					}
				}
			}
		}
	}
?>

<html lang="en">

<head>
	<title>Login</title>
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
			background-image: url('./images/body-bg_2.png');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 400px;
			height: 200px;
			background-color :#transparent;
			position: fixed;
			margin-left: -200px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
		}
	</style>
</head>

<body>
	<?php
		if(isset($errorMessage)) {
			echo $errorMessage;
		}
	?>

	<form action="?login=1" method="post">
		E-Mail:<br>
		<input type="email" size="40" maxlength="250" name="email"><br><br>
        Password:<br>
		<input type="password" size="40"  maxlength="250" name="passwort"><br>
        <input type="submit" value="Login">
	</form>
</body>

</html>
