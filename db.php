<?php
	require('./config.php');
	$conn = mysqli_connect($db_host, $db_user, $db_pass);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>