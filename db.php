<?php
	require('./config.php');
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	if ($conn->connect_error) {
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Connection failed: " . $conn->connect_error);
	}
?>
