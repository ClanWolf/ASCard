<?php
	session_start();
	// https://www.php-einfach.de/php-tutorial/php-sessions/

	if(isset($_GET['login'])) {
		$userid = -1;
		$email = $_POST['email'];
		$passwort = $_POST['password'];

		$sql = "SELECT * FROM asc_player WHERE email = ".$email;
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if ($row["email"] == $email) {
					$password_db = $row["password"];
					if (password_verify($passwort, $password_db)) {
						$_SESSION['userid'] = $user['id'];
						die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
					} else {
						$errorMessage = "Invalid login!<br>";
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
