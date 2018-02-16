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
